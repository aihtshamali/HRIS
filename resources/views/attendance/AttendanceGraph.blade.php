@extends('layout.upperNavigation')
@section('title')
DGME | Daily Attendance
@endsection
@section('styleTags')
<style>
    #chartdiv {
        width: 100%;
        height: 500px;
    }
</style>
@endsection
@section('content')
<div id="chartdiv"></div>
@endsection
@section("js_scripts")
<!-- Resources -->
<script src="https://www.amcharts.com/lib/4/core.js"></script>
<script src="https://www.amcharts.com/lib/4/charts.js"></script>
<!-- <script src="https://www.amcharts.com/lib/4/themes/animated.js"></script> -->

<!-- Chart code -->
<script>
    // Themes begin
    // am4core.useTheme(am4themes_animated);
    // Themes end

    // Create chart instance
    var chart = am4core.create("chartdiv", am4charts.XYChart);

    chart.colors.step = 2;
    chart.maskBullets = false;

    // Add data
    chart.data = [{
        "date": "2012-01-01",
        "Time": 227,
        "townName": "New York",
        // "townName2": "New York",
        // "townSize": 12,
        "latitude": 40.71,
        "Time": 408
    }, {
        "date": "2012-01-02",
        "Time": 371,
        // "townName": "Washington",
        "townSize": 7,
        "latitude": 38.89,
        "Time": 482
    }, {
        "date": "2012-01-03",
        "Time": 433,
        // "townName": "Wilmington",
        "townSize": 3,
        "latitude": 34.22,
        "Time": 562
    }, {
        "date": "2012-01-04",
        "Time": 345,
        // "townName": "Jacksonville",
        "townSize": 3.5,
        "latitude": 30.35,
        "Time": 379
    }, {
        "date": "2012-01-05",
        "Time": 480,
        // "townName": "Miami",
        // "townName2": "Miami",
        "townSize": 5,
        "latitude": 25.83,
        "Time": 501
    }, {
        "date": "2012-01-06",
        "Time": 386,
        // "townName": "Tallahassee",
        "townSize": 3.5,
        "latitude": 30.46,
        "Time": 443
    }, {
        "date": "2012-01-07",
        "Time": 348,
        // "townName": "New Orleans",
        "townSize": 5,
        "latitude": 29.94,
        "Time": 405
    }, {
        "date": "2012-01-08",
        "Time": 238,
        // "townName": "Houston",
        // "townName2": "Houston",
        "townSize": 8,
        "latitude": 29.76,
        "Time": 309
    }, {
        "date": "2012-01-09",
        "Time": 218,
        // "townName": "Dalas",
        "townSize": 8,
        "latitude": 32.8,
        "Time": 287
    }, {
        "date": "2012-01-10",
        "Time": 349,
        // "townName": "Oklahoma City",
        "townSize": 5,
        "latitude": 35.49,
        "Time": 485
    }, {
        "date": "2012-01-11"
    }, {
        "date": "2012-01-12"
    }, {
        "date": "2012-01-13"
    }, {
        "date": "2012-01-14"
    }, {
        "date": "2012-01-15"
    }, {
        "date": "2012-01-16"
    }, {
        "date": "2012-01-17"
    }, {
        "date": "2012-01-18"
    }, {
        "date": "2012-01-19"
    }, {
        "date": "2012-01-20"
    }, {
        "date": "2012-01-21"
    }, {
        "date": "2012-01-22"
    }, {
        "date": "2012-01-23"
    }, {
        "date": "2012-01-24"
    }, {
        "date": "2012-01-25"
    }, {
        "date": "2012-01-26"
    }, {
        "date": "2012-01-27"
    }, {
        "date": "2012-01-28"
    }, {
        "date": "2012-01-29"
    }, {
        "date": "2012-01-30"
    }];

    // Create axes
    var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
    dateAxis.renderer.grid.template.location = 0;
    dateAxis.renderer.minGridDistance = 50;
    dateAxis.renderer.grid.template.disabled = true;
    dateAxis.renderer.fullWidthTooltip = true;

    var distanceAxis = chart.yAxes.push(new am4charts.ValueAxis());
    distanceAxis.title.text = "Time";
    distanceAxis.renderer.grid.template.disabled = true;

    var durationAxis = chart.yAxes.push(new am4charts.DurationAxis());
    durationAxis.title.text = "Time";
    durationAxis.baseUnit = "minute";
    durationAxis.renderer.grid.template.disabled = true;
    durationAxis.renderer.opposite = true;

    // durationAxis.durationFormatter.durationFormat = "hh'h' mm'min'";

    var latitudeAxis = chart.yAxes.push(new am4charts.ValueAxis());
    latitudeAxis.renderer.grid.template.disabled = true;
    latitudeAxis.renderer.labels.template.disabled = true;

    // Create series
    var distanceSeries = chart.series.push(new am4charts.ColumnSeries());
    distanceSeries.dataFields.valueY = "Time";
    distanceSeries.dataFields.dateX = "date";
    distanceSeries.yAxis = distanceAxis;
    distanceSeries.tooltipText = "{valueY} miles";
    distanceSeries.name = "Time";
    distanceSeries.columns.template.fillOpacity = 0.7;
    distanceSeries.columns.template.propertyFields.strokeDasharray = "dashLength";
    distanceSeries.columns.template.propertyFields.fillOpacity = "alpha";

    var disatnceState = distanceSeries.columns.template.states.create("hover");
    disatnceState.properties.fillOpacity = 0.9;

    var durationSeries = chart.series.push(new am4charts.LineSeries());
    durationSeries.dataFields.valueY = "Time";
    durationSeries.dataFields.dateX = "date";
    durationSeries.yAxis = durationAxis;
    durationSeries.name = "Time";
    durationSeries.strokeWidth = 2;
    durationSeries.propertyFields.strokeDasharray = "dashLength";
    durationSeries.tooltipText = "{valueY.formatDuration()}";

    var durationBullet = durationSeries.bullets.push(new am4charts.Bullet());
    var durationRectangle = durationBullet.createChild(am4core.Rectangle);
    durationBullet.horizontalCenter = "middle";
    durationBullet.verticalCenter = "middle";
    durationBullet.width = 7;
    durationBullet.height = 7;
    durationRectangle.width = 7;
    durationRectangle.height = 7;

    var durationState = durationBullet.states.create("hover");
    durationState.properties.scale = 1.2;

    var latitudeSeries = chart.series.push(new am4charts.LineSeries());
    latitudeSeries.dataFields.valueY = "latitude";
    latitudeSeries.dataFields.dateX = "date";
    latitudeSeries.yAxis = latitudeAxis;
    latitudeSeries.name = "Time";
    latitudeSeries.strokeWidth = 2;
    latitudeSeries.propertyFields.strokeDasharray = "dashLength";
    latitudeSeries.tooltipText = "Latitude: {valueY} ({townName})";

    var latitudeBullet = latitudeSeries.bullets.push(new am4charts.CircleBullet());
    latitudeBullet.circle.fill = am4core.color("#fff");
    latitudeBullet.circle.strokeWidth = 2;
    latitudeBullet.circle.propertyFields.radius = "townSize";

    var latitudeState = latitudeBullet.states.create("hover");
    latitudeState.properties.scale = 1.2;

    var latitudeLabel = latitudeSeries.bullets.push(new am4charts.LabelBullet());
    latitudeLabel.label.text = "{townName2}";
    latitudeLabel.label.horizontalCenter = "left";
    latitudeLabel.label.dx = 14;

    // Add legend
    chart.legend = new am4charts.Legend();

    // Add cursor
    chart.cursor = new am4charts.XYCursor();
    chart.cursor.fullWidthLineX = true;
    chart.cursor.xAxis = dateAxis;
    chart.cursor.lineX.strokeOpacity = 0;
    chart.cursor.lineX.fill = am4core.color("#000");
    chart.cursor.lineX.fillOpacity = 0.1;
</script>
@endsection 