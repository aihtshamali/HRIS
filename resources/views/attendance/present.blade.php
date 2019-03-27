@extends('layout.upperNavigation')
@section('title')
  DGME | Present
@endsection
@section('styleTags')
<style>
.navbar-logo,.pcoded-navbar{display:none !important;}
.pcoded[theme-layout="vertical"][vertical-placement="left"][vertical-nav-type="expanded"][vertical-effect="shrink"] .pcoded-content{margin-left:0px !important;}
td, th{text-align:center;}
button, input, optgroup, select, textarea{border-radius:6px !important}
table{margin-top:3% !important;}
th{padding: 8px 0px;}
tr{border-bottom:1px solid #ccc;-webkit-transition: all 600ms ease;transition: all 600ms ease;}
tbody tr:nth-child(even){color:#555;background-color:#eeecec;}
tbody tr:hover{color:#777;background-color:#fff;-webkit-transition: all 600ms ease;transition: all 600ms ease;}
thead:nth-child(1){background: #404e67 !important;color: #fff !important;}
th{border:1px solid #fff;}
td{border: 1px solid #cccccc47;font-weight: 600;}
td{border: 1px solid #cccccc47;font-weight: 600;}
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
    <input class="form-control offset-md-4 col-md-4" id="search" type="text" placeholder="Search Here...">    
</div>
    <div class="row">
        <table class="" style="width:100%">
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
                        <td><span class="in">{{ $value['Check-In']!=null ? date('H:i:s',strtotime($value['Check-In']->time)) : '-'}}</span></td>
                        <td><span class="incomingstatus">{{$value['Check-In']!=null ? (date('H:i:s',strtotime($value['Check-In']->time)) > '09:30:00') ? 'Late' : 'OnTime' : 'Absent'}}</span></td>
                        <td><span class="out">{{$value['Check-Out']!=null ? date('H:i:s',strtotime($value['Check-Out']->time)) : '-'}}</span></td>
                        <td><span class="outgoingstatus">{{$value['Check-Out']!=null ? (date('H:i:s',strtotime($value['Check-Out']->time)) < '05:00:00') ? 'Before Time' : 'OnTime' : '-'}}</span></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
@section("js_scripts")
<script>
$(document).ready(function(){
  $("#search").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#example tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
@endsection