<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    // attendance
    public function attendance()
    {
      return view('attendance.attendancedashboard');
      // return view('_Monitoring.attendance');
      // return view('Attendance');
    }
    public function dailyattendance()
    {
      return view('attendance.dailyattendance');
    }
    public function present()
    {
      return view('attendance.present');
    }
    public function Absent()
    {
      return view('attendance.Absent');
    }
}