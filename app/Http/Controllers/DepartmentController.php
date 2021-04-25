<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        /* method */
        $departments = Department::select('id', 'name');

        if ($request->filter) {
            $departments->where('name', 'like', '%' . trim(strip_tags($request->filter)) . '%');
        }
        /* validation for infinite loading*/
        if (isset($request->skip) && isset($request->take)) {
            $validation = Validator::make($request->all(), [
                'skip' => 'required|int',
                'take' => 'required|int',
            ]);

            if ($validation->fails()) {
                return response($validation->errors(), 400);
            }

            $new_skip = $request->skip + $request->take;
            $departments->skip($request->skip)->take($request->take);
        } else {
            $new_skip = 0;
        }
        /* method */
        $departments = $departments->get();
        /* response */
        if ($departments) {
            return response()->json([
                'departments' => $departments,
                'skip' => $new_skip,
                'message' => 'success',
            ]);
        } else {
            return response()->json([
                'e' => true,
                'message' => 'Ocorreu um erro durante a execução, contate o administrador do website.',
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
        $department = Department::select('id', 'name')->where('id', $request->id)->first();
        /* response */
        if ($department) {
            return response()->json([
                'department' => $department,
                'flag' => 'success',
                'message' => 'Departamento(s) encontrado(s).',
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

        $department = Department::where('name', 'like', '%'.$request->name.'%')->first();

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
            'id' => 'required|int',
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

        $department = Department::select('id')->where('id', $request->id)->first();

        if ($department) {
            $update = Department::where('id', $department->id)->update(['name' => $request->name]);

            if ($update) {
                return response()->json([
                    'department' => [
                        'id' => $request->id,
                        'name' => $request->name,
                    ],
                    'flag' => 'success',
                    'message' => 'Departamento atualizado com successo.',
                    'status' => 1
                ]);
            } else {
                return response()->json([
                    'e' => true,
                    'flag' => 'info',
                    'message' => 'Erro ao atualizar o departamento! Tente novamente. Caso o erro persista, contate o administrador do website.',
                    'status' => 0
                ], 404);
            }
        } else {
            return response()->json([
                'e' => true,
                'flag' => 'info',
                'message' => 'Departamento não encontrado! Tente novamente. Caso o erro persista, contate o administrador do website.',
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



        $delete = Department::where('id', $request->id)->delete();

        if ($delete) {
            return response()->json([
                'department' => [
                    'id' => (int) $request->id,
                ],
                'flag' => 'success',
                'message' => 'Departamento removido com successo.',
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
