//////////////////////////////////////////////////////
//  Template Name: octAdmin
//  Author: octathemes
//  Email: octathemes@gmail.com
//  File: dashboard-ecom-widget.js
///////////////////////////////////////////////////


$(function () {
    "use strict";

    let draw = Chart.controllers.line.prototype.draw;
    Chart.controllers.line.prototype.draw = function () {
        draw.apply(this, arguments);
        let ctx = this.chart.chart.ctx;
        let _stroke = ctx.stroke;
        ctx.stroke = function () {
            ctx.save();
            ctx.shadowColor = '#000';
            ctx.shadowBlur = 20;
            ctx.shadowOffsetX = 0;
            ctx.shadowOffsetY = 15;
            _stroke.apply(this, arguments);
            ctx.restore();
        }
    };

    var data = [
        { y: '2014', a: 0, b: 0},
        { y: '2015', a: 90,  b: 75},
        { y: '2016', a: 50,  b: 50},
        { y: '2017', a: 75,  b: 60},
        { y: '2018', a: 80,  b: 65},
        { y: '2019', a: 190,  b: 170},
        { y: '2020', a: 100, b: 115},
        { y: '2021', a: 170, b: 125},
        { y: '2022', a: 120, b: 85},
        { y: '2023', a: 90, b: 85},
        { y: '2024', a: 110, b: 95}
      ],
      config = {
        data: data,
        xkey: 'y',
        ykeys: ['a', 'b'],
        labels: ['Total Income', 'Total Outcome'],
        fillOpacity: 0.9,
        hideHover: 'auto',
        behaveLikeLine: true,
        resize: true,
        gridLineColor: '#f0f3f5',
        //pointFillColors:['#ffffff'],
        lineColors:['#1BC9E4','#0358C7']
    };
  config.element = 'area-chart';
  Morris.Area(config);

    let ctx_white = document.querySelector("#canvas-full-chart-light").getContext('2d');
    let myChart_white = new Chart(ctx_white, {
        type: 'line',
        data: {
            labels: ["Aug", "Sep", "Oct", "Nov", "Dec", "Jan", "Feb", "Dec", "Jan", "Feb"],
            datasets: [{
                data: [40, 30, 80, 45, 80, 40, 60, 40, 60, 40],
                borderColor: '#fff',
                fillColor: "#79D1CF",
                backgroundColor: "rgba(0, 0, 0, 0.2)",
                pointBackgroundColor: "#FFF",
                //pointBorderColor: "#07C",
                pointHoverBackgroundColor: "#07C",
                pointHoverBorderColor: "#FFF",
                //pointRadius: 5,
                pointHoverRadius: 10,
                // pointBorderWidth: 0,
                fill: true,

                //tension: 0

            }]
        },
        options: {
            elements: {
                point: {

                    radius: 0
                }
            },

            responsive: true,
            tooltips: {
                displayColors: false,
                callbacks: {
                    label: function (e, d) {
                        return `${e.xLabel} : ${e.yLabel}`
                    },
                    title: function () {
                        return;
                    }
                }
            },
            legend: {
                display: false
            },
            scales: {
                yAxes: [{

                    display: true,

                    ticks: {
                        max: 90,
                        beginAtZero: true,
                        fontColor: 'white',
                        display: false,
                    },

                    gridLines: {
                        display: true
                    }


                }],

                xAxes: [{
                    display: false,
                    ticks: {

                        beginAtZero: true
                    },
                    gridLines: {
                        display: true
                    }
                }]
            }
        }
    });

    var ctx = document.getElementById('chart1').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['M', 'T', 'W', 'T', 'F', 'S', 'S'],
            datasets: [{
                label: 'apples',
                data: [100, 19, 3, 17, 6, 40, 7],
                backgroundColor: "#1976D2"
            }, {
                label: 'oranges',
                data: [2, 29, 5, 60, 2, 3, 10],
                //backgroundColor: "#1976D2"
            }]
        },

        options: {
            elements: {
                point: {

                    radius: 0
                }
            },

            responsive: true,
            tooltips: {
                displayColors: false,
                callbacks: {
                    label: function (e, d) {
                        return `${e.xLabel} : ${e.yLabel}`
                    },
                    title: function () {
                        return;
                    }
                }
            },
            legend: {
                display: false
            },
            scales: {
                yAxes: [{

                    display: false,

                    ticks: {
                        max: 90,
                        beginAtZero: true,
                        fontColor: 'white',
                        display: false,
                    },

                    gridLines: {
                        display: true
                    }


                }],

                xAxes: [{
                    display: false,
                    ticks: {

                        beginAtZero: true
                    },
                    gridLines: {
                        display: true
                    }
                }]
            }
        }
    });

});


$(function ($) {
    "use strict";

    $(".knob").knob({
        change: function (value) {
            //console.log("change : " + value);
        },
        release: function (value) {
            //console.log(this.$.attr('value'));
            console.log("release : " + value);
        },
        cancel: function () {
            console.log("cancel : ", this);
        },
        /*format : function (value) {
            return value + '%';
        },*/
        draw: function () {

            // "tron" case
            if (this.$.data('skin') == 'tron') {

                this.cursorExt = 0.3;

                var a = this.arc(this.cv) // Arc
                    ,
                    pa // Previous arc
                    , r = 1;

                this.g.lineWidth = this.lineWidth;

                if (this.o.displayPrevious) {
                    pa = this.arc(this.v);
                    this.g.beginPath();
                    this.g.strokeStyle = this.pColor;
                    this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, pa.s, pa.e, pa.d);
                    this.g.stroke();
                }

                this.g.beginPath();
                this.g.strokeStyle = r ? this.o.fgColor : this.fgColor;
                this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, a.s, a.e, a.d);
                this.g.stroke();

                this.g.lineWidth = 2;
                this.g.beginPath();
                this.g.strokeStyle = this.o.fgColor;
                this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false);
                this.g.stroke();

                return false;
            }
        }
    });

    // Example of infinite knob, iPod click wheel
    var v, up = 0,
        down = 0,
        i = 0,
        $idir = $("div.idir"),
        $ival = $("div.ival"),
        incr = function () {
            i++;
            $idir.show().html("+").fadeOut();
            $ival.html(i);
        },
        decr = function () {
            i--;
            $idir.show().html("-").fadeOut();
            $ival.html(i);
        };
    $("input.infinite").knob({
        min: 0,
        max: 20,
        stopper: false,
        change: function () {
            if (v > this.cv) {
                if (up) {
                    decr();
                    up = 0;
                } else {
                    up = 1;
                    down = 0;
                }
            } else {
                if (v < this.cv) {
                    if (down) {
                        incr();
                        down = 0;
                    } else {
                        down = 1;
                        up = 0;
                    }
                }
            }
            v = this.cv;
        }
    });
});