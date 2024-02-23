<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        //dd($request->all());
        //validation
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],

        ]);

        dd($validated);
        //create user and token
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'api_token' => Str::random(60),
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
