<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttendanceRemarksMachine2 extends Model
{
    protected $table = "attendance_remarks_machine2";
    public function AttendanceUser()
    {
        return $this->belongsTo('App\AttendanceUserMachine2');
    }
    
}
