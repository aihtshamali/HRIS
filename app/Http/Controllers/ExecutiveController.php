<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AttendanceUserMachine1;
use App\AttendanceUserMachine2;
use App\AttendanceLogMachine1;
use App\AttendanceLogMachine2;
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
        $user_data=array();
         if($this->parseDataMachine1($date))
             array_push($user_data,$this->parseDataMachine1($date));
         if($this->parseDataMachine2($date))
            array_push($user_data,$this->parseDataMachine2($date));

       return view('attendance.dailyattendance',compact('user_data'));
     }
     private function parseDataMachine1($date=null,$type=null){
        $user_data=array(); 
        if($date==null){
            $date=date('Y-m-d');
         }
        $officers=AttendanceUserMachine1::where('status',1)->get();
        $attendance_data=array();
        foreach($officers as $officer)
        {
            $logs1=AttendanceLogMachine1::select('user_id','type','time',\DB::raw("convert(varchar, time, 23) as mydate"),'created_at')
            ->orderBy('user_id','ASC')
            ->get();
            $CheckIn=$logs1
             ->where('mydate',$date)->where('user_id',$officer->attendance_id)->where('type','Check-In')->last();
            $CheckOut=$logs1
             ->where('mydate',$date)->where('user_id',$officer->attendance_id)->where('type','Check-Out')->last();
            if($type=="absent"){
                if(!$CheckIn){
                     $attendance_data[$officer->name]['Check-In']=$CheckIn;
                     $attendance_data[$officer->name]['Check-Out']=$CheckOut;

                    }
            }
            else if($type=="late comers"){
                if($CheckIn && strotime(date('H:i:s',strtotime($CheckIn->time)) > strototime('09:30:00'))){
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
     private function parseDataMachine2($date=null,$type=null){
        $user_data=array(); 
        if($date==null){
            $date=date('Y-m-d');
         }
        $officers=AttendanceUserMachine2::where('status',1)->get();
        $attendance_data=array();
        foreach($officers as $officer)
        {
            $logs2=AttendanceLogMachine2::select('user_id','type','time',\DB::raw("convert(varchar, time, 23) as mydate"),'created_at')
            ->orderBy('user_id','ASC')
            ->get();
            $CheckIn=$logs2
             ->where('mydate',$date)->where('user_id',$officer->attendance_id)->where('type','Check-In')->last();
            $CheckOut=$logs2
             ->where('mydate',$date)->where('user_id',$officer->attendance_id)->where('type','Check-Out')->last();
            if($type=="absent"){
                if(!$CheckIn){
                     $attendance_data[$officer->name]['Check-In']=$CheckIn;
                     $attendance_data[$officer->name]['Check-Out']=$CheckOut;

                    }
            }
            else if($type=="late comers"){
                if($CheckIn && strotime(date('H:i:s',strtotime($CheckIn->time)) > strototime('09:30:00'))){
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
         $user_data=array();
         if($this->parseDataMachine1($date,'present'))
             array_push($user_data,$this->parseDataMachine1($date,'present'));
         if($this->parseDataMachine2($date,'present'))
            array_push($user_data,$this->parseDataMachine2($date,'present'));
         return view('attendance.present',compact('user_data'));
     }
     public function Absent(Request $request)
     {
        if(!isset($request->date) || $request->date==null){
            $date=date('Y-m-d');
        }else{
            $date=$request->date;
        }
         $user_data=array();
        if($this->parseDataMachine1($date,'absent'))
             array_push($user_data,$this->parseDataMachine1($date,'absent'));
        if($this->parseDataMachine2($date,'absent'))
             array_push($user_data,$this->parseDataMachine2($date,'absent'));

       return view('attendance.Absent',compact('user_data'));
     }
}
