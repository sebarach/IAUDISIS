//////////////////////////////////////////////////////
//  Template Name: octAdmin
//  Author: octathemes
//  Email: octathemes@gmail.com
//  File: app.js
///////////////////////////////////////////////////

/*****
 * CONFIGURATION
 */
//Main navigation
$.navigation = $('nav > ul.nav');

'use strict';

/****
 * MAIN NAVIGATION
 */

$(document).ready(function ($) {
  // .sidebar-menu scroller
  $("#sidebar-nav-scroller").niceScroll({
    cursorwidth: '5px',
    cursorcolor: "#AEC6D2",
    autohidemode: true,
    zindex: 999
  });

  // Add class .active to current link
  $.navigation.find('a').each(function () {

    var cUrl = String(window.location).split('?')[0];

    if (cUrl.substr(cUrl.length - 1) == '#') {
      cUrl = cUrl.slice(0, -1);
    }

    if ($($(this))[0].href == cUrl) {
      $(this).addClass('active');

      $(this).parents('ul').add(this).each(function () {
        $(this).parent().addClass('open');
      });
    }
  });

  // Dropdown Menu
  $.navigation.on('click', 'a', function (e) {

    if ($.ajaxLoad) {
      e.preventDefault();
    }

    if ($(this).hasClass('nav-dropdown-toggle')) {
      $(this).parent().toggleClass('open');
      resizeBroadcast();
    }

  });

  function resizeBroadcast() {

    var timesRun = 0;
    var interval = setInterval(function () {
      timesRun += 1;
      if (timesRun === 5) {
        clearInterval(interval);
      }
      window.dispatchEvent(new Event('resize'));
    }, 62.5);
  }

  /* ---------- Main Menu Open/Close, Min/Full ---------- */

  var forEach = function (t, o, r) {
    if ("[object Object]" === Object.prototype.toString.call(t))
      for (var c in t) Object.prototype.hasOwnProperty.call(t, c) && o.call(r, t[c], c, t);
    else
      for (var e = 0, l = t.length; l > e; e++) o.call(r, t[e], e, t)
  };

  var hamburgers = document.querySelectorAll(".hamburger");
  if (hamburgers.length > 0) {
    forEach(hamburgers, function (hamburger) {
      hamburger.addEventListener("click", function () {
        this.classList.toggle("is-active");
      }, false);
    });
  }

  $('.sidebar-toggler').click(function () {
    $('body').toggleClass('sidebar-hidden');
    resizeBroadcast();
  });

  $('.mailbox-sidebar-toggler').click(function () {
    $('body').toggleClass('mailbox-sidebar-hidden');
    resizeBroadcast();
  });

  $('.calendar-sidebar-toggler').click(function () {
    $('body').toggleClass('calendar-sidebar-hidden');
    resizeBroadcast();
  });

  $('.message-sidebar-toggler').click(function () {
    $('body').toggleClass('message-sidebar-hidden');
    resizeBroadcast();
  });

  $('.pm-sidebar-toggler').click(function () {
    $('body').toggleClass('pm-sidebar-hidden');
    resizeBroadcast();
  });

  $('.sidebar-minimizer').click(function () {
    $('body').toggleClass('sidebar-minimized');
    resizeBroadcast();
  });

  $('.brand-minimizer').click(function () {
    $('body').toggleClass('brand-minimized');
  });

  $('.aside-menu-toggler').click(function () {
    $('body').toggleClass('aside-menu-hidden');
    resizeBroadcast();
  });

  $('.mobile-sidebar-toggler').click(function () {
    $('body').toggleClass('sidebar-mobile-show');
    resizeBroadcast();
  });

  $('.sidebar-close').click(function () {
    $('body').toggleClass('sidebar-opened').parent().toggleClass('sidebar-opened');
  });

  /* ---------- Disable moving to top ---------- */
  $('a[href="#"][data-top!=true]').click(function (e) {
    e.preventDefault();
  });


 /****
 * Tooltip
 */
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
});

/****
 * popover
 */
$(function () {
  $('[data-toggle="popover"]').popover()
});


  //  app-Directmessage
  $("#chatList").niceScroll({
    cursorcolor: "#AEC6D2",
  });


});



/****
 * Theme Change
 */

function swapStyleSheetDark(sheet) {
  $('body').loading();
  document.getElementById('pageStyle').setAttribute('href', sheet);
  document.getElementById('breadcrumb').classList.remove("bc-colored");
  document.getElementById('breadcrumb').classList.remove("bg-theme");
  document.getElementById('sidebar').classList.add("sidebar-colored");
  
  setInterval(function () {
    $(':loading').loading('stop');
  }, 9000);
}

function swapStyleSheet(sheet) {
  
  $('body').loading();
  document.getElementById('pageStyle').setAttribute('href', sheet);
  document.getElementById('breadcrumb').classList.add("bc-colored");
  document.getElementById('breadcrumb').classList.add("bg-theme");
  document.getElementById('sidebar').classList.remove("sidebar-colored");

  setInterval(function () {
    $(':loading').loading('stop');
  }, 9000);
}


/****
 * Theme Change for apps
 */

function appSwapStyleSheetDark(sheet) {
  $('body').loading();
  document.getElementById('pageStyle').setAttribute('href', sheet);
 
  
  setInterval(function () {
    $(':loading').loading('stop');
  }, 9000);
}

function appSwapStyleSheet(sheet) {
  
  $('body').loading();
  document.getElementById('pageStyle').setAttribute('href', sheet);
 

  setInterval(function () {
    $(':loading').loading('stop');
  }, 9000);
}


