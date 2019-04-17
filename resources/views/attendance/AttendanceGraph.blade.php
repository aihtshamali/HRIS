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
@endsection
@section("js_scripts")
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script>
    window.onload = function() {
        var today = new Date();
        var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();

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
                valueFormatString: "MM/DD",
                // prefix: "$",
                // labelFormatter: addSymbols
                title: "Time"
            },
            toolTip: {
                shared: true
            },
            legend: {
                cursor: "pointer",
                itemclick: toggleDataSeries
            },
            data: [{
                    type: "column",
                    // name: "off",
                    showInLegend: true,
                    xValueFormatString: "YYYY mm dd",
                    yValueFormatString: "$#,##0",
                    dataPoints: [{
                            x: new Date(2019, 03, 6),
                            y: 60
                        },
                        {
                            x: new Date(2019, 03, 7),
                            y: 60
                        }
                    ]
                },
                {
                    type: "line",
                    name: "Incoming Time",
                    showInLegend: true,
                    yValueFormatString: "$#,##0",
                    dataPoints: [{
                            x: new Date(2019, 03, 1),
                            y: 23
                        },
                        {
                            x: new Date(2019, 03, 2),
                            y: 23
                        },
                        {
                            x: new Date(2019, 03, 3),
                            y: 33
                        },
                        {
                            x: new Date(2019, 03, 4),
                            y: 43
                        },
                        {
                            x: new Date(2019, 03, 5),
                            y: 43
                        },
                        {
                            x: new Date(2019, 03, 8),
                            y: 53
                        },
                        {
                            x: new Date(2019, 03, 9),
                            y: 63
                        },
                        {
                            x: new Date(2019, 03, 10),
                            y: 63
                        },
                        {
                            x: new Date(2019, 03, 11),
                            y: 53
                        }
                    ]
                },
                {
                    type: "line",
                    name: "Outgoing Time",
                    // markerBorderColor: "white",
                    markerBorderThickness: 2,
                    showInLegend: true,
                    yValueFormatString: "$#,##0",
                    dataPoints: [{
                            x: new Date(2019, 03, 1),
                            y: 25
                        },
                        {
                            x: new Date(2019, 03, 2),
                            y: 10
                        },
                        {
                            x: new Date(2019, 03, 3),
                            y: 15
                        },
                        {
                            x: new Date(2019, 03, 4),
                            y: 55
                        },
                        {
                            x: new Date(2019, 03, 5),
                            y: 35
                        },
                        {
                            x: new Date(2019, 03, 8),
                            y: 5
                        },
                        {
                            x: new Date(2019, 03, 9),
                            y: 30
                        },
                        {
                            x: new Date(2019, 03, 10),
                            y: 63
                        },
                        {
                            x: new Date(2019, 03, 11),
                            y: 53
                        }
                    ]
                }
            ]
        });
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