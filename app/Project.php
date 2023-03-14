<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded  = [];

    //A PRODUCT AS MANY TASKS
    public function tasks(){
        return $this->hasMany(Task::class);
    }

    //USE THE RELATIONSHIP TO CREATE A NEW TASK
    public function addTask($task){
        $this->tasks()->create($task);
    }

    //A PROJECT HAS A OWNER
    public function owner(){
        return $this->belongsTo(User::class);
    }

}
