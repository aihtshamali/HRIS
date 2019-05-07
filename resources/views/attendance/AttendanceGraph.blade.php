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
                // valueFormatString: "####",
                // prefix: "$",
                // labelFormatter: addSymbols
                title: "Time",
                valueFormatString: "0:00"
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
            data: [{
                    type: "column",
                    name: "Public Holiday",
                    showInLegend: true,
                    xValueFormatString: "YYYY MM DD",
                    yValueFormatString: "##:##",
                    dataPoints: [{
                            x: new Date(2019, 03, 6),
                            y: 1800
                        },
                        {
                            x: new Date(2019, 03, 7),
                            y: 1800
                        }, {
                            x: new Date(2019, 03, 13),
                            y: 1800
                        },
                        {
                            x: new Date(2019, 03, 14),
                            y: 1800
                        }, {
                            x: new Date(2019, 03, 20),
                            y: 1800
                        },
                        {
                            x: new Date(2019, 03, 21),
                            y: 1800
                        }, 
                        {
                            x: new Date(2019, 03, 27),
                            y: 1800
                        },
                        {
                            x: new Date(2019, 03, 28),
                            y: 1800
                        }
                    ]
                },
                {
                    type: "line",
                    name: "Incoming Time",
                    showInLegend: true,
                    yValueFormatString: "##:##",
                    dataPoints: [{
                            x: new Date(2019, 03, 1),
                            // y: new Date().getHours()+''+new Date().getMinutes()
                            y: 900
                        },
                        {
                            x: new Date(2019, 03, 2),
                            // y: new Date().getHours()+''+new Date().getMinutes()
                            y: 920
                        },
                        {
                            x: new Date(2019, 03, 3),
                            // y: new Date().getHours()+''+new Date().getMinutes()
                            y: 1000
                        },
                        {
                            x: new Date(2019, 03, 4),
                            // y: new Date().getHours()+''+new Date().getMinutes()
                            y: 1200
                        },
                        {
                            x: new Date(2019, 03, 5),
                            // y: new Date().getHours()+''+new Date().getMinutes()
                            y: 1100
                        },
                        {
                            x: new Date(2019, 03, 8),
                            // y: new Date().getHours()+''+new Date().getMinutes()
                            y: 900
                        },
                        {
                            x: new Date(2019, 03, 9),
                            // y: new Date().getHours()+''+new Date().getMinutes()
                            y: 0
                        },
                        {
                            x: new Date(2019, 03, 10),
                            // y: new Date().getHours()+''+new Date().getMinutes()
                            y: 900
                        },
                        {
                            x: new Date(2019, 03, 11),
                            // y: new Date().getHours()+''+new Date().getMinutes()
                            y: 900
                        },
                        {
                            x: new Date(2019, 03, 12),
                            // y: new Date().getHours()+''+new Date().getMinutes()
                            y: 900
                        },
                        {
                            x: new Date(2019, 03, 15),
                            // y: new Date().getHours()+''+new Date().getMinutes()
                            y: 900
                        },
                        {
                            x: new Date(2019, 03, 16),
                            // y: new Date().getHours()+''+new Date().getMinutes()
                            y: 900
                        },
                        {
                            x: new Date(2019, 03, 17),
                            // y: new Date().getHours()+''+new Date().getMinutes()
                            y: 900
                        },
                        {
                            x: new Date(2019, 03, 18),
                            // y: new Date().getHours()+''+new Date().getMinutes()+1
                            y: 900
                        },
                        {
                            x: new Date(2019, 03, 19),
                            // y: new Date().getHours()+''+new Date().getMinutes()
                            y: 900
                        },
                        {
                            x: new Date(2019, 03, 22),
                            // y: new Date().getHours()+''+new Date().getMinutes()
                            y: 900
                        },
                        {
                            x: new Date(2019, 03, 23),
                            // y: new Date().getHours()+''+new Date().getMinutes()
                            y: 900
                        },
                        {
                            x: new Date(2019, 03, 24),
                            // y: new Date().getHours()+''+new Date().getMinutes()
                            y: 900
                        },
                        {
                            x: new Date(2019, 03, 25),
                            // y: new Date().getHours()+''+new Date().getMinutes()
                            y: 900
                        },
                        {
                            x: new Date(2019, 03, 26),
                            // y: new Date().getHours()+''+new Date().getMinutes()
                            y: 900
                        },
                        {
                            x: new Date(2019, 03, 29),
                            // y: new Date().getHours()+''+new Date().getMinutes()
                            y: 900
                        },
                        {
                            x: new Date(2019, 03, 30),
                            // y: new Date().getHours()+''+new Date().getMinutes()
                            y: 900
                        }
                    ]
                },
                {
                    type: "line",
                    name: "Outgoing Time",
                    // markerBorderColor: "white",
                    markerBorderThickness: 2,
                    showInLegend: true,
                    yValueFormatString: "##:##",
                    dataPoints: [{
                            x: new Date(2019, 03, 1),
                            // y: new Date().getHours()+''+new Date().getMinutes()+1
                            y: 1700
                        },
                        {
                            x: new Date(2019, 03, 2),
                            // y: new Date().getHours()+''+new Date().getMinutes()+1
                            y: 1600
                        },
                        {
                            x: new Date(2019, 03, 3),
                            // y: new Date().getHours()+''+new Date().getMinutes()+1
                            y: 1700
                        },
                        {
                            x: new Date(2019, 03, 4),
                            // y: new Date().getHours()+''+new Date().getMinutes()+1
                            y: 1700
                        },
                        {
                            x: new Date(2019, 03, 5),
                            // y: new Date().getHours()+''+new Date().getMinutes()+1
                            y: 1700
                        },
                        {
                            x: new Date(2019, 03, 8),
                            // y: new Date().getHours()+''+new Date().getMinutes()+1
                            y: 1400
                        },
                        {
                            x: new Date(2019, 03, 9),
                            // y: new Date().getHours()+''+new Date().getMinutes()+1
                            y: 1700
                        },
                        {
                            x: new Date(2019, 03, 10),
                            // y: new Date().getHours()+''+new Date().getMinutes()+1
                            y: 1200
                        },
                        {
                            x: new Date(2019, 03, 11),
                            // y: new Date().getHours()+''+new Date().getMinutes()+1
                            y: 1700
                        },
                        {
                            x: new Date(2019, 03, 12),
                            // y: new Date().getHours()+''+new Date().getMinutes()
                            y: 1600
                        },
                        {
                            x: new Date(2019, 03, 15),
                            // y: new Date().getHours()+''+new Date().getMinutes()
                            y: 1600
                        },
                        {
                            x: new Date(2019, 03, 16),
                            // y: new Date().getHours()+''+new Date().getMinutes()
                            y: 1600
                        },
                        {
                            x: new Date(2019, 03, 17),
                            // y: new Date().getHours()+''+new Date().getMinutes()
                            y: 1600
                        },
                        {
                            x: new Date(2019, 03, 18),
                            // y: new Date().getHours()+''+new Date().getMinutes()+1
                            y: 1700
                        },
                        {
                            x: new Date(2019, 03, 19),
                            // y: new Date().getHours()+''+new Date().getMinutes()
                            y: 1600
                        },
                        {
                            x: new Date(2019, 03, 22),
                            // y: new Date().getHours()+''+new Date().getMinutes()
                            y: 1600
                        },
                        {
                            x: new Date(2019, 03, 23),
                            // y: new Date().getHours()+''+new Date().getMinutes()
                            y: 1600
                        },
                        {
                            x: new Date(2019, 03, 24),
                            // y: new Date().getHours()+''+new Date().getMinutes()
                            y: 1600
                        },
                        {
                            x: new Date(2019, 03, 25),
                            // y: new Date().getHours()+''+new Date().getMinutes()
                            y: 1600
                        },
                        {
                            x: new Date(2019, 03, 26),
                            // y: new Date().getHours()+''+new Date().getMinutes()
                            y: 1600
                        },
                        {
                            x: new Date(2019, 03, 29),
                            // y: new Date().getHours()+''+new Date().getMinutes()
                            y: 1600
                        },
                        {
                            x: new Date(2019, 03, 30),
                            // y: new Date().getHours()+''+new Date().getMinutes()
                            y: 1600
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