//////////////////////////////////////////////////////
//  Template Name: octAdmin
//  Author: octathemes
//  Email: octathemes@gmail.com
//  File: aform-plugins-example.js
///////////////////////////////////////////////////

$(function () {
    "use strict";
    // select 2
    $('.select2').select2({});
    $('#my-select').multiSelect();

    //multi select

    $('#public-methods').multiSelect();
    $('#select-all').click(function () {
        $('#public-methods').multiSelect('select_all');
        return false;
    });
    $('#deselect-all').click(function () {
        $('#public-methods').multiSelect('deselect_all');
        return false;
    });

    $('#refresh').on('click', function () {
        $('#public-methods').multiSelect('refresh');
        return false;
    });
    $('#add-option').on('click', function () {
        $('#public-methods').multiSelect('addOption', {
            value: 42,
            text: 'test 42',
            index: 0
        });
        return false;
    });

    // typeahead

    var substringMatcher = function (strs) {
        return function findMatches(q, cb) {
            var matches, substringRegex;

            // an array that will be populated with substring matches
            matches = [];

            // regex used to determine if a string contains the substring `q`
            substrRegex = new RegExp(q, 'i');

            // iterate through the pool of strings and for any string that
            // contains the substring `q`, add it to the `matches` array
            $.each(strs, function (i, str) {
                if (substrRegex.test(str)) {
                    matches.push(str);
                }
            });

            cb(matches);
        };
    };

    var states = ['Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California',
        'Colorado', 'Connecticut', 'Delaware', 'Florida', 'Georgia', 'Hawaii',
        'Idaho', 'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana',
        'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota',
        'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada', 'New Hampshire',
        'New Jersey', 'New Mexico', 'New York', 'North Carolina', 'North Dakota',
        'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania', 'Rhode Island',
        'South Carolina', 'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont',
        'Virginia', 'Washington', 'West Virginia', 'Wisconsin', 'Wyoming'
    ];

    $('#the-basics .typeahead').typeahead({
        hint: true,
        highlight: true,
        minLength: 1
    }, {
        name: 'states',
        source: substringMatcher(states)
    });

    // constructs the suggestion engine bloodhund
    var states = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.whitespace,
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        // `states` is an array of state names defined in "The Basics"
        local: states
    });

    $('#bloodhound .bloodhound').typeahead({
        hint: true,
        highlight: true,
        minLength: 1
    }, {
        name: 'states',
        source: states
    });

    //prefetch

    var countries = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.whitespace,
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        // url points to a json file that contains an array of country names, see
        // https://github.com/twitter/typeahead.js/blob/gh-pages/data/countries.json
        prefetch: '../../libs/typeahead/data/countries.json'
    });

    // passing in `null` for the `options` arguments will result in the default
    // options being used
    $('#prefetch .prefetch').typeahead(null, {
        name: 'countries',
        source: countries
    });

    // default-suggestions
    var nflTeams = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('team'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        identify: function (obj) {
            return obj.team;
        },
        prefetch: '../../libs/typeahead/data/nfl.json'
    });

    function nflTeamsWithDefaults(q, sync) {
        if (q === '') {
            sync(nflTeams.get('Detroit Lions', 'Green Bay Packers', 'Chicago Bears'));
        } else {
            nflTeams.search(q, sync);
        }
    }

    $('#default-suggestions .default-suggestions').typeahead({
        minLength: 0,
        highlight: true
    }, {
        name: 'nfl-teams',
        display: 'team',
        source: nflTeamsWithDefaults
    });

    //multiple-datasets
    var nbaTeams = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('team'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: '../../libs/typeahead/data/nba.json'
    });

    var nhlTeams = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('team'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: '../../libs/typeahead/data/nhl.json'
    });

    $('#multiple-datasets .multiple-datasets').typeahead({
        highlight: true
    }, {
        name: 'nba-teams',
        display: 'team',
        source: nbaTeams,
        templates: {
            header: '<h3 class="league-name">NBA Teams</h3>'
        }
    }, {
        name: 'nhl-teams',
        display: 'team',
        source: nhlTeams,
        templates: {
            header: '<h3 class="league-name">NHL Teams</h3>'
        }
    });

    // scrollable-dropdown-menu
    $('#scrollable-dropdown-menu .scrollable-dropdown-menu').typeahead(null, {
        name: 'countries',
        limit: 10,
        source: countries
    });


    // input maxlength
    $('input.maxlength-input').maxlength({

        alwaysShow: true,
        threshold: 10,
        warningClass: "badge badge-boxed badge-warning",
        limitReachedClass: "badge badge-boxed badge-danger",

    });

    //maxlength-textarea
    $('textarea.maxlength-textarea').maxlength({

        alwaysShow: true,
        threshold: 10,
        warningClass: "badge badge-boxed badge-warning",
        limitReachedClass: "badge badge-boxed badge-danger",

    });

    //    touchspin
    $("input[name='demo1']").TouchSpin({
        min: 0,
        max: 100,
        step: 0.1,
        decimals: 2,
        boostat: 5,
        maxboostedstep: 10,
        postfix: '%'
    });

    $("input[name='demo2']").TouchSpin({
        min: -1000000000,
        max: 1000000000,
        stepinterval: 50,
        maxboostedstep: 10000000,
        prefix: '$'
    });

    $("input[name='demo_vertical']").TouchSpin({
        verticalbuttons: true,
        verticalupclass: 'mdi mdi-chevron-up',
        verticaldownclass: 'mdi mdi-chevron-down'
    });

    $("input[name='demo_vertical2']").TouchSpin({
        verticalbuttons: true,
        verticalupclass: 'mdi mdi-plus-circle',
        verticaldownclass: 'mdi mdi-minus-circle'
    });

    // clockpicker

    $('.clockpicker').clockpicker({
        placement: 'bottom',
        align: 'left',
        donetext: 'Done'
    });

    // timepicker

    $('#basicExample').timepicker();

    $('#durationExample').timepicker({
        'minTime': '2:00pm',
        'maxTime': '11:30pm',
        'showDuration': true
    });

    $('#setTimeExample').timepicker();
    $('#setTimeButton').on('click', function () {
        $('#setTimeExample').timepicker('setTime', new Date());
    });


    // datepicker

    $('.datepicker').datepicker({
        format: 'mm/dd/yyyy',
        startDate: '-3d'
    });

    $('.input-daterange').datepicker({
        format: 'mm/dd/yyyy',
        startDate: '-3d'
    });

    inlineDatepicker
    $('#inlineDatepicker').datepicker({
        todayHighlight: true
    });

    // slider-range
    var one = $(".range-example-1").asRange({
        range: true,
        limit: true,
        tip: {
            active: 'onMove'
        }
    });
    console.log(one.asRange('set', [0, 20]));

    $(".range-example-2").asRange({
        step: 0.1,
        range: false,
        min: 0,
        max: 10,
        value: 7
    });

    $(".range-example-input-1").asRange({
        range: true,
        limit: false,

    });

    //jquery-strength
    $(".password-input").strength();
    $(".password-input-image").strength({
        templates: {
            toggle: '<span class="input-group-addon"><img class="{toggleClass}" title="Show/Hide Password" src="images/checkbox.png" /></span>'
        }
    });

    //jquery-knob
    //$(".knob").knob();

    $(function ($) {

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

    // labelauty
   
    $(".to-labelauty").labelauty();
    $(".to-labelauty-icon").labelauty({
        label: false
    });

});