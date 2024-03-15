<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return response()->json(['data' => $users], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //get user object
        $user = User::where('id', $id)->first();

        if(!$user){
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json($user, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       //validation with validator
       $validator = Validator::make($request->all(), [
            'name' => 'required', 'string', 'max:255',
            'email' => 'required', 'string', 'email', 'max:255', 'unique:users'
        ]);

       //get user object
       $user = User::where('id', $id)->first();
       if(!$user){
            return response()->json(['message' => 'User not found'], 404);
       }

       //check if input are valid and then update user
       if ($validator->fails()) {
            return response()->json(['message'  => $validator->errors()->first()], 400);
        }

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();

        //return response
        return response()->json(['data' => $user], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //get user object
        $user = User::where('id', $id)->first();

        if(!$user){
            return response()->json(['message' => 'User not found'], 404);
        }

       $user->delete();

       //return response
       return response(null, 204);

    }
}
