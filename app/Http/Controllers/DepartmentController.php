<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
{
    public function all(Request $request)
    {   
        /* validation for infinite loading*/
        if(isset($request->skip) && isset($request->take)) {
            $validation = Validator::make($request->all(), [
                'skip' => 'required|int',
                'take' => 'required|int',
            ]);

            if ($validation->fails()) {
                return response($validation->errors(), 400);
            }

            $skip = $request->skip;
            $take = $request->take;
            $new_skip = $request->skip + $request->take;
        }  else {
            $skip = 0;
            $take = 99999999999999999999;
            $new_skip = 0;
        }  
        /* method */
        $departments = Department::skip($skip)->take($take)->get();
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
}
