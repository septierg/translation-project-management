<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Attendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\User;

class AttendanceController extends Controller
{
    public function clock_in(Request $request){

        $dt = Carbon::now();

        //dd(Carbon::today());

       /* echo $dt->toDateString();                          // 1975-12-25
        echo $dt->toFormattedDateString();                 // Dec 25, 1975
        echo $dt->toTimeString();                          // 14:15:16
        echo $dt->toDateTimeString();                      // 1975-12-25 14:15:16
        echo $dt->toDayDateTimeString();*/

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

        //get attendances
        $attendances = Attendance::where('user_id', $id)
        ->whereBetween('date', [
                $request->input('start'),
                $request->input('end')
        ])
        ->orderBy('date', 'asc')
        ->get();

        //by user id and date range

        //return response
        return response()->json($attendances, 200);
    }

    public function all_reports(Request $request){

        //input validation
        $validator = Validator::make($request->all(), [
            'start' => 'required', 'date',
            'end' => 'required', 'date',
        ]);

        $start =  $request->input('start');
        $end =  $request->input('end');

        //TODO
        //find a way to do a query with date between laravel 5.7

        //get all users together with the attendance laravel 9 version
       /* $users = User::with(['attendance' => function ($query) use ($start, $end){

            $query
            ->whereBetween('date', [
                $start,
                $end

            ])
            ->orderBy('date', 'asc')
            ->get();
        }]);*/
        //dd($start,$end);

        $users = User::with('attendance')->get();
        /*$users = User::whereHas('attendance', function($q){
            $q->where('date', '>=', '2024-02-01');
        })->get();*/

//$users = User::with('attendance')
        /*->whereBetween('attendance.date', [
            $request->input('start'),
            $request->input('end')
        ])
        ->orderBy('date', 'asc')*/
        //->get();

        //return response
        return response()->json($users, 200);

    }
}
