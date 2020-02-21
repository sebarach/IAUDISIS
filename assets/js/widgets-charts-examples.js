//////////////////////////////////////////////////////
//  Template Name: octAdmin
//  Author: octathemes
//  Email: octathemes@gmail.com
//  File: widgets-charts-examples.js
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
        ctx.shadowColor = '#678898';
        ctx.shadowBlur = 20;
        ctx.shadowOffsetX = 0;
        ctx.shadowOffsetY = 15;
        _stroke.apply(this, arguments);
        ctx.restore();
    }
};



let ctx_primary = document.querySelector("#canvas-primary").getContext('2d');
let myChart_primary = new Chart(ctx_primary, {
    type: 'line',
    data: {
        labels: ["January", "February", "March", "April", "May", "June", "July", "August"],
        datasets: [{
            data: [10, 60, 20, 82, 30, 55, 20, 45],
            borderColor: '#0358D0',
            pointHoverBackgroundColor: "#07C",
            pointHoverBorderColor: "#FFF",
            pointHoverRadius: 10,
            fill: false,
       

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
                    beginAtZero: true
                }
            }],

            xAxes: [{
                display: false,
                ticks: {

                    beginAtZero: true
                },
                gridLines: {
                    display: false
                }
            }]
        }
    }
});



let ctx_success = document.querySelector("#canvas-success").getContext('2d');
let myChart_success = new Chart(ctx_success, {
    type: 'line',
    data: {
        labels: ["January", "February", "March", "April", "May", "June", "July", "August"],
        datasets: [{
            data: [10, 60, 20, 82, 30, 55, 20, 45],
            borderColor: '#10c469',

            pointHoverBackgroundColor: "#07C",
            pointHoverBorderColor: "#FFF",

            pointHoverRadius: 10,

            fill: false,
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

                display: false,

                ticks: {
                    max: 90,
                    beginAtZero: true
                }
            }],

            xAxes: [{
                display: false,
                ticks: {

                    beginAtZero: true
                },
                gridLines: {
                    display: false
                }
            }]
        }
    }
});



let ctx_danger = document.querySelector("#canvas-danger").getContext('2d');
let myChart_danger = new Chart(ctx_danger, {
    type: 'line',
    data: {
        labels: ["January", "February", "March", "April", "May", "June", "July", "August"],
        datasets: [{
            data: [10, 60, 20, 82, 30, 55, 20, 45],
            borderColor: '#EF5350',

            pointHoverBackgroundColor: "#07C",
            pointHoverBorderColor: "#FFF",

            pointHoverRadius: 10,

            fill: false,
           // tension: 0

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
                    beginAtZero: true
                }
            }],

            xAxes: [{
                display: false,
                ticks: {

                    beginAtZero: true
                },
                gridLines: {
                    display: false
                }
            }]
        }
    }
});

let ctx_warning = document.querySelector("#canvas-warning").getContext('2d');
let myChart_warning = new Chart(ctx_warning, {
    type: 'line',
    data: {
        labels: ["January", "February", "March", "April", "May", "June", "July", "August"],
        datasets: [{
            data: [10, 60, 20, 82, 30, 55, 20, 45],
            borderColor: '#ffc107',

            pointHoverBackgroundColor: "#07C",
            pointHoverBorderColor: "#FFF",

            pointHoverRadius: 10,

            fill: false,
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

                display: false,

                ticks: {
                    max: 90,
                    beginAtZero: true
                }
            }],

            xAxes: [{
                display: false,
                ticks: {

                    beginAtZero: true
                },
                gridLines: {
                    display: false
                }
            }]
        }
    }
});





// projects-charts-widget
let ctx_project_chart_info = document.querySelector("#project-chart-info").getContext('2d');
let myChart_project_chart_info = new Chart(ctx_project_chart_info, {
    type: 'line',
    data: {
        labels: ["January", "February","April", "May", "June", "July", "August"],
        datasets: [{
            data: [20,10,45,43,60,30,50],
            borderColor: '#1BC9E4',
            pointHoverBackgroundColor: "#07C",
            pointHoverBorderColor: "#FFF",
            pointHoverRadius: 10,
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
            displayColors: true,
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
                    beginAtZero: true
                }
            }],

            xAxes: [{
                display: true,
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

let ctx_project_chart_danger= document.querySelector("#project-chart-danger").getContext('2d');
let myChart_project_chart_danger = new Chart(ctx_project_chart_danger, {
    type: 'line',
    data: {
        labels: ["January", "February","April", "May", "June", "July", "August"],
        datasets: [{
            data: [20,50,45,30,60,30,50],
            borderColor: '#F03434',
             fill: false,
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
                    beginAtZero: true
                }
            }],

            xAxes: [{
                display: false,
                ticks: {

                    beginAtZero: true
                },
                gridLines: {
                    display: false
                }
            }]
        }
    }
});

let ctx_project_chart_success= document.querySelector("#project-chart-success").getContext('2d');
let myChart_project_chart_success = new Chart(ctx_project_chart_success, {
    type: 'line',
    data: {
        labels: ["January", "February","April", "May", "June", "July", "August"],
        datasets: [{
            data: [20,50,20,30,60,30,50],
            borderColor: '#37BC9B',
             fill: false,
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
                    beginAtZero: true
                }
            }],

            xAxes: [{
                display: false,
                ticks: {

                    beginAtZero: true
                },
                gridLines: {
                    display: false
                }
            }]
        }
    }
});

