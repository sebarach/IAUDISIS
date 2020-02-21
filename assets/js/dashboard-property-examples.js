//////////////////////////////////////////////////////
//  Template Name: octAdmin
//  Author: octathemes
//  Email: octathemes@gmail.com
//  File: dashboard-property-examples.js
///////////////////////////////////////////////////


$(function () {
    "use strict";

    // market perfomance Area chart
    Morris.Area({
        element: 'market-perfomance-area-chart',
        data: [{
                period: '1',
                lead: 0,
                view: 0,

            }, {
                period: '2',
                lead: 40,
                view: 30,

            }, {
                period: '3',
                lead: 35,
                view: 25,

            }, {
                period: '4',
                lead: 50,
                view: 40,

            }, {
                period: '5',
                lead: 40,
                view: 30,

            }, {
                period: '6',
                lead: 60,
                view: 50,

            }, {
                period: '7',
                lead: 50,
                view: 40,

            }


        ],
        //lineColors: ['#e91e63', '#471E81'],
        lineColors: ['#74ACF6', '#0358C7'],
        xkey: 'period',
        ykeys: ['lead', 'view'],
        labels: ['Site A', 'Site B'],
        pointSize: 0,
        lineWidth: 0,
        resize: true,
        fillOpacity: 1,
        behaveLikeLine: true,
        gridLineColor: '#e0e0e0',
        hideHover: 'auto'

    });

});
// sales bar chart

$(function () {
    "use strict";
    //some data
    var d1 = [];
    for (var i = 0; i <= 26; i += 1)
        d1.push([i, parseInt(Math.random() * 60)]);

    var d2 = [];
    for (var i = 0; i <= 26; i += 1)
        d2.push([i, parseInt(Math.random() * 40)]);

    var d3 = [];
    for (var i = 0; i <= 26; i += 1)
        d3.push([i, parseInt(Math.random() * 25)]);

    var ds = new Array();

    ds.push({
        label: "Data One",
        data: d1,
        bars: {
            order: 1
        }
    });
    ds.push({
        label: "Data Two",
        data: d2,
        bars: {
            order: 2
        }
    });
    ds.push({
        label: "Data Three",
        data: d3,
        bars: {
            order: 3
        }
    });


    var stack = 0,
        bars = true,
        lines = true,
        steps = true;

    var options = {
        bars: {
            show: true,
            barWidth: 0.2,
            fill: 1
        },
        grid: {
            show: true,
            aboveData: false,
            labelMargin: 20,
            axisMargin: 0,
            borderWidth: 1,
            minBorderMargin: 5,
            clickable: true,
            hoverable: true,
            autoHighlight: false,
            mouseActiveRadius: 20,
            borderColor: '#f5f5f5'
        },
        series: {
            stack: stack
        },
        legend: {
            show: false,
            position: "sw",
            margin: [0, -80],
            noColumns: 0,
            labelBoxBorderColor: null,
            labelFormatter: function (label, series) {
                // just add some space to labes
                return '' + label + '&nbsp;&nbsp;';
            },
            width: 20,
            height: 5
        },
        yaxis: {
            tickColor: '#f5f5f5',
            font: {
                color: '#bdbdbd'
            }
        },
        xaxis: {
            tickColor: '#f5f5f5',
            font: {
                color: '#bdbdbd'
            }
        },
        colors: ["#1875F0", "#74ACF6", "#B0CFF7"],
        tooltip: true, //activate tooltip
        tooltipOpts: {
            content: "%s : %y.0",
            shifts: {
                x: 30,
                y: 50
            }
        }
    };

    $.plot($(".sales-bars-chart"), ds, options);
});