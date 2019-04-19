<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttendanceRemarksMachine1 extends Model
{
    protected $table= "attendance_remarks_machine1";
    public function AttendanceUser()
    {
        return $this->belongsTo('App\AttendanceUserMachine1');
    }
}
