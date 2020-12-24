<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

use App\Models\User;
class UserController extends Controller
{
    public function login(Request $request)
    {   
        $validation = Validator::make($request->all(), [
            'email' => 'required|string|email|max:25',
            'password' => 'required|string|min:6',
        ]);

        if ($validation->fails()) {
            return response($validation->errors(), 400);
        }

        $user = User::where('email', ($request->email))->first();
        
        if($user) {
            if(Hash::check($request->password, $user->password)) {
                Auth::login($user);
                return response()->json([
                    'status' => 'Success!',
                    'user' => [
                        'id' => Crypt::encryptString($user->id),
                        'name' => $user->name,
                        'email' => $user->email,
                    ]
                ]);
            } else {
                return response()->json([
                    'status' => 'Invalid password!'
                ]);
            }
        } else {
            return response()->json([
                'status' => 'User not found!'
            ]);
        }
    }

    public function register(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'account' => 'required|string|email|max:25',
            'password' => 'required|string|min:6',
            'confirm_password' => 'required|string|min:6',
        ]);

        if ($validation->fails()) {
            return response($validation->errors(), 400);
        }
        
        $user = User::where('email', ($request->account))->first();
        
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
                
                if($result) {
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
        if(Auth::logout()) {
            return response()->json([
                'status' => 'Success!'
            ]);
        } else {
            return response()->json([
                'status' => 'Failure!'
            ]);
        }
    }
}
