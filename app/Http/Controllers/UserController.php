<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(Request $request)
    {
        return $request->All();
    }
    public function register(Request $request)
    {
        if (User::find(trim(strip_tags($request->email)))) {
            return 'O usuário já existe';
        } else {
            if ($request->password === $request->confirm_password) {
                $result = User::create([
                    'name' => trim(strip_tags($request->name)),
                    'email' => trim(strip_tags($request->email)),
                    'password' => Hash::make($request->password)
                ]);
                
                if($result) {
                    return 'Usuário cadastrado com sucesso';
                } else {
                    return 'Ocorreu algum problema ao cadastrar, tente novamente!';
                }

            } else {
                return 'As senhas não são iguais';
            }
        }
    }
}
