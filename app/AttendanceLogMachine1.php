<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttendanceLogMachine1 extends Model
{
    protected $table='attendance_log_machine1';
    public function AttendanceUser(){
       return $this->belongsTo('App\AttendanceUsersMachine1','attendance_id');
    }
}
