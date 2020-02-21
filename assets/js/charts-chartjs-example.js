//////////////////////////////////////////////////////
//  Template Name: octAdmin
//  Author: octathemes
//  Email: octathemes@gmail.com
//  File: chart-chartjs-example-example.js
///////////////////////////////////////////////////

$(function () {
  "use strict";
  
  var ctx = document.getElementById('chart1').getContext('2d');
  var myChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: ['M', 'T', 'W', 'T', 'F', 'S', 'S'],
      datasets: [{
        label: 'apples',
        data: [12, 19, 3, 17, 6, 3, 7],
        backgroundColor: "#1976D2"
      }, {
        label: 'oranges',
        data: [2, 29, 5, 5, 2, 3, 10],
        //backgroundColor: "#1976D2"
      }]
    }
  });

  var ctx = document.getElementById("chart2").getContext('2d');
  var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ["M", "T", "W", "R", "F", "S", "S"],
      datasets: [{
        label: 'apples',
        data: [12, 19, 3, 17, 28, 24, 7],
        //backgroundColor: "#FF5252"
      }, {
        label: 'oranges',
        data: [30, 29, 5, 5, 20, 3, 10],
        backgroundColor: "#1976D2"
      }]
    }
  });

  var ctx = document.getElementById("chart3").getContext('2d');
  var myChart = new Chart(ctx, {
    type: 'pie',
    data: {
      labels: ["M", "T", "W", "T", "F", "S", "S"],
      datasets: [{
        backgroundColor: [
          "#2ecc71",
          "#3498db",
          "#95a5a6",
          "#9b59b6",
          "#f1c40f",
          "#e74c3c",
          "#34495e"
        ],
        data: [12, 19, 3, 17, 28, 24, 7]
      }]
    }
  });



  var ctx = document.getElementById("chart4").getContext('2d');
  var myChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: ["M", "T", "W", "T", "F", "S", "S"],
      datasets: [{
        backgroundColor: [
          "#2ecc71",
          "#3498db",
          "#95a5a6",
          "#9b59b6",
          "#f1c40f",
          "#e74c3c",
          "#34495e"
        ],
        data: [12, 19, 3, 17, 28, 24, 7]
      }]
    }
  });

  var ctx = document.getElementById("chart5").getContext('2d');
  var myChart = new Chart(ctx, {
    type: 'polarArea',
    data: {
      labels: ["M", "T", "W", "T", "F", "S", "S"],
      datasets: [{
        backgroundColor: [
          "#2ecc71",
          "#3498db",
          "#95a5a6",
          "#9b59b6",
          "#f1c40f",
          "#e74c3c",
          "#34495e"
        ],
        data: [12, 19, 3, 17, 28, 24, 7]
      }]
    }
  });

  var ctx = document.getElementById("chart6");
  var myChart = new Chart(ctx, {
    type: 'radar',
    data: {
      labels: ["M", "T", "W", "T", "F", "S", "S"],
      datasets: [{
        label: 'apples',
        backgroundColor: "#1976D2",
        //borderColor: "rgba(153,255,51,1)",
        data: [12, 19, 3, 17, 28, 24, 7]
      }, {
        label: 'oranges',
        // backgroundColor: "rgba(255,153,0,0.4)",
        // borderColor: "rgba(255,153,0,1)",
        data: [30, 29, 5, 5, 20, 3, 10]
      }]
    }
  });

});