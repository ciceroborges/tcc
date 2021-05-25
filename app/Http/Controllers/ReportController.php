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
            'patient' => 'sometimes|array',
            'department' => 'sometimes|array',
            'status' =>  ['sometimes', Rule::in(['WAITING', 'IN PROGRESS', 'CANCELED', 'CONCLUDED'])],
            'initial_date' => 'sometimes|date',
            'end_date' => 'sometimes|date',
        ]);

        if ($validation->fails()) {
            return response([
                'e' => true,
                'flag' => 'error',
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
            );
        
        if ($request->patient) {
            $appointments->where('patient_id', $request->patient['id']);
        }
        if ($request->department) {
            $appointments->where('department_id', $request->department['id']);
        }
        if ($request->status) {
            $appointments->where('status', $request->status);
        }
        if($request->initial_date && $request->end_date) {
            $appointments->whereBetween('start_date', [$request->initial_date, $request->end_date]);
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
