<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //MEANS A ROLE CAN HAVE MULTIPLE USER
    public function user(){
        return $this->hasMany(User::class);
    }
}
