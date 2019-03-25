<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AttendanceUser;
use App\Log;
use DB;
class ExecutiveController extends Controller
{
     // attendance
     public function attendance()
     {
       return view('attendance.attendancedashboard');
     }
     public function dailyattendance(Request $request)
     {
        if(!isset($request->date) || $request->date==null){
            $date=date('Y-m-d');
        }else{
            $date=$request->date;
        }
        $user_data=$this->parseData($date);

       return view('attendance.dailyattendance',compact('user_data'));
     }
     private function parseData($date=null,$type=null){
        $user_data=array(); 
        if($date==null){
            $date=date('Y-m-d');
         }
        $officers=AttendanceUser::where('status',1)->get();
        $attendance_data=array();
        foreach($officers as $officer)
        {
            $logs=Log::select('user_id','type','time',\DB::raw("convert(varchar, time, 23) as mydate"),'created_at')
            ->orderBy('user_id','ASC')
            ->get();

            $CheckIn=$logs
             ->where('mydate',$date)->where('user_id',$officer->id)->where('type','Check-In')->last();
            //  dd($CheckIn);
            $CheckOut=$logs
             ->where('mydate',$date)->where('user_id',$officer->id)->where('type','Check-Out')->last();
            if($type=="absent"){
                if(!$CheckIn){
                     $attendance_data[$officer->name]['Check-In']=$CheckIn;
                     $attendance_data[$officer->name]['Check-Out']=$CheckOut;

                    }
            }
            else if($type=="late comers"){
                if($CheckIn && strotime(date('H:i:s',strtotime($CheckIn->time)) > strototime('09:00:00'))){
                    $CheckIn->status='Late';
                    $attendance_data[$officer->name]['Check-In']=$CheckIn;
                    $attendance_data[$officer->name]['Check-Out']=$CheckOut;

                }
            }
            else if($type=="present"){
                if($CheckIn!=null){
                    $attendance_data[$officer->name]['Check-In']=$CheckIn;
                    $attendance_data[$officer->name]['Check-Out']=$CheckOut;
                }
                    
            }
            elseif($type==null){
                $attendance_data[$officer->name]['Check-In']=$CheckIn;
                $attendance_data[$officer->name]['Check-Out']=$CheckOut;
            }
        }
        return $attendance_data;
     }
     public function present(Request $request)
     {
         if(!isset($request->date) || $request->date==null){
             $date=date('Y-m-d');
         }else{
             $date=$request->date;
         }
         $user_data=$this->parseData($date,'present');
         return view('attendance.present',compact('user_data'));
     }
     public function Absent(Request $request)
     {
        if(!isset($request->date) || $request->date==null){
            $date=date('Y-m-d');
        }else{
            $date=$request->date;
        }
        $user_data=$this->parseData($date,'absent');

       return view('attendance.Absent',compact('user_data'));
     }
}