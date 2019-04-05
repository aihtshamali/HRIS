<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AttendanceUserMachine1;
use App\AttendanceUserMachine2;
use App\AttendanceLogMachine1;
use App\AttendanceLogMachine2;
use Illuminate\Database\Eloquent\Collection;
use DB;
class ExecutiveController extends Controller
{

    /**
     * Instantiate a new ExecutiveController instance.
     */
    private $time_in, $time_out;
    public function __construct()
    {
        $this->time_in = '09:00:00';
        $this->time_out = '17:00:00';
    }
    // attendance
    public function attendance()
    {
        return view('attendance.attendancedashboard');
    }
    public function dailyattendance(Request $request)
    {
        if (!isset($request->date) || $request->date == null) {
            $date = date('Y-m-d');
        } else {
            $date = $request->date;
        }
        $user_data = array();
        if ($this->parseDataMachine1($date))
            $user_data[0]=$this->parseDataMachine1($date);
        if ($this->parseDataMachine2($date))
            $user_data=array_merge($user_data[0],$this->parseDataMachine2($date));
        // return response()->json($user_data);
        return view('attendance.dailyattendance', compact('user_data'));
    }
    // -----------PRIVATE-------------

    private function CheckStatus($attendance_data, $type)
    {
        if (!$attendance_data || $type== 'A bsent') {
            $attendance_data=new Collection();
            $attendance_data->status = "Absent";
        } else if ($type== 'C heck-In' && strtotime(date('H:i:s', strtotime($attendance_data->time))) > strtotime($this->time_in)) {
            $attendance_data->status = "Late";
        } else if ($type == 'Check-In' && strtotime(date('H:i:s', strtotime($attendance_data->time))) <= strtotime($this->time_in)) {
            $attendance_data->status = "Ontime";
        } else if ($type== 'C heck-Out' && strtotime(date('H:i:s', strtotime($attendance_data->time))) > strtotime($this->time_out)) {
            $attendance_data->status = "On-Time";
        } else if ($type == 'Check-Out' && strtotime(date('H:i:s', strtotime($attendance_data->time))) < strtotime($this->time_out)) {
            $attendance_data->status = "Before Time";
        }
        return $attendance_data;
    }
    private function parseDataMachine1($date = null, $type = null)
    {
        if ($date == null) {
            $date = date('Y-m-d');
        }
        $officers = AttendanceUserMachine1::where('status', 1)->get();
        $attendance_data = array();
        foreach ($officers as $officer) {
            $logs1 = AttendanceLogMachine1::select('user_id', 'type', 'time', \DB::raw("convert(varchar, time, 23) as mydate"), 'created_at')
                ->orderBy('user_id', 'ASC')
                ->get();
            $CheckIn = $logs1
                ->where('mydate', $date)->where('user_id', $officer->attendance_id)->where('type', 'Check-In')->last();
            $CheckOut = $logs1
                ->where('mydate', $date)->where('user_id', $officer->attendance_id)->where('type', 'Check-Out')->last();
            if ($type == "absent") {
                if (!$CheckIn) {
                    $attendance_data[$officer->name]['Check-In'] = $this->CheckStatus($CheckIn,'A bsent');
                    $attendance_data[$officer->name]['Check-Out'] = $this->CheckStatus($CheckOut,'A bsent');
                }
            } else if ($type == "late comers") {
                if ($CheckIn && strtotime(date('H:i:s', strtotime($CheckIn->time)) > strtotime($this->time_in))) {
                    $CheckIn->status = 'Late';
                    $attendance_data[$officer->name]['Check-In'] = $this->CheckStatus($CheckIn,'C heck-In');
                    $attendance_data[$officer->name]['Check-Out'] = $this->CheckStatus($CheckOut,'C heck-Out');
                }
            } else if ($type == "present") {
                if ($CheckIn != null) {
                    $attendance_data[$officer->name]['Check-In'] = $this->CheckStatus($CheckIn,'C heck-In');
                    $attendance_data[$officer->name]['Check-Out'] = $this->CheckStatus($CheckOut,'C heck-Out');
                }
            } elseif ($type == null) {
                $attendance_data[$officer->name]['Check-In'] = $this->CheckStatus($CheckIn,'C heck-In');
                $attendance_data[$officer->name]['Check-Out'] = $this->CheckStatus($CheckOut,'C heck-Out');
            }
        }
        return $attendance_data;
    }
    private function parseDataMachine2($date = null, $type = null)
    {
        if ($date == null) {
            $date = date('Y-m-d');
        }
        $officers = AttendanceUserMachine2::where('status', 1)->get();
        $attendance_data = array();
        foreach ($officers as $officer) {
            $logs2 = AttendanceLogMachine2::select('user_id', 'type', 'time', \DB::raw("convert(varchar, time, 23) as mydate"), 'created_at')
                ->orderBy('user_id', 'ASC')
                ->get();
            $CheckIn = $logs2
                ->where('mydate', $date)->where('user_id', $officer->attendance_id)->where('type', 'Check-In')->last();
            $CheckOut = $logs2
                ->where('mydate', $date)->where('user_id', $officer->attendance_id)->where('type', 'Check-Out')->last();
            if ($type == "absent") {
                if (!$CheckIn) {
                    $attendance_data[$officer->name]['Check-In'] = $this->CheckStatus($CheckIn,'A bsent');
                    $attendance_data[$officer->name]['Check-Out'] = $this->CheckStatus($CheckOut,'A bsent');
                }
            } else if ($type == "late comers") {
                if ($CheckIn && strtotime(date('H:i:s', strtotime($CheckIn->time)) > strtotime($this->time_in))) {
                    $CheckIn->status = 'Late';
                    $attendance_data[$officer->name]['Check-In'] = $this->CheckStatus($CheckIn,'C heck-In');
                    $attendance_data[$officer->name]['Check-Out'] = $this->CheckStatus($CheckOut,'C heck-Out');
                }
            } else if ($type == "present") {
                if ($CheckIn != null) {
                    $attendance_data[$officer->name]['Check-In'] = $this->CheckStatus($CheckIn,'C heck-In');
                    $attendance_data[$officer->name]['Check-Out'] = $this->CheckStatus($CheckOut,'C heck-Out');
                }
            } elseif ($type == null) {
                $attendance_data[$officer->name]['Check-In'] = $this->CheckStatus($CheckIn,'C heck-In');
                $attendance_data[$officer->name]['Check-Out'] = $this->CheckStatus($CheckOut,'C heck-Out');
            }
        }
        return $attendance_data;
    }

