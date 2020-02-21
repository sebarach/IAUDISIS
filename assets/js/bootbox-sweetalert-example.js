//////////////////////////////////////////////////////
//  Template Name: octAdmin
//  Author: octathemes
//  Email: octathemes@gmail.com
//  File: bootbox-sweetalert-examples.js
///////////////////////////////////////////////////

$(function () {
    "use strict";

//*** 
/* Bootbox */
///

$('#bootbox-alert').click(function () {
    bootbox.alert("This is the default alert!");

});

$('#bootbox-confirm').click(function () {
    bootbox.confirm("This is the default confirm!", function (result) {
        console.log('This was logged in the callback: ' + result);
    });

});

$('#bootbox-confirm-custom').click(function () {
    bootbox.confirm({
        message: "This is a confirm with custom button text and color! Do you like it?",
        buttons: {
            confirm: {
                label: 'Yes',
                className: 'btn-success'
            },
            cancel: {
                label: 'No',
                className: 'btn-danger'
            }
        },
        callback: function (result) {
            console.log('This was logged in the callback: ' + result);
        }
    });

});

$('#bootbox-confirm-icon').click(function () {
    bootbox.confirm({

        message: "Do you want to activate the Deathstar now? This cannot be undone.",

        buttons: {
            confirm: {
                label: '<i class="fa fa-check"></i> Confirm',
                className: 'btn-success'
            },
            cancel: {
                label: '<i class="fa fa-times"></i> Cancel',
                className: 'btn-danger'
            }
        },
        callback: function (result) {
            console.log('This was logged in the callback: ' + result);
        }
    });

});

$('#bootbox-prompt').click(function () {
    bootbox.prompt("This is the default prompt!", function (result) {
        console.log(result);
    });

});

$('#bootbox-custom').click(function () {
    var dialog = bootbox.dialog({
        message: '<p class="text-center">Please wait while we do something...</p>',
        closeButton: true
    });
    // do something in the background
    dialog.modal('hide');

});

$('#bootbox-custom-html').click(function () {
    var dialog = bootbox.dialog({

        message: "<p>This dialog has buttons. Each button has it's own callback function.</p>",
        buttons: {
            cancel: {
                label: "Cancel",
                className: 'btn-danger',
                callback: function () {
                    Example.show('Custom cancel clicked');
                }
            },
            noclose: {
                label: "warning",
                className: 'btn-warning',
                callback: function () {
                    Example.show('Custom button clicked');
                    return false;
                }
            },
            ok: {
                label: "Ok",
                className: 'btn-info',
                callback: function () {
                    Example.show('Custom OK clicked');
                }
            }
        }
    });
});

$('#bootbox-custom-css').click(function () {
    bootbox.alert({
        message: "This is an alert with an additional class!",
        className: 'bounceIn'
    });
});

$('#bootbox-small').click(function () {
    bootbox.alert({
        message: "This is the small alert!",
        size: 'small'
    });
});

$('#bootbox-large').click(function () {
    bootbox.alert({
        message: "This is the large alert!",
        size: 'large'
    });
});


//*** 
/* Sweetalert */
///

document.querySelector('.sweet-10').onclick = function () {
    swal({
        title: "Are you sure?",
        text: "You will not be able to recover this imaginary file!",
        type: "info",
        showCancelButton: true,
        confirmButtonClass: 'btn-primary',
        confirmButtonText: 'Primary!'
    });
    
};


document.querySelector('.sweet-11').onclick = function () {
    swal({
        title: "Are you sure?",
        text: "You will not be able to recover this imaginary file!",
        type: "info",
        showCancelButton: true,
        confirmButtonClass: 'btn-info',
        confirmButtonText: 'Info!'
    });
};

document.querySelector('.sweet-12').onclick = function () {
    swal({
        title: "Are you sure?",
        text: "You will not be able to recover this imaginary file!",
        type: "success",
        showCancelButton: true,
        confirmButtonClass: 'btn-success',
        confirmButtonText: 'Success!'
    });
};

document.querySelector('.sweet-13').onclick = function () {
    swal({
        title: "Are you sure?",
        text: "You will not be able to recover this imaginary file!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: 'btn-warning',
        confirmButtonText: 'Warning!'
    });
};

document.querySelector('.sweet-14').onclick = function () {
    swal({
        title: "Are you sure?",
        text: "You will not be able to recover this imaginary file!",
        type: "error",
        showCancelButton: true,
        confirmButtonClass: 'btn-danger',
        confirmButtonText: 'Danger!'
    });
};

document.querySelector('.sweet-1').onclick = function () {
    swal("Here's a message!");
};

document.querySelector('.sweet-2').onclick = function () {
    swal("Here's a message!", "It's pretty, isn't it?")
};

document.querySelector('.sweet-3').onclick = function () {
    swal("Good job!", "You clicked the button!", "success");
};

document.querySelector('.sweet-4').onclick = function () {
    swal({
            title: "Are you sure?",
            text: "You will not be able to recover this imaginary file!",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: 'btn-danger',
            confirmButtonText: 'Yes, delete it!',
            closeOnConfirm: false,
            //closeOnCancel: false
        },
        function () {
            swal("Deleted!", "Your imaginary file has been deleted!", "success");
        });
};


document.querySelector('.sweet-6').onclick = function () {
    swal({
        title: "Sweet!",
        text: "Here's a custom image.",
        imageUrl: '../../img/thumbs-up.jpg'
    });
};

document.querySelector('.sweet-7').onclick = function () {
    swal({
        title: "An input!",
        text: "Write something interesting:",
        type: "input",
        showCancelButton: true,
        closeOnConfirm: false,
        animation: "slide-from-top",
        inputPlaceholder: "Write something"
    }, function (inputValue) {
        if (inputValue === false) return false;
        if (inputValue === "") {
            swal.showInputError("You need to write something!");
            return false
        }
        swal("Nice!", "You wrote: " + inputValue, "success");
    });
};

});