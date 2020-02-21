//////////////////////////////////////////////////////
//  Template Name: octAdmin
//  Author: octathemes
//  Email: octathemes@gmail.com
//  File: dashboard-pm-examples.js
///////////////////////////////////////////////////

$(function () {
    "use strict";
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
    
  Morris.Donut({
    element: 'pie-chart',
    data: [
      {label: "Return Visitors", value: 60, color:"#1BC9E4"},
      {label: "New Visitors", value: 40, color:"#0358C7"}
     
    ]
  });


  jQuery('#world-map-markers').vectorMap({
    map: 'world_mill_en',
    backgroundColor: 'transparent',
    borderColor: '#818181',
    borderOpacity: 0.25,
    borderWidth: 1,
    zoomOnScroll: false,
    color: '#009efb',
    regionStyle: {
        initial: {
            fill: '#ffffff'
        }
    },
    markerStyle: {
        initial: {
            r: 9,
            'fill': '#fff',
            'fill-opacity': 1,
            'stroke': '#000',
            'stroke-width': 5,
            'stroke-opacity': 0.4
        },
    },
    enableZoom: true,
    hoverColor: '#009efb',
    markers: [
        {
        latLng: [61.00, 78.00],
        name: '300'
        }
],
    hoverOpacity: null,
    normalizeFunction: 'linear',
    scaleColors: ['#b6d6ff', '#005ace'],
    selectedColor: '#c9dfaf',
    selectedRegions: [],
    showTooltip: true,
    onRegionClick: function (element, code, region) {
        var message = 'You clicked "' +
            region +
            '" which has the code: ' +
            code.toUpperCase();

        alert(message);
    }
});

});
