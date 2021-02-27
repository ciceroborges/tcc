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
    public function login(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required|string|email|max:25',
            'password' => 'required|string|min:5',
        ]);

        if ($validation->fails()) {
            return response($validation->errors(), 400);
        }

        $user = User::where('email', ($request->email))->first();

        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                Auth::login($user);
                return response()->json([
                    'message' => 'Login efetuado com sucesso!',
                    'flag' => 'success',
                    'status' => 1,
                    'user' => [
                        'id' => Crypt::encryptString(Auth::user()->id),
                        'name' => Auth::user()->name,
                        'email' => Auth::user()->email,
                        'email_verified_at' => Auth::user()->email_verified_at,
                        'created_at' => Auth::user()->created_at,
                        'updated_at' => Auth::user()->updated_at,
                        'token' => Crypt::encryptString(Auth::user()->id . '|' . Auth::user()->name . '|' . Auth::user()->email)
                    ]
                ]);
            } else {
                return response()->json([
                    'message' => 'Senha inválida! Verifique as informações enviadas.',
                    'flag' => 'warning',
                    'status' => 0
                ]);
            }
        } else {
            return response()->json([
                'message' => 'Usuário não encontrado! Caso tenha esquecido a sua senha, clique em "esqueceu a senha ?" para recupera-lá.',
                'flag' => 'error',
                'status' => 0
            ]);
        }
    }

    public function register(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required|string|email|max:25',
            'password' => 'required|string|min:5',
            'confirm_password' => 'required|string|min:5',
        ]);

        if ($validation->fails()) {
            return response($validation->errors(), 400);
        }

        $user = User::where('email', ($request->email))->first();

        if ($user) {
            return response()->json([
                'status' => 'User already exists!'
            ]);
        } else {
            if ($request->password === $request->confirm_password) {
                $result = User::create([
                    'name' => trim(strip_tags($request->name)),
                    'email' => trim(strip_tags($request->email)),
                    'password' => Hash::make($request->password)
                ]);

                if ($result) {
                    return response()->json([
                        'status' => 'Success!'
                    ]);
                } else {
                    return response()->json([
                        'status' => 'Failure!'
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 'The passwords do not match!'
                ]);
            }
        }
    }

    public function logout()
    {
        if (Auth::logout()) {
            return response()->json([
                'status' => 'Success!'
            ]);
        } else {
            return response()->json([
                'status' => 'Failure!'
            ]);
        }
    }

    public function all(Request $request)
    {
        /* validation */
        $validation = Validator::make($request->all(), [
            'skip' => 'required|int',
            'take' => 'required|int',
        ]);

        if ($validation->fails()) {
            return response($validation->errors(), 400);
        }
        // limite de registros por loading
        $take = 5;
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
            ->skip($request->skip)
            ->take($request->take)
            ->get();
        /* encrypt */
        foreach ($users as $row) {
            $row->token = Crypt::encryptString($row->id);
        }
        /* response */
        if ($users) {
            return response()->json([
                'users' => $users,
                'skip' => $request->skip + $request->take
            ]);
        } else {
            return response()->json([
                'e' => true,
                'message' => 'Ocorreu um erro durante a execução, contate o administrador do website.',
            ], 404);
        }
    }
}
