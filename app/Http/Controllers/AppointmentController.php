<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        /* method */
        $appointments = Appointment::join('departments', 'departments.id', 'appointments.department_id')
            ->join('patients', 'patients.id', 'appointments.patient_id')
            ->select(
                'appointments.id',
                'appointments.department_id',
                'departments.name as department_name',
                'appointments.patient_id',
                'patients.name as patient_name',
                'appointments.anamnesis',
                'appointments.status',
                'appointments.start_date',
                'appointments.end_date',
            )
            ->whereIn('appointments.department_id', $request->departments);
                
        /*
        if ($request->filter) {
            $patients = Appointment::where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . trim(strip_tags($request->filter)) . '%')
                    ->orWhere('nickname', 'like', '%' . trim(strip_tags($request->filter)) . '%');
            });
        }
        */
        /* validation for infinite loading*/
        if (isset($request->skip) && isset($request->take)) {
            $validation = Validator::make($request->all(), [
                'skip' => 'required|int',
                'take' => 'required|int',
            ]);

            if ($validation->fails()) {
                return response([
                    'e' => true,
                    'flag' => 'error',
                    'message' => 'Um ou mais campos foram informados de maneira errada, verifique e tente novamente.',
                    'status' => 0
                ], 400);
            }

            $new_skip = $request->skip + $request->take;
            $appointments->skip($request->skip)->take($request->take);
        } else {
            $new_skip = 0;
        }

        $appointments = $appointments->orderBy('start_date')->get();
        /* response */
        if ($appointments) {
            return response()->json([
                'appointments' => $appointments,
                'skip' => $new_skip,
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

    public function find(Request $request)
    {
        /** validation */
        $validation = Validator::make($request->all(), [
            'id' => 'required|int',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'e' => true,
                'flag' => 'info',
                'message' => 'Erro na validação dos parâmetros passados para a consulta. Tente novamente.',
                'status' => 0
            ], 400);
        }
        /** method */
        $appointment = Appointment::select(
            'id',
            'department_id',
            'patient_id',
            'anamnesis',
            'status',
            'start_date',
            'end_date',
        )
            ->where('id', $request->id)
            ->first();
        /* response */
        if ($appointment) {
            return response()->json([
                'appointment' => $appointment,
                'flag' => 'success',
                'message' => 'Paciente(s) encontrado(s).',
                'status' => 1
            ]);
        } else {
            return response()->json([
                'e' => true,
                'flag' => 'error',
                'message' => 'Ocorreu um erro durante a consulta, tente novamente. Caso o erro persista, contate o administrador do website.',
                'status' => 0
            ], 404);
        }
    }

    public function store(Request $request)
    {
        /** validation */
        $validation = Validator::make($request->all(), [
            'department' => 'required|array',
            'patient' => 'required|array',
            'anamnesis' => 'required|string',
            'start_date' => 'required|date',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'e' => true,
                'flag' => 'info',
                'message' => 'Erro na validação dos parâmetros enviados! Tente novamente. Codigo de erro: ' . $validation->errors(),
                'status' => 0
            ], 400);
        }
        
        $store = Appointment::create([
            'department_id' => $request->department['id'],
            'patient_id' => $request->patient['id'],
            'anamnesis' => $request->anamnesis,
            'status' => 'WAITING',
            'start_date' => $request->start_date,
        ]);

        if ($store) {
            return response()->json([
                'appointment' => [
                    'id' => $store->id,
                    'department_id' => $store->department_id,
                    'patient_id' => $store->patient_id,
                    'department_name' => $request->department['name'],
                    'patient_name' => $request->patient['name'],
                    'anamnesis' => $store->anamnesis,
                    'status' => $store->status,
                    'start_date' => $store->start_date,
                    'end_date' => $store->end_date,
                ],
                'flag' => 'success',
                'message' => 'Atendimento criado com successo!',
                'status' => 1
            ]);
        } else {
            return response()->json([
                'e' => true,
                'flag' => 'info',
                'message' => 'Erro ao adicionar o atendimento! Tente novamente. Caso o erro persista, contate o administrador do website.',
                'status' => 0
            ], 404);
        }
    }

    public function update(Request $request)
    {
        /** validation */
        $validation = Validator::make($request->all(), [
            'id' => 'required|int',
            'department' => 'required|array',
            'patient' => 'required|array',
            'anamnesis' => 'required|string',
            'start_date' => 'required|date',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'e' => true,
                'flag' => 'info',
                'message' => 'Erro na validação dos parâmetros enviados! Tente novamente. Codigo de erro: ' . $validation->errors(),
                'status' => 0
            ], 400);
        }

        $appointment = Appointment::select('id')->where('id', $request->id)->first();

        if ($appointment) {
            Appointment::where('id', $appointment->id)->update([
                'department_id' => $request->department['id'],
                'patient_id' => $request->patient['id'],
                'anamnesis' => $request->anamnesis,
                'start_date' => $request->start_date,
            ]);

            return response()->json([
                'appointment' => [
                    'id' => $request->id,
                    'department_id' => $request->department['id'],
                    'patient_id' => $request->patient['id'],
                    'department_name' => $request->department['name'],
                    'patient_name' => $request->patient['name'],
                    'anamnesis' => $request->anamnesis,
                    'status' => $request->status,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                ],
                'flag' => 'success',
                'message' => 'Atendimento atualizado com successo.',
                'status' => 1
            ]);
        } else {
            return response()->json([
                'e' => true,
                'flag' => 'info',
                'message' => 'Atendimento não encontrado! Tente novamente. Caso o erro persista, contate o administrador do website.',
                'status' => 0
            ], 404);
        }
    }

    public function statusUpdate(Request $request)
    {
        /** validation */
        $validation = Validator::make($request->all(), [
            'id' => 'required|int',
            'status' =>  ['required', Rule::in(['WAITING', 'IN PROGRESS', 'CANCELED', 'CONCLUDED'])],
        ]);

        if ($validation->fails()) {
            return response()->json([
                'e' => true,
                'flag' => 'info',
                'message' => 'Erro na validação dos parâmetros enviados! Tente novamente. Codigo de erro: ' . $validation->errors(),
                'status' => 0
            ], 400);
        }

        $appointment = Appointment::select('id')->where('id', $request->id)->first();

        if ($appointment) {
            $fields = [
                'status' => $request->status
            ];

            if($request->status === 'CANCELED' || $request->status === 'CONCLUDED') {
                $fields['end_date'] = NOW();
            }
            
            $update = Appointment::where('id', $appointment->id)->update($fields);

            $fields['id'] = $request->id;

            $phone_number = null;
            $phone_message = null;
            if($update) {
                $appointment = Appointment::join('departments', 'departments.id', 'appointments.department_id')
                ->join('patients', 'patients.id', 'appointments.patient_id')
                ->select(
                    'appointments.start_date', 
                    'appointments.end_date',
                    'departments.name as department_name',
                    'patients.name as patient_name',
                    'patients.phone_number',    
                )
                ->where('appointments.id', $request->id)
                ->first();
                
                $phone_number = $appointment->phone_number;

                if($appointment) {
                    switch($request->status) {
                        case 'WAITING':
                            $phone_message = 'Olá '.$appointment->patient_name.', você possuí um atendimento de '.$appointment->department_name.' agendado para: '.$appointment->start_date. '. Aguardamos você ;)';
                            break;
                        case 'IN PROGRESS':
                            $phone_message = 'Olá '.$appointment->patient_name.', seu atendimento de '.$appointment->department_name.' foi iniciado em: '.date('d/m/Y').'. Em caso de dúvidas entre em contato ;)';
                            break;
                        case 'CANCELED': 
                            $phone_message = 'Olá '.$appointment->patient_name.', seu atendimento de '.$appointment->department_name.' foi cancelado em: '.date('d/m/Y').'. Caso queira agendar um novo atendimento, entre em contato ;)';
                            break;
                        case 'CONCLUDED': 
                            $phone_message = 'Olá '.$appointment->patient_name.', seu atendimento de '.$appointment->department_name.' foi concluído em: '.date('d/m/Y').'. Obrigado ;)';
                            break;    
                    }
                }
            }

            return response()->json([
                'appointment' => $fields,
                'flag' => 'success',
                'message' => 'Atendimento atualizado com successo.',
                'phone_number' => $phone_number,
                'phone_message' => $phone_message,
                'status' => 1
            ]);
        } else {
            return response()->json([
                'e' => true,
                'flag' => 'info',
                'message' => 'Atendimento não encontrado! Tente novamente. Caso o erro persista, contate o administrador do website.',
                'status' => 0
            ], 404);
        }
    }

    public function destroy(Request $request)
    {
        /** validation */
        $validation = Validator::make($request->all(), [
            'id' => 'required|int',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'e' => true,
                'flag' => 'info',
                'message' => 'Erro na validação dos parâmetros enviados! Tente novamente. Codigo de erro: ' . $validation->errors(),
                'status' => 0
            ], 400);
        }

        $appointment = Appointment::where('id', $request->id)->delete();

        if ($appointment) {
            return response()->json([
                'appointment' => [
                    'id' => $request->id,
                ],
                'flag' => 'success',
                'message' => 'Atendimento removido com successo.',
                'status' => 1
            ]);
        } else {
            return response()->json([
                'e' => true,
                'flag' => 'info',
                'message' => 'Erro ao remover o registro! Tente novamente. Caso o erro persista, contate o administrador do website.',
                'status' => 0
            ], 404);
        }
    }
    
}
