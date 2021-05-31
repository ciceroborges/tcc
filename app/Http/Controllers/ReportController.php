<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'patient_id' => 'sometimes|int',
            'department_id' => 'sometimes|int',
            'status' =>  ['sometimes', Rule::in(['ALL', 'WAITING', 'IN PROGRESS', 'CANCELED', 'CONCLUDED'])],
            'initial_date' => 'sometimes|date',
            'end_date' => 'sometimes|date',
        ]);

        if ($validation->fails()) {
            return response([
                'e' => true,
                'flag' => 'error',
                //'message' => 'Um ou mais filtros foram informados de maneira errada, verifique e tente novamente.',
                'message' => 'Um ou mais filtros foram informados de maneira errada, verifique e tente novamente.',
                'status' => 0
            ], 400);
        }
        /* method */
        $appointments = Appointment::join('departments', 'departments.id', 'appointments.department_id')
            ->join('patients', 'patients.id', 'appointments.patient_id')
            ->select(
                'appointments.id',
                'patients.name as patient_name',
                'patients.cpf as patient_cpf',
                'patients.phone_number as patient_phone_number',
                'departments.name as department_name',
                'appointments.anamnesis',
                'appointments.status',
                'appointments.start_date',
                'appointments.end_date',
            )
            ->whereIn('appointments.department_id', $request->departments);
        
        if (isset($request->patient_id) && $request->patient_id > 0) {
            $appointments->where('patient_id', $request->patient_id);
        }
        if (isset($request->department_id) && $request->department_id > 0) {
            $appointments->where('department_id', $request->department_id);
        }
        if (isset($request->status) && $request->status !== 'ALL') {
            $appointments->where('status', $request->status);
        }
        if (isset($request->initial_date) && isset($request->end_date)) {
            $appointments->where('start_date', '>=', $request->initial_date);
            $appointments->where('end_date', '<=', $request->end_date);

        } else if (isset($request->initial_date) && !isset($request->end_date)) {
            $appointments->where('start_date', $request->initial_date);
        } else if (!isset($request->initial_date) && isset($request->end_date)) {
            $appointments->where('end_date', $request->end_date);
        }

        $appointments = $appointments->orderBy('start_date')->get();
        /* response */
        if ($appointments) {
            return response()->json([
                'appointments' => $appointments,
                'flag' => 'success',
                'message' => count($appointments) . ' atendimento(s) encontrado(s).',
                'status' => 1
            ]);
        } else {
            return response()->json([
                'e' => true,
                'flag' => 'error',
                'message' => 'Ocorreu um erro durante a execução, tente novamente. Caso o erro persista, contate o administrador do website.',
                'status' => 0
            ], 404);
        }
    }
}
