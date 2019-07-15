<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AttendanceUserMachine1;
use App\AttendanceUserMachine2;
use App\AttendanceLogMachine1;
use App\AttendanceLogMachine2;
use Illuminate\Database\Eloquent\Collection;
use JavaScript;
use DB;
use App\AttendanceRemarksMachine1;
use App\AttendanceRemarksMachine2;
class ExecutiveController extends Controller
{

    /**
     * Instantiate a new ExecutiveController instance.
     */
    private $time_in, $time_out;
    public function __construct()
    {
        $this->time_in = '09:15:00';
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

        return view('attendance.dailyattendance', compact('user_data','date'));
    }
    // -----------PRIVATE-------------

    private function CheckStatus($attendance_data, $type)
    {
        if (!$attendance_data || $type== 'Absent') {
            $attendance_data=new Collection();
            $attendance_data->status = "Absent";
        } else if ($type== 'Check-In' && strtotime(date('H:i:s', strtotime($attendance_data->time))) > strtotime($this->time_in)) {
            $attendance_data->status = "Late";
        } else if ($type == 'Check-In' && strtotime(date('H:i:s', strtotime($attendance_data->time))) <= strtotime($this->time_in)) {
            $attendance_data->status = "On-Time";
        } else if ($type== 'Check-Out' && strtotime(date('H:i:s', strtotime($attendance_data->time))) > strtotime($this->time_out)) {
            $attendance_data->status = "On-Time";
        } else if ($type == 'Check-Out' && strtotime(date('H:i:s', strtotime($attendance_data->time))) < strtotime($this->time_out)) {
            $attendance_data->status = "Before Time";
        }
        return $attendance_data;
    }
    private function parseDataMachine1($date = null, $type = null)
    {
        // dd('asd');
        if ($date == null) {
            $date = date('Y-m-d');
        }
        $officers = AttendanceUserMachine1::where('status', 1)->get();
        $attendance_data = array();
        // Getting All Logs from Machine 1 
        $logs1 = AttendanceLogMachine1::select('user_id', 'type', 'time', \DB::raw("convert(varchar, time, 23) as mydate"), 'created_at')
        ->orderBy('user_id', 'ASC')
        ->get();
        foreach ($officers as $officer) {
            // dd($logs1);
            // For Check-In
            $CheckIn = $logs1
            ->where('mydate', $date)->where('user_id', $officer->attendance_id)->where('type', 'Check-In')->last();
           
            // For Checkout
            $CheckOut = $logs1
            ->where('mydate', $date)->where('user_id', $officer->attendance_id)->where('type', 'Check-Out')->last();
            if ($type == "absent") {
                if (!$CheckIn) {
                    $data = $this->CheckStatus($CheckIn, 'Absent');
                    // For Remarks
                    $comments = AttendanceRemarksMachine1::where('user_id', $officer->id)->where('date', $date)->first();
                    $data->comments = $comments;
                    //
                    $attendance_data[$officer->name]['Check-In'] = $data; 
                    $attendance_data[$officer->name]['Check-Out'] = $this->CheckStatus($CheckOut,'Absent');
                }
            } else if ($type == "late comers") {
                if ($CheckIn && strtotime(date('H:i:s', strtotime($CheckIn->time))) > strtotime($this->time_in)) {
                    $CheckIn->status = 'Late';
                    $data = $this->CheckStatus($CheckIn, 'Check-In');
                    // For Remarks
                    $comments = AttendanceRemarksMachine1::where('user_id', $officer->id)->where('date', $date)->first();
                    $data->comments = $comments;
                    //
                    $attendance_data[$officer->name]['Check-In'] = $data;
                    $attendance_data[$officer->name]['Check-Out'] = $this->CheckStatus($CheckOut,'Check-Out');
                }
            } else if ($type == "present") {
                if ($CheckIn != null) {
                    $data = $this->CheckStatus($CheckIn, 'Check-In');
                    // For Remarks
                    $comments = AttendanceRemarksMachine1::where('user_id', $officer->id)->where('date', $date)->first();
                    $data->comments = $comments;
                    //
                    $attendance_data[$officer->name]['Check-In'] = $data;
                    $attendance_data[$officer->name]['Check-Out'] = $this->CheckStatus($CheckOut,'Check-Out');
                }
            } elseif ($type == null) {
                $data = $this->CheckStatus($CheckIn, 'Check-In');
                // For Remarks
                $comments = AttendanceRemarksMachine1::where('user_id', $officer->id)->where('date', $date)->first();
                $data->comments = $comments;
                //
                $attendance_data[$officer->name]['Check-In'] = $data;
                $attendance_data[$officer->name]['Check-Out'] = $this->CheckStatus($CheckOut,'Check-Out');
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
        $logs2 = AttendanceLogMachine2::select('user_id', 'type', 'time', \DB::raw("convert(varchar, time, 23) as mydate"), 'created_at')
            ->orderBy('user_id', 'ASC')
            ->get();
        foreach ($officers as $officer) {
            $CheckIn = $logs2
                ->where('mydate', $date)->where('user_id', $officer->attendance_id)->where('type', 'Check-In')->last();
            // For Checkout
            $CheckOut = $logs2
                ->where('mydate', $date)->where('user_id', $officer->attendance_id)->where('type', 'Check-Out')->last();
            if ($type == "absent") {
                if (!$CheckIn) {
                    $data = $this->CheckStatus($CheckIn, 'Check-In');
                    // For Remarks
                    $comments = AttendanceRemarksMachine2::where('user_id', $officer->id)->where('date', $date)->first();
                    $data->comments = $comments;
                    //
                    $attendance_data[$officer->name]['Check-In'] = $data;
                    $attendance_data[$officer->name]['Check-Out'] = $this->CheckStatus($CheckOut,'Absent');
                }
            } else if ($type == "late comers") {
                if ($CheckIn && strtotime(date('H:i:s', strtotime($CheckIn->time))) > strtotime($this->time_in)) {
                    $CheckIn->status = 'Late';
                    $data = $this->CheckStatus($CheckIn, 'Check-In');
                    // For Remarks
                    $comments = AttendanceRemarksMachine2::where('user_id', $officer->id)->where('date', $date)->first();
                    $data->comments = $comments;
                    //
                    $attendance_data[$officer->name]['Check-In'] = $data;
                    $attendance_data[$officer->name]['Check-Out'] = $this->CheckStatus($CheckOut,'Check-Out');
                }
            } else if ($type == "present") {
                if ($CheckIn != null) {
                    $data = $this->CheckStatus($CheckIn, 'Check-In');
                    // For Remarks
                    $comments = AttendanceRemarksMachine2::where('user_id', $officer->id)->where('date', $date)->first();
                    $data->comments = $comments;
                    //
                    $attendance_data[$officer->name]['Check-In'] = $data;
                    $attendance_data[$officer->name]['Check-Out'] = $this->CheckStatus($CheckOut,'Check-Out');
                }
            } elseif ($type == null) {
                $data = $this->CheckStatus($CheckIn, 'Check-In');
                // For Remarks
                $comments = AttendanceRemarksMachine2::where('user_id', $officer->id)->where('date', $date)->first();
                $data->comments = $comments;
                //
                $attendance_data[$officer->name]['Check-In'] = $data;
                $attendance_data[$officer->name]['Check-Out'] = $this->CheckStatus($CheckOut,'Check-Out');
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
    public function lateComer()
    {

        if (!isset($request->date) || $request->date == null) {
            $date = date('Y-m-d');
        } else {
            $date = $request->date;
        }
        $user_data = array();
        if ($this->parseDataMachine1($date, 'late comers'))
            $user_data[0] = $this->parseDataMachine1($date, 'late comers');
        if ($this->parseDataMachine2($date, 'late comers'))
            $user_data = array_merge($user_data[0], $this->parseDataMachine2($date, 'late comers'));
        $total_count = count($user_data);
        // dd($total_count);
        return view('attendance.lateComer', compact('user_data'));
    }
    public function dispatches()
    {
        return view('dispatch.dispatch');
    }
    public function creates()
    {
        return view( 'dispatch.create');
    }
    public function AttendanceGraph($name)
    {
        
        $user=AttendanceUserMachine1::where('name',$name)->first();
        $user = $user ? $user : AttendanceUserMachine2::where('name', $name)->first();

        JavaScript::put([
            'user' => $user,
        ]);
        return view( 'attendance.AttendanceGraph');        
    }
    public function attendance_welcome()
    {


        if (!isset($request->date) || $request->date == null) {
            $date = date('Y-m-d');
        } else {
            $date = $request->date;
        }
        //total
        $daily_total = array();
        if ($this->parseDataMachine1($date))
            $user_data[0]=$this->parseDataMachine1($date);
        if ($this->parseDataMachine2($date))
            $user_data=array_merge($user_data[0],$this->parseDataMachine2($date));
        $total_count=count($user_data);

            // dd($daily_total);
        //present persons
        $total_present = array();
        if ($this->parseDataMachine1($date, 'present'))
            $total_present[0]=$this->parseDataMachine1($date, 'present');
        if ($this->parseDataMachine2($date, 'present'))
            if(isset($total_present[0]))
                $total_present=array_merge($total_present[0],$this->parseDataMachine2($date, 'present'));
            else
                $total_present=array_merge($total_present,$this->parseDataMachine2($date, 'present'));
        $total_present_count= count($total_present);

        //absent count
        $total_absent = array();
        if ($this->parseDataMachine1($date, 'absent'))
            $total_absent[0]=$this->parseDataMachine1($date, 'absent');
        if ($this->parseDataMachine2($date, 'absent'))
            if(isset($total_absent[0]))
                $total_absent=array_merge($total_absent[0],$this->parseDataMachine2($date, 'present'));
            else
                $total_absent=array_merge($total_absent,$this->parseDataMachine2($date, 'absent'));
        $total_absent_count= count($total_absent);
        // dd($total_absent);

        //late comers
        $total_latecomers = array();
        if ($this->parseDataMachine1($date, 'late comers'))
            $total_latecomers[0]=$this->parseDataMachine1($date, 'late comers');
        if ($this->parseDataMachine2($date, 'late comers'))
            if(isset($total_latecomers[0]))
                $total_latecomers=array_merge($total_latecomers[0],$this->parseDataMachine2($date, 'present'));
            else
                $total_latecomers=array_merge($total_latecomers,$this->parseDataMachine2($date, 'late comers'));
        $total_late_count= count($total_latecomers);
        return view('welcome', compact('total_count','total_present_count','total_absent_count','total_late_count'));
    }
     public function AttendanceRemarks(Request $request){
         $user1 = AttendanceUserMachine1::where('name', $request->user)->first();
        //  dd($request->all());
        $user2 = AttendanceUserMachine2::where('name', $request->user)->first();
        if($user1){
            $remarks= AttendanceRemarksMachine1::where('user_id',$user1->id)->where('date',$request->date)->first() ? AttendanceRemarksMachine1::where('user_id', $user1->id)->where('date', $request->date)->first() : new AttendanceRemarksMachine1();
            $remarks->user_id=$user1->id;
        }else if($user2){
            $remarks= AttendanceRemarksMachine2::where('user_id',$user2->id)->where('date',$request->date)->first() ? AttendanceRemarksMachine1::where('user_id', $user2->id)->where('date', $request->date)->first() : new AttendanceRemarksMachine2();
            $remarks->user_id=$user2->id;    
        }else{
            return;
        }
        $remarks->date=$request->date;
        $remarks->comments=$request->comments;
        $remarks->save();
        return redirect()->back();        
     }
}
