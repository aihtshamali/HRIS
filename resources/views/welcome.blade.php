@extends('layout.upperNavigation')
@section('title')
  DGME | Attendance Dashboard
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
    /* card */
    .absiconcardbordrad{position: absolute;margin: -9% 0%;font-size: 36px;box-shadow: -3px 4px 23px #7777773d;text-align: center;padding: 3%;}
    .absiconcard{position: absolute;margin: -16% 0%;font-size: 36px;box-shadow: -3px 4px 23px #7777773d;text-align: center;padding: 3%;border-radius: 58px;}    .orrange{background: #fea11e;color:#fff;}
    .red{background: #ec4d4a;color:#fff;}
    .sky{background: #1cbed3;color:#fff;}
    .green{background: #5eb662;color:#fff;}
    .card-title, .card-text{text-align: right;clear:both;padding: 0px;}
    .card-title-prog, .card-text-prog{clear:both;padding: 0px;}
    .card-text{color: #404e6796;}
    .card-title{color:#404e67;}
    .paddingtop-14{padding-top:14% !important;}
    /* #chartdiv {width: 30%;height: 100px;margin:auto;} */
    #backButton {
		border-radius: 4px;
		padding: 8px;
		border: none;
		font-size: 16px;
		background-color: #2eacd1;
		color: white;
		position: absolute;
		top: 10px;
		right: 10px;
		cursor: pointer;
	}
	.invisible {
		display: none;
	}
	.diagram{margin:auto;color:#fff;font-size:14px;	}
	.donutchart tr td{line-height: 30px !important;}
</style>
@endsection
@section('content')
<div class="row">
  <div class="col-sm-3">
    <div class="card">
      <div class="card-body">
          <div class="col-md-3 absiconcard orrange">
            <i class="feather icon-users"></i>
          </div>
        <h5 class="card-title col-sm-7 offset-md-5 float-right">Attendance</h5>
        <h2 class="card-text">25</h2>
        <hr/>
            <a href="{{route('dailyattendance')}}"><h6><i class="feather icon-file-text"></i> Show All</h6></a>
      </div>
    </div>
  </div>
  <div class="col-sm-3">
    <div class="card">
      <div class="card-body">
          <div class="col-md-3 absiconcard green">
            <i class="feather icon-user"></i>
          </div>
        <h5 class="card-title col-sm-7 offset-md-5 float-right">Present</h5>
        <h2 class="card-text">20</h2>
        <hr/>
            <a href="#!"><h6><i class="feather icon-file-text"></i> Show All</h6></a>
      </div>
    </div>
  </div>
  <div class="col-sm-3">
    <div class="card">
      <div class="card-body">
          <div class="col-md-3 absiconcard red">
            <i class="feather icon-thumbs-down"></i>
          </div>
        <h5 class="card-title col-sm-7 offset-md-5 float-right">Absent</h5>
        <h2 class="card-text">20</h2>
        <hr/>
            <a href="#!"><h6><i class="feather icon-file-text"></i> Show All</h6></a>
      </div>
    </div>
  </div>
  <div class="col-sm-3">
    <div class="card">
      <div class="card-body">
          <div class="col-md-3 absiconcard sky">
            <i class="feather icon-clock"></i>
          </div>
        <h5 class="card-title col-sm-7 offset-md-5 float-right">Late Comers</h5>
        <h2 class="card-text">20</h2>
        <hr/>
            <a href="#!"><h6><i class="feather icon-file-text"></i> Show All</h6></a>
      </div>
    </div>
  </div>
</div>
<div class="row" style="margin-top:3%;">
	<div class="col-sm-6">
    <div class="card">
      <div class="card-body">
          <div class="col-md-11 absiconcardbordrad green" style="padding: 1% !important;">
					<table class="donutchart">
						<tr><th>sortOrder</th><th>value</th><th>color</th><th>description</th></tr>
						<tr><td>1</td><td>10</td><td>red</td><td>kl</td></tr>
						<tr><td>2</td><td>40</td><td>blue</td><td>parso</td></tr>
						<tr><td>3</td><td>50</td><td>green</td><td>tarso</td></tr>
						<tr><td>4</td><td>70</td><td>black</td><td>us sy pichla</td></tr>
						<tr><td>5</td><td>15</td><td>greenyellow</td><td>usk b pichla</td></tr>
					</table>
          </div>
        <h5 class="card-title-prog paddingtop-14">Absentees - Last 5 days</h5>
        <hr/>
            <a href="#!"><h6><i class="feather icon-clock"></i> Updated few moments ago</h6></a>
      </div>
    </div>
  </div>
	<div class="col-sm-6">
    <div class="card">
      <div class="card-body">
          <div class="col-md-11 absiconcardbordrad red">
					<div
						id="diagram-id-1"
						class="diagram"
						data-circle-diagram='{
							"percent": "34.2%",
							"month": "january",
							"size": "100px",
							"sizelineheight": "90px",
							"borderWidth": "4",
							"bgFill": "#cacaca",
							"frFill": "#80d03c",
							"textSize": "56",
							"textColor": "#585858"
							}'>
					</div>
          <button class="btn invisible" id="backButton">Back</button>
          </div>
        <h5 class="card-title-prog paddingtop-14">Absentees - By Month</h5>
        <hr/>
            <a href="#!"><h6><i class="feather icon-clock"></i> Updated Today</h6></a>
      </div>
    </div>
  </div>
</div>
@endsection
@section("js_scripts")
<script src="{{asset('js/jquery.circle-diagram.js')}}"></script>
<script src="{{asset('js/main.js')}}"></script>
<script src="{{asset('js/jquery.chart.js')}}"></script>
<script>
		$(function(){
			if(!(/^\?noconvert/gi).test(location.search))
				$(".donutchart").donutChart().css("border","solid 1px black");
		});
</script>
<script type="text/javascript">

var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-36251023-1']);
_gaq.push(['_setDomainName', 'jqueryscript.net']);
_gaq.push(['_trackPageview']);

(function() {
	var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();

</script>
@endsection