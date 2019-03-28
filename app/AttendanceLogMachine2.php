<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttendanceLogMachine2 extends Model
{
    protected $table='attendance_log_machine2';    
    public function AttendanceUser(){
        return $this->belongsTo('App\AttendanceUserMachine2','attendance_id');
     }
}
