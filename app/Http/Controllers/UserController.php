<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(Request $request)
    {
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

            $skip = $request->skip;
            $take = $request->take;
            $new_skip = $request->skip + $request->take;
        } else {
            $skip = 0;
            $take = 99999999999999999999;
            $new_skip = 0;
        }
        /* method */
        $users = DB::table('users as u')->leftJoin('user_group as ug', 'ug.user_id', 'u.id')
            ->leftJoin('groups as g', 'g.id', 'ug.group_id')
            ->select(
                'u.id',
                'u.name',
                'u.email',
                'u.picture',
                'g.name as group_name',
                DB::raw(
                    "(SELECT GROUP_CONCAT(d.name SEPARATOR ', ')
                      FROM departments d 
                      INNER JOIN user_department ud ON ud.department_id = d.id 
                      INNER JOIN users us ON us.id = ud.user_id
                      WHERE us.id = u.id
                      AND d.deleted_at is null 
                      GROUP BY us.id) AS departments_names"
                )
            )
            ->where('u.deleted_at', '=', NULL)
            ->skip($skip)
            ->take($take)
            ->get();
        /* response */
        if ($users) {
            return response()->json([
                'users' => $users,
                'skip' => $new_skip,
                'flag' => 'success',
                'message' => count($users) . ' usuário(s) encontrado(s).',
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
    public function login(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required|string|email|max:25',
            'password' => 'required|string|min:5',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'e' => true,
                'flag' => 'info',
                'message' => 'Um ou mais campos foram informados de maneira errada, verifique e tente novamente.',
                'status' => 0
            ], 400);
        }

        $user = User::where('email', ($request->email))->first();

        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                Auth::login($user);
                return response()->json([
                    'user' => [
                        'id' => Crypt::encryptString(Auth::user()->id),
                        'name' => Auth::user()->name,
                        'email' => Auth::user()->email,
                        'email_verified_at' => Auth::user()->email_verified_at,
                        'created_at' => Auth::user()->created_at,
                        'updated_at' => Auth::user()->updated_at,
                        'token' => Crypt::encryptString(Auth::user()->id . '|' . Auth::user()->name . '|' . Auth::user()->email)
                    ],
                    'flag' => 'success',
                    'message' => 'Login efetuado com sucesso!',
                    'status' => 1,
                ]);
            } else {
                return response()->json([
                    'e' => true,
                    'flag' => 'info',
                    'message' => 'Senha inválida! Verifique as informações enviadas.',
                    'status' => 0
                ], 404);
            }
        } else {
            return response()->json([
                'e' => true,
                'flag' => 'info',
                'message' => 'Usuário não encontrado! Caso ainda não tenha se cadastrado, clique em "Deseja solicitar acesso?" para cadastrar-se.',
                'status' => 0
            ], 404);
        }
    }

    public function register(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|min:10',
            'email' => 'required|string|email|max:25',
            'password' => 'required|string|min:5',
            'confirm_password' => 'required|string|min:5',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'e' => true,
                'flag' => 'error',
                'message' => 'Um ou mais campos foram informados de maneira errada, verifique e tente novamente.',
                'status' => 0
            ], 400);
        }

        $user = User::where('email', ($request->email))->first();

        if ($user) {
            return response()->json([
                'e' => true,
                'flag' => 'info',
                'message' => 'O E-mail informado já pertence a um usuário! Caso tenha esquecido a sua senha, clique em "Esqueceu sua senha ?" para recupera-lá.',
                'status' => 0
            ], 404);
        } else {
            if ($request->password === $request->confirm_password) {
                $result = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password)
                ]);

                if ($result) {
                    $this->login($request);
                } else {
                    return response()->json([
                        'e' => true,
                        'flag' => 'error',
                        'message' => 'Ocorreu um erro durante a execução, tente novamente. Caso o erro persista, contate o administrador do website.',
                        'status' => 0
                    ], 404);
                }
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

    public function logout()
    {
        if (Auth::logout()) {
            return response()->json([
                'flag' => 'success',
                'message' => 'Logout efetuado com sucesso! Você será redirecionado para a tela de login.',
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
