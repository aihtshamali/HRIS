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
use Carbon;
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
        $user_data = array([]);
        if ($this->parseDataMachine1($date))
            $user_data[0]=$this->parseDataMachine1($date);
        if ($this->parseDataMachine2($date))
            $user_data=array_merge($user_data[0],$this->parseDataMachine2($date));

        return view('attendance.dailyattendance', compact('user_data','date'));
    }
    // -----------PRIVATE-------------

    private function CheckStatus($attendance_data, $type)
    {
        if (!isset($attendance_data->time) || $type== 'Absent') {
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
        // Getting All Logs from Machine 1
        $log_data = collect(DB::select('exec getTodaysAttendanceMachine1 "' . $date . '"'));
        $officers = collect(DB::select('exec getAllOfficers'));
        $attendance_data = array();
        // Getting All Logs from Machine 1
        $logs1 = AttendanceLogMachine1::select('user_id', 'type', 'time', \DB::raw("convert(varchar, time, 23) as mydate"), 'created_at')
        ->orderBy('user_id', 'ASC')
        ->get();
        foreach ($officers as $officer) {
            // For Check-In
            $CheckIn = $log_data
            ->where('user_id', $officer->attendance_id)->where('type', 'Check-In')->first();
            // For Checkout
            // dd($CheckIn,$officer);
            $CheckOut = $log_data->where('user_id', $officer->attendance_id)->where('type', 'Check-Out')->first();
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
        $log_data = collect(DB::select('exec getTodaysAttendanceMachine2 "' . $date . '"'));
       
        $officers = collect(DB::select('exec getAllOfficials'));
        $attendance_data = array();
        $logs2 = AttendanceLogMachine2::select('user_id', 'type', 'time', \DB::raw("convert(varchar, time, 23) as mydate"), 'created_at')
            ->orderBy('user_id', 'ASC')
            ->get();
        foreach ($officers as $officer) {
            $CheckIn = $log_data->where('user_id', $officer->attendance_id)->where('type', 'Check-In')->first();
            // For Checkout

            $CheckOut = $log_data->where('user_id', $officer->attendance_id)->where('type', 'Check-Out')->first();
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
    function getDatesFromRange($Date1, $Date2)
    {
        // Declare an empty array 
        $array = array();

        // Use strtotime function 
        $Variable1 = strtotime($Date1);
        $Variable2 = strtotime($Date2);

        // Use for loop to store dates into array 
        // 86400 sec = 24 hrs = 60*60*24 = 1 day 
        for (
            $currentDate = $Variable1;
            $currentDate <= $Variable2;
            $currentDate += (86400)
        ) {

            $Store = date('Y-m-d', $currentDate);
            $array[] = $Store;
        } 
        return $array;
    }
    private function parseMonthlyMachine1($date = null, $officerID)
    {
        if ($date == null) {
            $date = date('Y-m-d');
        }
        // Getting All Logs from Machine 1
        $allDates = $this->getDatesFromRange(date('Y-m-01'),date('Y-m-d'));
        $log_data = collect(DB::select('exec getOfficersMachine1 "' . $date . '",'.$officerID));
        $attendance_data = array();
        // dump($log_data);
        // Getting All Logs from Machine 1
        foreach($allDates as $day){
            $data_days = $log_data->where('current_day', $day);
            foreach($data_days as $data_day){
                if($data_day){
                    if($data_day->type == 'Check-In'){
                        $temp = array("name" => $data_day->name, "time" => $data_day->time,"type" => $data_day->type); 
                        $attendance_data[$day]['CheckIn']=$temp;
                    
                    }
                    else if($data_day->type == 'Check-Out')
                    {
                        $temp = array("name" => $data_day->name, "time" => $data_day->time,"type" => $data_day->type); 
                        $attendance_data[$day]['CheckOut']=$temp;
                    }
                    
                } 
            }
            if(!count($data_days)){
                $status = collect();
                $status->type = "Absent";
                $attendance_data[$day]=$status;    
                
            }
        }
        return $attendance_data;
    }
    private function parseMonthlyMachine2($date = null, $officerID)
    {
        if ($date == null) {
            $date = date('Y-m-d');
        }
        // Getting All Logs from Machine 1
        $allDates = $this->getDatesFromRange(date('Y-m-01'),date('Y-m-d'));
        $log_data = collect(DB::select('exec getOfficersMachine2 "' . $date . '",'.$officerID));
        $attendance_data = array();
        // dump($log_data);
        // Getting All Logs from Machine 1
        foreach($allDates as $day){
            $data_days = $log_data->where('current_day', $day);
            // dump($data_days);
            foreach($data_days as $data_day){
            if($data_day){
                if($data_day->type == 'Check-In'){
                    $temp = array("name" => $data_day->name, "time" => $data_day->time, "type" => $data_day->type); 
                    $attendance_data[$day]['CheckIn']=$temp;
                    
                }
                else if($data_day->type == 'Check-Out')
                {
                    $temp = array("name" => $data_day->name, "time" => $data_day->time, "type" => $data_day->type); 
                    $attendance_data[$day]['CheckOut']=$temp;
                }
                
            } 
        }
        if(!count($data_days)){
            $status = collect();
            $status->type = "Absent";
            $attendance_data[$day]=$status;    

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
        $user_data = array([]);
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
        $user_data = array([]);
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
        $user_data = array([]);
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
        $start = new Carbon\Carbon('first day of this month');
        $start = $start->isoFormat('Y-MM-DD');
        $end = date('Y-m-d');
        $user=AttendanceUserMachine1::where('name',$name)->first();
        $user = $user ? $user : AttendanceUserMachine2::where('name', $name)->first();
        $daily_data = collect();
        if ($user instanceof AttendanceUserMachine1) { 
            $daily_data = $this->parseMonthlyMachine1(date('Y-m-01'),$user->attendance_id);
        }else {
            
            $daily_data = $this->parseMonthlyMachine2(date('Y-m-01'),$user->attendance_id);
        }
        if($user==null){
            return redirect()->back();
        }
        $user_data = collect(DB::select('exec getUserMonthlyAttendance "'.$start.'","'.$end.'","'.$user->attendance_id.'","'.$user->machine_num.'"'));
        $Checkingraph_data = array();
        $Checkoutgraph_data = array();
        foreach($user_data as $data){
            $month=date('m',strtotime($data->time));
            $year=date('Y',strtotime($data->time));
            $day=date('d',strtotime($data->time));
            $time=(int)date('Hi',strtotime($data->time));
            $type=$data->type;
            if($type == "Check-In"){
               array_push($Checkingraph_data,['month'=>$month,'year'=>$year,'day'=>$day,'time'=>$time,'status'=>$type]);
            }
            else if($type== "Check-Out")
            {
                array_push($Checkoutgraph_data,['month'=>$month,'year'=>$year,'day'=>$day,'time'=>$time,'status'=>$type]);
            }
        }
        JavaScript::put([
            'user' => $user,
            'CheckInData' =>$Checkingraph_data,
            'CheckOutData' =>$Checkoutgraph_data,
        ]);
        // dd($Checkingraph_data);
        return view('attendance.AttendanceGraph',['user_data'=>$user_data,'name'=>$name,'daily_data'=>$daily_data]);
    }
    public function getAttendanceByStatus(Request $request){

        $date = date('Y-m-d');
        $machine1 = $this->parseDataMachine1($date,$request->status);
        $machine2 = $this->parseDataMachine2($date,$request->status);
        $user_data =array([]);
        if (count($machine1))
            $user_data[0] = $machine1;
        if (count($machine2))
            $user_data = array_merge($user_data[0], $machine2);
        $total_count = count($user_data);
        return response()->json($total_count);
    }
    public function attendance_welcome()
    {

        // if (!isset($request->date) || $request->date == null) {
            // $date = date('Y-m-d');
        // } else {
        //     $date = $request->date;
        // }
        //total
        // $daily_total = array();
        // $machine1=$this->parseDataMachine1($date);
        // $machine2=$this->parseDataMachine2($date);
        // if (count($machine1))
        //     $user_data[0]=$machine1;
        // if (count($machine2))
        //     $user_data=array_merge($user_data[0],$machine2);
        // $total_count=count($user_data);
        //     // dd(count($user_data));
        // //present persons
        // $total_present = array();
        // $presentMachine1 = $this->parseDataMachine1($date, 'present');
        // $presentMachine2 = $this->parseDataMachine2($date, 'present');
        // if (count($presentMachine1))
        //     $total_present[0]= $presentMachine1;
        // if (count($presentMachine2))
        //     if(isset($total_present[0]))
        //         $total_present=array_merge($total_present[0],$presentMachine2);
        //     else
        //         $total_present=array_merge($total_present,$presentMachine2);
        // $total_present_count= count($total_present);

        // //absent count
        // $absentMachine1 = $this->parseDataMachine1($date, 'absent');
        // $absentMachine2 = $this->parseDataMachine2($date, 'absent');
        // $total_absent = array();
        // if (count($absentMachine1))
        //     $total_absent[0]=$absentMachine1;
        // if (count($absentMachine2))
        //     if(isset($total_absent[0]))
        //         $total_absent=array_merge($total_absent[0],$absentMachine2);
        //     else
        //         $total_absent=array_merge($total_absent,$absentMachine2);
        // $total_absent_count= count($total_absent);

        // //late comers
        // $lateMachine1 = $this->parseDataMachine1($date, 'late comers');
        // $lateMachine2 = $this->parseDataMachine2($date, 'late comers');
        // $total_latecomers = array();
        // if (count($lateMachine1))
        //     $total_latecomers[0]=$lateMachine1;
        // if (count($lateMachine2))
        //     if(isset($total_latecomers[0]))
        //         $total_latecomers=array_merge($total_latecomers[0],$lateMachine2);
        //     else
        //         $total_latecomers=array_merge($total_latecomers,$lateMachine2);
        // $total_late_count= count($total_latecomers);
        return view('welcome'
        // , compact('total_count','total_present_count','total_absent_count','total_late_count')
            );
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

        if($request->comments=="del"){
            $remarks->delete();
        }
        else{
            $remarks->date=$request->date;
            $remarks->comments=$request->comments;
            $remarks->save();
        }

        return redirect()->back();
     }
}
