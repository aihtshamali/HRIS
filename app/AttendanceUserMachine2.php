<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttendanceUserMachine2 extends Model
{
    protected $table='attendance_users_machine2';

    public function Log(){
        return $this->hasMany('App\AttendanceLogMachine2','attendance_id');
    } 
}
