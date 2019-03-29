@extends('layout.upperNavigation')
@section('title')
DGME | Daily Attendance
@endsection
@section('styleTags')
<style>
    
</style>
@endsection
@section('content')
<div class="">
    <div class="row">
        <form action="" method="get" class="col-md-4">
            {{ csrf_field() }}
            <input type="date" class="form-control col-md-6 float-left" name="date">
            <input type="submit" class="btn btn-sm btn-success offset-md-1" style="margin-top: 0.5%;" value="Submit">
        </form>
        <input class="form-control col-md-5" id="search" type="text" placeholder="Search Here...">
    </div>
    <div class="row">
        <table id="simpletable" class="table table-striped table-bordered nowrap" style="width:100%">
            <thead>
                <tr class"">
                    <th>Sr #.</th>
                    <th>Name</th>
                    <th>In</th>
                    <th>Incoming Status</th>
                    <th>Out</th>
                    <th>Outgoing Status</th>
                </tr>
            </thead>
            <tbody id="example">
                @php
                $i=1;
                @endphp
                @if(isset($user_data[0]))
                @foreach ($user_data[0] as $key => $value)
                <tr>
                    <td>{{$i++}}</td>
                    <td>{{$key}}</td>
                    <td><span class="in">{{ $value['Check-In'] ? date('H:i:s',strtotime($value['Check-In']->time)) : '-'}}</span></td>
                    <td><span class="incomingstatus">{{$value['Check-In'] ? (date('H:i:s',strtotime($value['Check-In']->time)) > '09:30:00') ? 'Late' : 'OnTime' : 'Absent'}}</span></td>
                    <td><span class="out">{{$value['Check-Out'] ? date('H:i:s',strtotime($value['Check-Out']->time)) : '-'}}</span></td>
                    <td><span class="outgoingstatus">{{$value['Check-Out'] ? (date('H:i:s',strtotime($value['Check-Out']->time)) < '05:00:00') ? 'Before Time' : 'OnTime' : '-'}}</span></td>
                </tr>
                @endforeach
                @endif
                @if(isset($user_data[1]))
                @foreach ($user_data[1] as $key => $value)
                <tr>
                    <td>{{$i++}}</td>
                    <td>{{$key}}</td>
                    <td><span class="in">{{ $value['Check-In'] ? date('H:i:s',strtotime($value['Check-In']->time)) : '-'}}</span></td>
                    <td><span class="incomingstatus">{{$value['Check-In'] ? (date('H:i:s',strtotime($value['Check-In']->time)) > '09:30:00') ? 'Late' : 'OnTime' : 'Absent'}}</span></td>
                    <td><span class="out">{{$value['Check-Out'] ? date('H:i:s',strtotime($value['Check-Out']->time)) : '-'}}</span></td>
                    <td><span class="outgoingstatus">{{$value['Check-Out'] ? (date('H:i:s',strtotime($value['Check-Out']->time)) < '05:00:00') ? 'Before Time' : 'OnTime' : '-'}}</span></td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
@section("js_scripts")
<script>
    $(document).ready(function() {
        $("#search").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#example tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
@endsection 