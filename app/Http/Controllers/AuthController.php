<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function auth(Request $request)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'email'     => 'required',
            'password'  => 'required'
        ]);

        //if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //get credentials from request
        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            $user = auth()->user();
            $token = $user->createToken('laravel-restfull-api')->plainTextToken;
            return response()->json([
                'success' => true,
                'user'    => auth()->user(),
                'token' => $token
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Email atau Password Anda salah'
        ], 401);

        //if auth failed
        // if(!$token = auth()->guard('api')->attempt($credentials)) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Email atau Password Anda salah'
        //     ], 401);
        // }

        // //if auth success
        // return response()->json([
        //     'success' => true,
        //     'user'    => auth()->guard('api')->user(),    
        //     'token'   => $token   
        // ], 200);
    }
}
