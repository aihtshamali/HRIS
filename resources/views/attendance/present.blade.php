@extends('layout.upperNavigation')
@section('title')
DGME | Present
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
                </tr>
            </thead>
            <tbody id="example">
                @php
                $i=1;
                @endphp
                @foreach ($user_data as $key => $value)
                <tr>
                    <td>{{$i++}}</td>
                    <td>{{$key}}</td>
                    <td><span class="in">{{ isset($value['Check-In']->time) ? date('h:i:s A',strtotime($value['Check-In']->time)) : '-'}}</span></td>
                    <td><span class="incomingstatus">{{isset($value['Check-In']->time) ? $value['Check-In']->status : isset($value['Check-In']->status) ? $value['Check-In']->status : '-'}}</span></td>
                    <td><span class="out">{{isset($value['Check-Out']->time) ? date('h:i:s A',strtotime($value['Check-Out']->time)) : '-'}}</span></td>
                    <td><span class="outgoingstatus">{{isset($value['Check-Out']->time) ? $value['Check-Out']->status :isset($value['Check-Out']->status) ? $value['Check-Out']->status : '-'}}</span></td>
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