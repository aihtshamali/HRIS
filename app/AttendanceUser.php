<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttendanceUser extends Model
{
    public function Log(){
        return $this->hasMany('App\Log','attendance_id');
    } 
}
