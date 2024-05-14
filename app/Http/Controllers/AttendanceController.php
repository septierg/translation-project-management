<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Attendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Auth;

class AttendanceController extends Controller
{
    public function clock_in(Request $request){

        $dt = Carbon::now();

        //user id
        $user_id = $request->input('user_id');

        //find attendance if exist
        $attendance = Attendance::where('date', Carbon::today())->where('user_id', $user_id)->first();

        //if not exists, create new attendance (date and user id not nullable)
        if(!$attendance){
            $attendance = Attendance::create([
                'user_id' => $user_id,
                'date'    => Carbon::today()
            ]);
        }

        //save clock in
        if(!$attendance->clock_in){

            $attendance->clock_in = Carbon::now();
            $attendance->save();
        }

        //return response
        return response()->json($attendance, 200);
    }

    public function clock_out(Request $request){

        $dt = Carbon::now();

        //user id
        $user_id = $request->input('user_id');

        //find attendance if exist
        $attendance = Attendance::where('date', Carbon::today())->where('user_id', $user_id)->first();

        //if not exists, create new attendance (date and user id not nullable)
        if(!$attendance){
            $attendance = Attendance::create([
                'user_id' => $user_id,
                'date'    => Carbon::today()
            ]);
        }

        //save clock out
        $attendance->clock_out = Carbon::now();
        $attendance->save();

        //return response
        return response()->json($attendance, 200);

    }

    public function reports(Request $request, $id){

        //input validation
        $validator = Validator::make($request->all(), [
            'start' => 'required', 'date',
            'end' => 'required', 'date',
        ]);

        if ($validator->fails()) {
            return response()->json(['message'  => $validator->errors()->first()], 400);
        }

        if(!($attendance = Attendance::with('user')->find($id))){
            return response()->json(['message' => 'resource not found'], 404);
        }

        $user = User::where('id', $request->input('user_id'))->first();

        //When you're using get() you get a collection BUT When you're using find() or first() you get an object, so you can get properties
        /*$user = User::with('role')->whereHas('role', function($query) {
            $query->where('id', 1);
        })->get();*/


        //check if user is Employe
        if($attendance->user_id == $user->id && $user->role_id == 2){

            //get attendances
            $attendances = Attendance::where('id', $id)
            ->whereBetween('date', [
                    $request->input('start'),
                    $request->input('end')
            ])
            ->orderBy('date', 'asc')
            ->get();


            //return response
            return response()->json($attendances, 200);

        }

        //admin user can see everything
        if($user->role_id == 1){

            //get attendances
            $attendances = Attendance::where('id', $id)
            ->whereBetween('date', [
                    $request->input('start'),
                    $request->input('end')
            ])
            ->orderBy('date', 'asc')
            ->get();

            //return response
            return response()->json($attendances, 200);
        }
        else{

            return response()->json(['message' => 'Unauthorized'], 403);
        }

    }

    public function all_reports(Request $request){

        $user = User::where('id', $request->input('user_id'))->first();

        //input validation
        $validator = Validator::make($request->all(), [
            'start' => 'required', 'date',
            'end' => 'required', 'date',
        ]);

        if ($validator->fails()) {
            return response()->json(['message'  => $validator->errors()->first()], 400);
        }

        $start =  $request->input('start');
        $end =  $request->input('end');

        if($user->role_id == 1){

            //Maybe another way to ask the relationship in collection
            $users = DB::table('users')
                ->join('attendances', 'users.id', '=', 'attendances.user_id')
                ->whereBetween('date', [
                    $start,
                    $end
                ])
                ->orderBy('date', 'asc')
                ->get();

                //return response
                return response()->json($users, 200);
        }
        else{

            return response()->json(['message' => 'Unauthorized'], 403);
        }


    }
}
