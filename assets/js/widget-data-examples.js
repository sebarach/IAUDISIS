//////////////////////////////////////////////////////
//  Template Name: octAdmin
//  Author: octathemes
//  Email: octathemes@gmail.com
//  File: widget-data-examples.js
///////////////////////////////////////////////////



$(function () { 
    "use strict";

    /* Todo app */
    //click off any todos
    $("ul").on("click", "li", function () { //on click on li
        $(this).toggleClass("completed");
    });

    //delete todos by clicking on X
    $("ul").on("click", "span", function () {
        //console.log("You pressed the X button");
        $(this).parent().fadeOut(500, function () {
            $(this).addClass("completed").remove();
        });
        event.stopPropagation();
    });
    //add todo on enter
    $("input[type='text']").keypress(function (event) { //event variable captures the key pressed
        if (event.which === 13) { // 13 is the virtual keycode of "enter"
            //grabbing new todo text from input
            var todoText = $(this).val();
            //create new li and add to ul
            $('ul').append("<li><span><i class='fa fa-trash'></i></span> " + todoText +
                " </li>");
            $(this).val(null);
        }
    });
    $(".fa-pencil-square-o").click(function () {
        $("input[type='text']").fadeToggle();
    });


    // scroll bars

    $("#scrollList").niceScroll({
        cursorcolor: "#AEC6D2",
        //cursorborder:"1px solid #F3F7F9"
    });

    $("#messageList").niceScroll({
        cursorcolor: "#AEC6D2",
        //cursorborder:"1px solid #F3F7F9"
    });
    $("#salesList").niceScroll({
        cursorcolor: "#AEC6D2",
        //cursorborder:"1px solid #F3F7F9"
    });
    $("#orderList").niceScroll({
        cursorcolor: "#AEC6D2",
        //cursorborder:"1px solid #F3F7F9"
    });

    $("#chatList").niceScroll({
        cursorcolor: "#AEC6D2",
        //cursorborder:"1px solid #F3F7F9"
    });

    $("#feedList").niceScroll({
        cursorcolor: "#AEC6D2",
        //cursorborder:"1px solid #F3F7F9"
    });

    // sales list chart
    $(".peityBar").peity("bar", {
        width: '50px',
        height: '30px'
    });

});