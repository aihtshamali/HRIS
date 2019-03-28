<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttendanceUserMachine1 extends Model
{
    protected $table='attendance_users_machine1';

    public function Log(){
        return $this->hasMany('App\AttendanceLogMachine1','attendance_id');
    } 
}
