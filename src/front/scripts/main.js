jQuery(function onDocumentReady() {
    'use strict';
    $('.chart').each(function () {
        var chart = new Highcharts.StockChart({
            chart: {
                renderTo: $(this).prop('id')
            },
            navigator: {
                height: 30
            },

            rangeSelector : {
                selected : 1,
                inputEnabled: $(this).width() > 480
            },

            title : {
                text : $(this).data('index'),
                useHtml: true
            },

            xAxis: {
                maxZoom: 14 * 24 * 3600000 // fourteen days
            },

            series: [
                {
                    name: $(this).data('index'),
                    data: $.map($(this).data('values'), function (val, key) {
                        return [
                            [val.timestamp*1000, val.value]
                        ]
                    }),
                    tooltip: {
                        yDecimals: 4
                    }
                }
            ]
        });
    });
});
