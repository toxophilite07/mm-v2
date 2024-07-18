am5.ready(function () {
    var root = am5.Root.new("yearly_period");

    root.setThemes([
        am5themes_Animated.new(root)
    ]);

    var chart = root.container.children.push(am5xy.XYChart.new(root, {}));

    var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
        cursor.lineY.set("visible", false);

    var xRenderer = am5xy.AxisRendererX.new(root, {
        minGridDistance: 15
    });

    xRenderer.labels.template.setAll({
        rotation: -90,
        centerY: am5.p50,
        centerX: 0
    });

    xRenderer.grid.template.setAll({
        visible: false
    });

    var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
        maxDeviation: 0.3,
        categoryField: "month",
        renderer: xRenderer,
        tooltip: am5.Tooltip.new(root, {})
    }));

    var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
        maxDeviation: 0.3,
        renderer: am5xy.AxisRendererY.new(root, {})
    }));


    var series = chart.series.push(am5xy.ColumnSeries.new(root, {
        xAxis: xAxis,
        yAxis: yAxis,
        valueYField: "count",
        categoryXField: "month",
        adjustBulletPosition: false,
        tooltip: am5.Tooltip.new(root, {
            labelText: "{valueY}"
        })
    }));
    series.columns.template.setAll({
        width: 0.5
    });

    series.bullets.push(function () {
        return am5.Bullet.new(root, {
            locationY: 1,
            sprite: am5.Circle.new(root, {
                radius: 5,
                fill: series.get("fill")
            })
        })
    })

    $.ajax({
        url: '../admin/graph-data',
        type: 'GET',
        success: function (data) {
            xAxis.data.setAll(data);
            series.data.setAll(data);

        }
    });

    series.appear(1000);
    chart.appear(1000, 100);

    root._logo.dispose();
});