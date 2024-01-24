<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{

    protected $fillable = [
        'date',
        'clock_in',
        'clock_out',
        'user_id',

    ];

    //MEANS AN ATTENDANCE BELONGS TO A USER
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
