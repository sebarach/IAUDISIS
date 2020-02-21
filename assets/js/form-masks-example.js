//////////////////////////////////////////////////////
//  Template Name: octAdmin
//  Author: octathemes
//  Email: octathemes@gmail.com
//  File: form-masks-example.js
///////////////////////////////////////////////////

$(function () {
    "use strict";
    // Alert Dialog

// basic masks

var formatted = new Formatter(document.getElementById('inputDate1'), {

    'pattern': '{{9999}}-{{99}}-{{99}}',
    'persistent': true
});

var formatted = new Formatter(document.getElementById('inputDate2'), {

    'pattern': '{{99}}/{{99}}/{{9999}}',
    'persistent': true
});

var formatted = new Formatter(document.getElementById('inputTime'), {

    'pattern': '{{99}}: {{99}}',
    'persistent': true
});

var formatted = new Formatter(document.getElementById('inputTimeDate'), {

    'pattern': '{{99}}: {{99}} {{99}}/{{99}}/{{9999}}',
    'persistent': true
});

var formatted = new Formatter(document.getElementById('inputCharacters'), {

    'pattern': '{{aaaaaaaaa}}',
    'persistent': true
});


// Extended masks

var formatted = new Formatter(document.getElementById('inputPhone'), {

    'pattern': '({{999}}) {{999}}-{{9999}}',
    'persistent': true
});

var formatted = new Formatter(document.getElementById('inputPhone2'), {

    'pattern': '+186 {{999}}-{{999}}-{{9999}}',
    'persistent': true
});

var formatted = new Formatter(document.getElementById('inputPhoneExt'), {

    'pattern': '({{999}}) {{999}}-{{9999}} x{{99999}}',
    'persistent': true
});

var formatted = new Formatter(document.getElementById('inputCredit'), {

    'pattern': '{{9999}}-{{9999}}-{{9999}}-{{9999}}',
    'persistent': true
});

var formatted = new Formatter(document.getElementById('inputProduct'), {

    'pattern': 'a{{*}}-{{9999}}-C{{999}}',
    'persistent': true
});

var formatted = new Formatter(document.getElementById('inputPercent'), {

    'pattern': '{{99}}.{{99}}%',
    'persistent': true
});

var formatted = new Formatter(document.getElementById('inputCurrency'), {

    'pattern': '${{999}},{{999}},{{999}}.{{99}}',
    'persistent': true
});

var formatted = new Formatter(document.getElementById('inputCurrency2'), {

    'pattern': '${{999}},{{999}},{{999}}.{{99}}',
    'persistent': true
});

});