<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        /* method */
        $patients = Patient::select(
            'id',
            'name',
            'nickname',
            'cpf',
            'birth_date',
            'gender',
            'blood_type',
            'allergy',
            'address',
            'email',
            'phone_number',
            'picture',
            'contact_name',
            'contact_phone_number',
        );

        if ($request->filter) {
            $patients = Patient::where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . trim(strip_tags($request->filter)) . '%')
                    ->orWhere('nickname', 'like', '%' . trim(strip_tags($request->filter)) . '%');
            });
        }
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
            $patients->skip($request->skip)->take($request->take);
        } else {
            $new_skip = 0;
        }

        $patients = $patients->orderBy('name')->get();
        /* response */
        if ($patients) {
            return response()->json([
                'patients' => $patients,
                'skip' => $new_skip,
                'flag' => 'success',
                'message' => count($patients) . ' paciente(s) encontrado(s).',
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
        $patient = Patient::select(
            'id',
            'name',
            'nickname',
            'cpf',
            'birth_date',
            'gender',
            'blood_type',
            'allergy',
            'address',
            'email',
            'phone_number',
            'picture',
            'contact_name',
            'contact_phone_number',
        )
            ->where('id', $request->id)
            ->first();
        /* response */
        if ($patient) {
            return response()->json([
                'patient' => $patient,
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
            'name' => 'required|string|min:5',
            'nickname' => 'nullable|string',
            'cpf' => 'required|string|min:14|max:14',
            'birth_date' => 'required|date',
            'gender' => 'required|string|min:1|max:1',
            'blood_type' => ['required', 'string', 'min:2', 'max:3', Rule::in(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'])],
            'allergy' => 'nullable|string',
            'address' => 'nullable|string',
            'email' => 'nullable|email',
            'phone_number' => 'required|string|min:11|max:11',
            'picture' => 'nullable|string',
            'contact_name' => 'nullable|string|min:5',
            'contact_phone_number' => 'nullable|string|min:11|max:11',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'e' => true,
                'flag' => 'info',
                'message' => 'Erro na validação dos parâmetros enviados! Tente novamente. Codigo de erro: ' . $validation->errors(),
                'status' => 0
            ], 400);
        }

        $patient = Patient::where(function ($query) use ($request) {
            $query->where('cpf', $request->cpf)
                ->orWhere(function ($query) use ($request) {
                    $query->whereNotNull('email')->where('email', $request->email);
                });
        })->first();

        if (!$patient) {
            $store = Patient::create([
                'name' => $request->name,
                'nickname' => $request->nickname,
                'cpf' => $request->cpf,
                'birth_date' => $request->birth_date,
                'gender' => $request->gender,
                'blood_type' => $request->blood_type,
                'allergy' => $request->allergy,
                'address' => $request->address,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'picture' => $request->picture,
                'contact_name' => $request->contact_name,
                'contact_phone_number' => $request->contact_phone_number,
            ]);

            if ($store) {
                return response()->json([
                    'patient' => [
                        'id' => $store->id,
                        'name' => $store->name,
                        'nickname' => $store->nickname,
                        'cpf' => $store->cpf,
                        'birth_date' => $store->birth_date,
                        'gender' => $store->gender,
                        'blood_type' => $store->blood_type,
                        'allergy' => $store->allergy,
                        'address' => $store->address,
                        'email' => $store->email,
                        'phone_number' => $store->phone_number,
                        'picture' => $store->picture,
                        'contact_name' => $store->contact_name,
                        'contact_phone_number' => $store->contact_phone_number,
                    ],
                    'flag' => 'success',
                    'message' => 'Paciente criado com successo!',
                    'status' => 1
                ]);
            } else {
                return response()->json([
                    'e' => true,
                    'flag' => 'info',
                    'message' => 'Erro ao adicionar o paciente! Tente novamente. Caso o erro persista, contate o administrador do website.',
                    'status' => 0
                ], 404);
            }
        } else {
            return response()->json([
                'e' => true,
                'flag' => 'info',
                'message' => 'Já existe um paciente cadastrado com o cpf ou o e-mail informado! Verifique as informações e tente novamente.',
                'status' => 0
            ]);
        }
    }
    public function update(Request $request)
    {
        /** validation */
        $validation = Validator::make($request->all(), [
            'id' => 'required|int',
            'name' => 'required|string|min:5',
            'nickname' => 'nullable|string',
            'cpf' => 'required|string|min:14|max:14',
            'birth_date' => 'required|date',
            'gender' => 'required|string|min:1|max:1',
            'blood_type' => ['required', 'string', 'min:2', 'max:3', Rule::in(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'])],
            'allergy' => 'nullable|string',
            'address' => 'nullable|string',
            'email' => 'nullable|email',
            'phone_number' => 'required|string|min:11|max:11',
            'picture' => 'nullable|string',
            'contact_name' => 'nullable|string|min:5',
            'contact_phone_number' => 'nullable|string|min:11|max:11',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'e' => true,
                'flag' => 'info',
                'message' => 'Erro na validação dos parâmetros enviados! Tente novamente. Codigo de erro: ' . $validation->errors(),
                'status' => 0
            ], 400);
        }

        $patient = Patient::select('id')->where('id', $request->id)->first();

        if ($patient) {
            Patient::where('id', $patient->id)->update([
                'name' => $request->name,
                'nickname' => $request->nickname,
                'cpf' => $request->cpf,
                'birth_date' => $request->birth_date,
                'gender' => $request->gender,
                'blood_type' => $request->blood_type,
                'allergy' => $request->allergy,
                'address' => $request->address,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'picture' => $request->picture,
                'contact_name' => $request->contact_name,
                'contact_phone_number' => $request->contact_phone_number,
            ]);

            return response()->json([
                'patient' => [
                    'id' => $request->id,
                    'name' => $request->name,
                    'nickname' => $request->nickname,
                    'cpf' => $request->cpf,
                    'birth_date' => $request->birth_date,
                    'gender' => $request->gender,
                    'blood_type' => $request->blood_type,
                    'allergy' => $request->allergy,
                    'address' => $request->address,
                    'email' => $request->email,
                    'phone_number' => $request->phone_numeber,
                    'picture' => $request->picture,
                    'contact_name' => $request->contact_name,
                    'contact_phone_number' => $request->contact_phone_number,
                ],
                'flag' => 'success',
                'message' => 'Paciente atualizado com successo.',
                'status' => 1
            ]);
        } else {
            return response()->json([
                'e' => true,
                'flag' => 'info',
                'message' => 'Paciente não encontrado! Tente novamente. Caso o erro persista, contate o administrador do website.',
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

        $patient = Patient::where('id', $request->id)->delete();

        if ($patient) {
            return response()->json([
                'patient' => [
                    'id' => $request->id,
                ],
                'flag' => 'success',
                'message' => 'Paciente removido com successo.',
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
