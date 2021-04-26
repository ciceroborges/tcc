<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        /* method */
        $patients = Patient::select(
            'name','nickname','cpf','birth_date','gender','blood_type','allergy',
            'address','email','phone_number','picture','contact_name','contact_phone_number',
        );

        if ($request->filter) {
            $patients->where('name', 'like', '%' . trim(strip_tags($request->filter)) . '%');
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
                'users' => $patients,
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
            'uuid' => 'required|string',
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
        $user = DB::table('users as u')->leftJoin('user_group as ug', 'ug.user_id', 'u.id')
            ->leftJoin('groups as g', 'g.id', 'ug.group_id')
            ->select(
                'u.id',
                'u.uuid',
                'u.name',
                'u.email',
                'u.picture',
                'g.id as group_id',
                DB::raw(
                    "(SELECT GROUP_CONCAT(d.id SEPARATOR ', ')
                  FROM departments d 
                  INNER JOIN user_department ud ON ud.department_id = d.id 
                  INNER JOIN users us ON us.id = ud.user_id
                  WHERE us.id = u.id
                  AND d.deleted_at is null 
                  AND ud.deleted_at is null
                  GROUP BY us.id) AS departments_ids"
                )
            )
            ->where('u.uuid', $request->uuid)
            ->first();
        /* response */
        if ($user) {
            return response()->json([
                'user' => $user,
                'flag' => 'success',
                'message' => 'Usuário(s) encontrado(s).',
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
            'name' => 'required|string',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'e' => true,
                'flag' => 'info',
                'message' => 'Erro na validação dos parâmetros enviados! Tente novamente. Codigo de erro: ' . $validation->errors(),
                'status' => 0
            ], 400);
        }

        $department = Department::where('name', 'like', '%' . $request->name . '%')->first();

        if (!$department) {
            $store = Department::create([
                'name' => $request->name,
            ]);

            if ($store) {
                return response()->json([
                    'department' => [
                        'id' => $store->id,
                        'name' => $store->name,
                    ],
                    'flag' => 'success',
                    'message' => 'Departamento criado com successo!',
                    'status' => 1
                ]);
            } else {
                return response()->json([
                    'e' => true,
                    'flag' => 'info',
                    'message' => 'Erro ao criar o departamento! Tente novamente. Caso o erro persista, contate o administrador do website.',
                    'status' => 0
                ], 404);
            }
        } else {
            return response()->json([
                'e' => true,
                'flag' => 'info',
                'message' => 'Já existe um departamento com este nome! Escolha outro e tente novamente.',
                'status' => 0
            ]);
        }
    }
    public function update(Request $request)
    {
        /** validation */
        $validation = Validator::make($request->all(), [
            'uuid' => 'required|string',
            'name' => 'required|string',
            'email' => 'required|email',
            'group' => 'required|array',
            'departments' => 'required|array',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'e' => true,
                'flag' => 'info',
                'message' => 'Erro na validação dos parâmetros enviados! Tente novamente. Codigo de erro: ' . $validation->errors(),
                'status' => 0
            ], 400);
        }

        $user = User::select('id')->where('uuid', $request->uuid)->first();

        if ($user) {
            User::where('id', $user->id)->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            $user_group = UserGroup::select('id')->where('user_id', $user->id)->first();

            if (isset($request->group[0])) {
                $group_id = $request->group[0]['id'];
                $group_name = $request->group[0]['name'];
            } else {
                $group_id = $request->group['id'];
                $group_name = $request->group['name'];
            }

            if (!$user_group) {
                UserGroup::create([
                    'user_id' => $user->id,
                    'group_id' => $group_id,
                ]);
            } else {
                UserGroup::where('id', $user_group->id)->update([
                    'group_id' => $group_id,
                ]);
            }

            $user_departments_ids = [];
            $user_departments_names = [];

            foreach ($request->departments as $row) {
                $user_department = UserDepartment::withTrashed()->firstOrCreate([
                    'user_id' => $user->id,
                    'department_id' => $row['id']
                ], []);

                if (!$user_department->wasRecentlyCreated) {
                    if ($user_department->trashed()) {
                        $user_department->restore();
                    }
                }

                array_push($user_departments_ids, $row['id']);
                array_push($user_departments_names, $row['name']);
            }

            UserDepartment::whereNotIn('department_id', $user_departments_ids)->delete();

            return response()->json([
                'user' => [
                    'uuid' => $request->uuid,
                    'name' => $request->name,
                    'email' => $request->email,
                    'group_name' => $group_name,
                    'departments_names' => implode(', ', $user_departments_names),
                ],
                'flag' => 'success',
                'message' => 'Usuário atualizado com successo.',
                'status' => 1
            ]);
        } else {
            return response()->json([
                'e' => true,
                'flag' => 'info',
                'message' => 'Usuário não encontrado! Tente novamente. Caso o erro persista, contate o administrador do website.',
                'status' => 0
            ], 404);
        }
    }
    public function destroy(Request $request)
    {
        /** validation */
        $validation = Validator::make($request->all(), [
            'uuid' => 'required|string',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'e' => true,
                'flag' => 'info',
                'message' => 'Erro na validação dos parâmetros enviados! Tente novamente. Codigo de erro: ' . $validation->errors(),
                'status' => 0
            ], 400);
        }

        $user = User::where('uuid', $request->uuid)->delete();

        if ($user) {
            return response()->json([
                'user' => [
                    'uuid' => $request->uuid,
                ],
                'flag' => 'success',
                'message' => 'Usuário removido com successo.',
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
