<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    public function AttendanceUser(){
       return $this->belongsTo('App\AttendanceUser','attendance_id');
    }
}
