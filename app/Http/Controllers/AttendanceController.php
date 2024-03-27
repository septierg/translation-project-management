<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Attendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\User;
use Illuminate\Support\Facades\DB;

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

        //get attendances
        $attendances = Attendance::where('user_id', $id)
        ->whereBetween('date', [
                $request->input('start'),
                $request->input('end')
        ])
        ->orderBy('date', 'asc')
        ->get();

        //return response
        return response()->json($attendances, 200);
    }

    public function all_reports(Request $request){

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
}
