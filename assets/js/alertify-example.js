//////////////////////////////////////////////////////
//  Template Name: octAdmin
//  Author: octathemes
//  Email: octathemes@gmail.com
//  File: alertify-examples.js
///////////////////////////////////////////////////

$(function () {
    "use strict";
    // Alert Dialog

    $('#alert').click(function () {
        alertify.alert("This is an alert Dialog");
    });

    //confirm Dialog

    $('#alert-confirm').click(function () {
        alertify.confirm("This is a Confirm Dialog", function () {
            alertify.success("You've clicked OK ");
        }, function () {
            alertify.error("You've clicked Cancel");
        });
    });

    //alert-prompt

    $('#alert-prompt').click(function () {
        alertify
            .defaultValue("Default Value")
            .prompt("This is a prompt dialog",
                function (val, ev) {

                    // The click event is in the event variable, so you can use it here.
                    ev.preventDefault();

                    // The value entered is availble in the val variable.
                    alertify.success("You've clicked OK and typed: " + val);

                },
                function (ev) {

                    // The click event is in the event variable, so you can use it here.
                    ev.preventDefault();

                    alertify.error("You've clicked Cancel");

                }
            );
    });

    //alert-custom-labels

    $('#alert-custom-labels').click(function () {
        alertify
            .okBtn("Ok")
            .cancelBtn("Cancel")
            .confirm("Confirm dialog with custom button labels", function (ev) {

                // The click event is in the
                // event variable, so you can use
                // it here.
                ev.preventDefault();
                alertify.success("You've clicked OK");

            }, function (ev) {

                // The click event is in the
                // event variable, so you can use
                // it here.
                ev.preventDefault();

                alertify.error("You've clicked Cancel");

            });
    });

    //log posistion

    $('#log-position').click(function () {
        alertify.delay(1000); // This is just to make the demo go faster.
        alertify.log("Default botoom left position");
        setTimeout(function () {
            alertify.logPosition("top left");
            alertify.log("top left");
        }, 1500);
        setTimeout(function () {
            alertify.logPosition("top right");
            alertify.log("top right");
        }, 3000);
        setTimeout(function () {
            alertify.logPosition("bottom right");
            alertify.log("bottom right");
        }, 4500);
        setTimeout(function () {
            alertify.reset(); // Puts the message back to default position.
            alertify.log("Back to default");
        }, 6000);
    });

    // standard log

    $('#log-standard').click(function () {
        alertify.log("Standard log message");
    });

    // log html

    $('#log-html').click(function () {
        var msg = "<img src='https://placehold.it/256x128'>" +
            "<h3 class='text-white'>This is HTML</h3>" +
            "<p>It's great, right?</p>";
        alertify.log(msg);
    });

    //log success

    $('#log-success').click(function () {
        alertify.success("Success log message");
    });

    //log error

    $('#log-error').click(function () {
        alertify.error("Error log message");
    });

});