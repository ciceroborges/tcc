<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class GroupController extends Controller
{
    public function index(Request $request)
    {
        /* method */
        $groups = Group::select('*');
        
        if ($request->filter) {
            $groups->where('name', 'like', '%' . trim(strip_tags($request->filter)) . '%');
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
            $groups->skip($request->skip)->take($request->take)->get();
        } else {
            $new_skip = 0;
        }

        $groups = $groups->get();
        /* response */
        if ($groups) {
            return response()->json([
                'groups' => $groups,
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
        $group = Group::select('id', 'name')->where('id', $request->id)->first();
        /* response */
        if ($group) {
            return response()->json([
                'group' => $group,
                'flag' => 'success',
                'message' => 'Grupo(s) encontrado(s).',
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
}
