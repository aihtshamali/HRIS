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
                valueFormatString: "####",
                // prefix: "$",
                // labelFormatter: addSymbols
                title: "Time",
                valueFormatString: "0:0#"
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
                    name: "off",
                    showInLegend: true,
                    xValueFormatString: "YYYY mm dd",
                    yValueFormatString: "####",
                    dataPoints: [{
                            x: new Date(2019, 03, 6),
                            y: 1216
                        },
                        {
                            x: new Date(2019, 03, 7),
                            y: 1217
                        }
                    ]
                },
                {
                    type: "line",
                    name: "Incoming Time",
                    showInLegend: true,
                    yValueFormatString: "####",
                    dataPoints: [{
                            x: new Date(2019, 03, 1),
                            y: new Date().getHours()+''+new Date().getMinutes()
                        },
                        {
                            x: new Date(2019, 03, 2),
                            y: new Date().getHours()+''+new Date().getMinutes()
                        },
                        {
                            x: new Date(2019, 03, 3),
                            y: new Date().getHours()+''+new Date().getMinutes()
                        },
                        {
                            x: new Date(2019, 03, 4),
                            y: new Date().getHours()+''+new Date().getMinutes()
                        },
                        {
                            x: new Date(2019, 03, 5),
                            y: new Date().getHours()+''+new Date().getMinutes()
                        },
                        {
                            x: new Date(2019, 03, 8),
                            y: new Date().getHours()+''+new Date().getMinutes()
                        },
                        {
                            x: new Date(2019, 03, 9),
                            y: new Date().getHours()+''+new Date().getMinutes()
                        },
                        {
                            x: new Date(2019, 03, 10),
                            y: new Date().getHours()+''+new Date().getMinutes()
                        },
                        {
                            x: new Date(2019, 03, 11),
                            y: new Date().getHours()+''+new Date().getMinutes()
                        }
                    ]
                },
                {
                    type: "line",
                    name: "Outgoing Time",
                    // markerBorderColor: "white",
                    markerBorderThickness: 2,
                    showInLegend: true,
                    yValueFormatString: "####",
                    dataPoints: [{
                            x: new Date(2019, 03, 1),
                            y: new Date().getHours()+''+new Date().getMinutes()+1
                        },
                        {
                            x: new Date(2019, 03, 2),
                            y: new Date().getHours()+''+new Date().getMinutes()+1
                        },
                        {
                            x: new Date(2019, 03, 3),
                            y: new Date().getHours()+''+new Date().getMinutes()+1
                        },
                        {
                            x: new Date(2019, 03, 4),
                            y: new Date().getHours()+''+new Date().getMinutes()+1
                        },
                        {
                            x: new Date(2019, 03, 5),
                            y: new Date().getHours()+''+new Date().getMinutes()+1
                        },
                        {
                            x: new Date(2019, 03, 8),
                            y: new Date().getHours()+''+new Date().getMinutes()+1
                        },
                        {
                            x: new Date(2019, 03, 9),
                            y: new Date().getHours()+''+new Date().getMinutes()+1
                        },
                        {
                            x: new Date(2019, 03, 10),
                            y: new Date().getHours()+''+new Date().getMinutes()+1
                        },
                        {
                            x: new Date(2019, 03, 11),
                            y: new Date().getHours()+''+new Date().getMinutes()+1
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