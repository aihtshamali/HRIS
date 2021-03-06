@extends('layout.upperNavigation')
@section('title')
DGME | Daily Attendance
@endsection
@section('styleTags')
<style>
</style>
@endsection
@section('content')
<div id="chartContainer" style="height: 500px; width: 100%;"></div>
<table style="width:100%;">
    <thead>
        <tr>
            <th colspan="4" style="text-transform:capitalize">{{$user_data[0]->name}}</th>
        </tr>
        <tr class"">
            <th>Sr #.</th>
            <th>Attendance Status</th>
            <th>Date</th>
            <th>Time</th>
        </tr>
    </thead>
    @php
        $i=1
    @endphp
    <tbody id="example">
        @foreach ($user_data as $data)
            
            <tr>
                <th>{{$i++}}.</th>
                <th>{{$data->type}}</th>
                <th>{{date('Y-m-d',strtotime($data->time))}}</th>
                <th>{{date('h:i:s a',strtotime($data->time))}}</th>
            </tr>
        @endforeach
        {{-- <tr>
            <th>2.</th>
            <th>No</th>
            <th>00:00</th>
            <th>00:00</th>
        </tr>
        <tr>
            <th>3.</th>
            <th>yes</th>
            <th>09:00</th>
            <th>05:00</th>
        </tr> --}}
    </tbody>
</table>
@endsection
@section("js_scripts")
<script src="{{ asset('js/canvas.js')}}"></script>
<script>
    window.onload = function() {
        // var today = new Date();
        // var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
        var CheckInGraphData=[];
        CheckInData.forEach(element => {
            CheckInGraphData.push({x: new Date(element.year,element.month-1,element.day),y:element.time})
        });
        var CheckOutGraphData=[];
        CheckOutData.forEach(element => {
            CheckOutGraphData.push({x: new Date(element.year,element.month-1,element.day),y:element.time})
        });
        console.log(CheckInGraphData);
                        
        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            theme: "light2",
            title: {
                text: "Monthly Attendance"
            },
            axisX: {
                valueFormatString: "MM/DD",
                title: "Date",
                gridThickness: 1
            },
            axisY: {
                // valueFormatString: "####",
                // prefix: "$",
                // labelFormatter: addSymbols
                title: "Time",
                valueFormatString: "00:00"
                // minimum: 800,
                // maximum: 1700,
            },
            toolTip: {
                shared: true
            },
            legend: {
                cursor: "pointer",
                itemclick: toggleDataSeries
            },
            data: [
                // {
                //     type: "column",
                //     name: "Public Holiday",
                //     showInLegend: true,
                //     xValueFormatString: "YYYY MM DD",
                //     yValueFormatString: "##:##",
                //     dataPoints: [
                //         {
                //             x: new Date(2019, 06, 06),
                //             y: 1200
                //         },
                //         {
                //             x: new Date(2019, 06, 07),
                //             y: 1400
                //         }, {
                //             x: new Date(2019, 06, 13),
                //             y: 1600
                //         },
                //         {
                //             x: new Date(2019, 06, 14),
                //             y: 1800
                //         }, {
                //             x: new Date(2019, 06, 20),
                //             y: 2000
                //         },
                //         {
                //             x: new Date(2019, 06, 21),
                //             y: 1200
                //         },
                //         {
                //             x: new Date(2019, 06, 27),
                //             y: 1200
                //         },
                //         {
                //             x: new Date(2019, 06, 28),
                //             y: 1200
                //         }
                //     ]
                // },
                {
                    type: "line",
                    name: "Incoming Time",
                    showInLegend: true,
                    yValueFormatString: "##:##",
                    dataPoints: CheckInGraphData
                },
                {
                    type: "line",
                    name: "Outgoing Time",
                    // markerBorderColor: "white",
                    markerBorderThickness: 2,
                    showInLegend: true,
                    yValueFormatString: "##:##",
                    dataPoints: CheckOutGraphData
                }
            ]
        });
        console.log(chart);
        chart.render();

        function addSymbols(e) {
            var suffixes = ["", "K", "M", "B"];
            var order = Math.max(Math.floor(Math.log(e.value) / Math.log(1000)), 0);

            if (order > suffixes.length - 1)
                order = suffixes.length - 1;

            var suffix = suffixes[order];
            return CanvasJS.formatNumber(e.value / Math.pow(1000, order)) + suffix;
        }

        function toggleDataSeries(e) {
            if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                e.dataSeries.visible = false;
            } else {
                e.dataSeries.visible = true;
            }
            e.chart.render();
        }

    }
</script>
@endsection