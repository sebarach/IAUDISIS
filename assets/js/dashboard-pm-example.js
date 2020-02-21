//////////////////////////////////////////////////////
//  Template Name: octAdmin
//  Author: octathemes
//  Email: octathemes@gmail.com
//  File: dashboard-pm-examples.js
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


let ctx_earning_chart_success= document.querySelector("#earning-chart-success").getContext('2d');
let myChart_earning_chart_success = new Chart(ctx_earning_chart_success, {
    type: 'line',
    data: {
        labels: ["January", "February","April", "May", "June", "July", "August"],
        datasets: [{
            data: [20,50,20,30,10,50,50],
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
                    max: 70,
                    beginAtZero: true
                }
            }],

            xAxes: [{
                display: true,
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

$("#messageList").niceScroll({
    cursorcolor: "#AEC6D2",
});

});