<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        //validation with validator
        $validator = Validator::make($request->all(), [
            'name' => 'required', 'string', 'max:255',
            'email' => 'required', 'string', 'email', 'max:255', 'unique:users',
            'password' => 'required', 'string', 'min:6', 'confirmed',
        ]);

        if ($validator->fails()) {
            return response($validator->errors()->first(), 400);
        }



        //create user and token
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'api_token' => Str::random(60)
        ]);


        //assign role
        $employee_role = Role::where('name', 'employee')->first();
        $employee_role->user()->save($user);


        //return response
        $response = [
            'user' => $user,
            'access_token' => $user->api_token
        ];

        return response()->json($response, 201);

    }
}