    // ----------------------

    public function present(Request $request)
    {
        if (!isset($request->date) || $request->date == null) {
            $date = date('Y-m-d');
        } else {
            $date = $request->date;
        }
        $user_data = array();
        if ($this->parseDataMachine1($date, 'present'))
            $user_data[0]=$this->parseDataMachine1($date, 'present');
        if ($this->parseDataMachine2($date, 'present'))
            $user_data=array_merge($user_data[0],$this->parseDataMachine2($date, 'present'));
        $total_count= count($user_data);
        // dd($total_count);
        return view('attendance.present', compact('user_data'));
    }
    public function Absent(Request $request)
    {
        if (!isset($request->date) || $request->date == null) {
            $date = date('Y-m-d');
        } else {
            $date = $request->date;
        }
        $user_data = array();
        if ($this->parseDataMachine1($date, 'absent'))
            $user_data[0]=$this->parseDataMachine1($date, 'absent');
        if ($this->parseDataMachine2($date, 'absent'))
            $user_data=array_merge($user_data[0],$this->parseDataMachine2($date, 'absent'));
        return view('attendance.Absent', compact('user_data'));
    }
    public function dispatches()
    {
        return view('dispatch.dispatch');
    }
    public function creates()
    {
        return view( 'dispatch.create');
    }
    public function AttendanceGraph()
    {
        return view( 'attendance.AttendanceGraph');
    }
    public function test()
    {
        return response()->json(["success" => "oh yea"]);
    }
}
