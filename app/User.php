<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //MEANS A USER CAN HAVE MAN PROJECT
    public function projects(){
        return $this->hasMany(Project::class,'owner_id' );
    }

    //MEANS A ROLE BELONGS TO A USER
    public function role(){
        return $this->belongsTo(Role::class, 'role_id');
    }

    //MEANS A USER CAN HAVE MULTIPLE ATTENDANCE
    public function attendance(){
        return $this->hasMany(Attendance::class);
    }
}
