<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Token;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Session;


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
            return response()->json(['message'  => $validator->errors()->first()], 400);
        }

        //create a unique token
        $user_token = Str::random(60);

        //create user and add the token to it
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'api_token' =>  $user_token
        ]);

        //create token and add to table
        $user_token = Token::create([
            'api_token' => $user_token
        ]);


        //assign role BUT ROLES NEEDS TO BE CREATED IN BD BEFORE
        $employee_role = Role::where('name', 'employee')->first();
        $employee_role->user()->save($user);


        //return response
        $response = [
            'user' => $user,
            'access_token' => $user->api_token,
            'token' => $user_token->api_token
        ];

        return response()->json($response, 201);

    }

    public function login(Request $request)
    {
        //validation
        $validator = Validator::make($request->all(), [
            'email' => 'required', 'string', 'email', 'max:255', 'unique:users',
            'password' => 'required', 'string', 'min:6', 'confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['message'  => $validator->errors()->first()], 400);
        }

        $credentials = array(
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        );

        //attempt authentification
        if(Auth::attempt($credentials))
        {

            //get user object
            $user = User::where('email', $request->input('email'))->first();

            //TODO
            //Create token and save it in a separate DB
            //Get that token and check with the one with the user token
            //https://stackoverflow.com/questions/23247873/laravel-authenticating-with-session-token
            $token = Str::random(60);

            //return response
            $response = [
                'data' => [
                    'access_token' => $token
                ]
            ];

            return response()->json($response);


        }
        else{
            //return response
            return response()->json(['message'  => 'Unauthenticated'], 401);
        }


    }

    // need to be change for laravel 5.7
    public function logout(Request $request)
    {
        //$request->user()->delete();
        //$request->user()->tokens()->delete();
        dd( $this->middleware('guest'));
       dd(Auth::guard('web')->logout());

        return response()->json(null, 204);
    }

    public function resetPassword(Request $request)
    {
        //validation
        $validator = Validator::make($request->all(), [
            'password' => 'required', 'string', 'min:6', 'confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['message'  => $validator->errors()->first()], 400);
        }


        //get user object
        $user = $request->user();

        //change password
        $user->password =  Hash::make($request->input('password'));

        //update user
        $user->save();

        //need to be change for laravel 5.7
        $user->tokens()->delete();

        //return response
         $response = [
            'data' => [
                'message' =>'Password change successfully'
            ]
        ];

        return response()->json($response, 200);


    }


}
