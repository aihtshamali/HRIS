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
            <input type="submit" class="btn btn-sm btn-success offset-md-1" style="margin-top: 0.5%;" value="Search">
        </form>
        <!-- <input class="form-control col-md-5" id="search" type="text" placeholder="Search Here..."> -->
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
                    <th>Comments</th>
                </tr>
            </thead>
            <tbody id="example">
                @php
                $i=1;
                @endphp
                @foreach ($user_data as $key => $value)
                <tr>
                    <td>{{$i++}}</td>
                    <td><a href="{{route('AttendanceGraph',$key)}}">{{$key}}</a></td>
                    <td><span class="in">{{ isset($value['Check-In']->time) ? date('h:i:s A',strtotime($value['Check-In']->time)) : '-'}}</span></td>
                    <td><span class="incomingstatus">{{isset($value['Check-In']->time) ? $value['Check-In']->status : isset($value['Check-In']->status) ? $value['Check-In']->status : '-'}}</span></td>
                    <td><span class="out">{{isset($value['Check-Out']->time) ? date('h:i:s A',strtotime($value['Check-Out']->time)) : '-'}}</span></td>
                    <td><span class="outgoingstatus">{{isset($value['Check-Out']->time) ? $value['Check-Out']->status :isset($value['Check-Out']->status) ? $value['Check-Out']->status : '-'}}</span></td>
                    <td><form action="{{route('attendance_remarks')}}">
                        @csrf
                        <input type="hidden" name="date" value="{{isset($_GET['date']) ? $_GET['date'] : date('Y-m-d')}} ">
                        <input type="hidden" name="user" value="{{$key}}">
                        <p><select name="comments" id="" required>
                            <option value=""></option>
                            @if (isset($value['Check-In']->comments->comments) && $value['Check-In']->comments->date==$date)
                            <option value="{{$value['Check-In']->comments->comments}}" selected>{{$value['Check-In']->comments->comments}}</option>
                            @endif
                            <option value="On-Visit">On-Visit</option>
                            <option value="On-Leave">On-Leave</option>
                            <option value="On-Half Day">On-Half Day</option>    
                            <option value="On-Short Leave">On-Short Leave</option>    
                            <option value="On-Mat/Pat Leave">On-Mat/Pat Leave</option>    
                            <option value="Earned Leave">Earned Leave</option>    
                        </select></p>
                        <span><button type="submit">Save</button></span>
                    </form></td>
                </tr>
                @endforeach
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