let ctx_project_chart_primary= document.querySelector("#project-chart-primary").getContext('2d');
let myChart_project_chart_primary = new Chart(ctx_project_chart_primary, {
    type: 'line',
    data: {
        labels: ["January", "February","April", "May", "June", "July", "August"],
        datasets: [{
            data: [20,30,60,40,60,30,50],
            borderColor: '#0358C7',
             fill: false,
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
                    beginAtZero: true
                }
            }],

            xAxes: [{
                display: false,
                ticks: {

                    beginAtZero: true
                },
                gridLines: {
                    display: false
                }
            }]
        }
    }
});

// sales bar chart


    //some data
    var d1 = [];
    for (var i = 0; i <= 4; i += 1)
    d1.push([i, parseInt(Math.random() * 60)]);
    
    var d2 = [];
    for (var i = 0; i <= 4; i += 1)
    d2.push([i, parseInt(Math.random() * 40)]);
    
    var d3 = [];
    for (var i = 0; i <= 4; i += 1)
    d3.push([i, parseInt(Math.random() * 25)]);
    
    var ds = new Array();
    
    ds.push({
    label : "Data One",
    data : d1,
    bars : {
        order : 1
    }
    });
    ds.push({
    label : "Data Two",
    data : d2,
    bars : {
        order : 2
    }
    });
    ds.push({
    label : "Data Three",
    data : d3,
    bars : {
        order : 3
    }
    });
    
    var stack = 0,
    bars = true,
    lines = true,
    steps = true;
    
    var options = {
    bars : {
        show : true,
        barWidth : 0.2,
        fill : 1
    },
    grid : {
        show : true,
        aboveData : false,
        labelMargin : 20,
        axisMargin : 0,
        borderWidth : 1,
        minBorderMargin : 5,
        clickable : true,
        hoverable : true,
        autoHighlight : false,
        mouseActiveRadius : 20,
        borderColor : '#f5f5f5'
    },
    series : {
        stack : stack
    },
    legend : {
        show:false,
        position : "sw",
        margin : [0, -80],
        noColumns : 0,
        labelBoxBorderColor : null,
        labelFormatter : function(label, series) {
            // just add some space to labes
            return '' + label + '&nbsp;&nbsp;';
        },
        width : 20,
        height : 5
    },
    yaxis : {
        tickColor : '#f5f5f5',
        font : {
            color : '#bdbdbd'
        }
    },
    xaxis : {
        tickColor : '#f5f5f5',
        font : {
            color : '#bdbdbd'
        }
    },
    colors : ["#1875F0", "#74ACF6", "#B0CFF7"],
    tooltip : true, //activate tooltip
    tooltipOpts : {
        content : "%s : %y.0",
        shifts : {
            x : 30,
            y : 50
        }
    }
    };
    
    $.plot($(".sales-bars-chart"), ds, options);
  
    

    // Payments Area chart
Morris.Area({
    element: 'extra-area-chart',
    data: [{
                period: '2010',
                iphone: 0,
                ipad: 0,
               
            }, {
                period: '2011',
                iphone: 40,
                ipad: 30,
               
            }, {
                period: '2012',
                iphone: 35,
                ipad: 25,
                
            }, {
                period: '2013',
                iphone: 50,
                ipad: 40,
                
            }, {
                period: '2014',
                iphone: 40,
                ipad: 30,
                
            }, {
                period: '2015',
                iphone: 60,
                ipad: 50,
                
            }, {
                period: '2016',
                iphone: 50,
                ipad: 40,
               
            }


            ],
            lineColors: ['#74ACF6', '#0358C7'],
            xkey: 'period',
            ykeys: ['iphone', 'ipad'],
            labels: ['Site A', 'Site B'],
            pointSize: 0,
            lineWidth: 0,
            resize:true,
            fillOpacity: 1,
            behaveLikeLine: true,
            gridLineColor: '#e0e0e0',
            hideHover: 'auto'
    
});

Morris.Area({
    element: 'morris-area-chart',
    data: [{
        period: '2010',
        iphone: 50,
        ipad: 80,
        itouch: 20
    }, {
        period: '2011',
        iphone: 130,
        ipad: 100,
        itouch: 80
    }, {
        period: '2012',
        iphone: 80,
        ipad: 60,
        itouch: 70
    }, {
        period: '2013',
        iphone: 70,
        ipad: 200,
        itouch: 140
    }, {
        period: '2014',
        iphone: 180,
        ipad: 150,
        itouch: 140
    }, {
        period: '2015',
        iphone: 105,
        ipad: 100,
        itouch: 80
    },
     {
        period: '2016',
        iphone: 250,
        ipad: 150,
        itouch: 200
    }],
    xkey: 'period',
    ykeys: ['iphone', 'ipad'],
    labels: ['iPhone', 'iPad'],
    pointSize: 0,
    fillOpacity: 0,
    pointStrokeColors:['#00bfc7', '#fdc006'],
    behaveLikeLine: true,
    gridLineColor: '#e0e0e0',
    lineWidth: 4,
    hideHover: 'auto',
    lineColors: ['#0F6BE3', '#F03434'],
    resize: true
    
});


$("span.donut").peity("donut", {
    width: 80,
    height: 80
});

var ctx = document.getElementById("chart3").getContext('2d');
var myChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ["M", "T", "W", "T"],
        datasets: [{
            backgroundColor: [
                "#0358C7",
                "#1BC9E4",
                "#37BC9B",
                "#673ab7"
            ],
            borderColor: [
                "#0358C7",
                "#1BC9E4",
                "#37BC9B",
                "#673ab7"

            ],

            data: [38, 16, 10, 40]
        }]
    },
    options: {
        legend: {
            display: false
        }
    }
});

});