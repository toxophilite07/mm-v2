am5.ready(function () {
    var root = am5.Root.new("status_chart");

    root.setThemes([
        am5themes_Animated.new(root)
    ]);

    var chart = root.container.children.push(am5percent.PieChart.new(root, {
        layout: root.verticalLayout,
        radius: am5.percent(70)
    }));

    var series = chart.series.push(am5percent.PieSeries.new(root, {
        valueField: "value",
        categoryField: "category",
        legendLabelText: "{category} -",
        legendValueText: "{value}",
        alignLabels: false
    }));

    series.labels.template.setAll({
        text: "{category}"
    });

    $.ajax({
        url: '../health-worker/pie-chart-data',
        type: 'GET',
        success: function (data) {
            series.data.setAll(data);

            var legend = chart.children.push(am5.Legend.new(root, {
                centerX: am5.percent(50),
                x: am5.percent(50),
                marginTop: 5,
                marginBottom: 15
            }));

            legend.markerRectangles.template.setAll({
                cornerRadiusTL: 10,
                cornerRadiusTR: 10,
                cornerRadiusBL: 10,
                cornerRadiusBR: 10
            });
            legend.data.setAll(series.dataItems);
        }
    });

    series.appear(1000, 100);

    root._logo.dispose();
});