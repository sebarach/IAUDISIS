//////////////////////////////////////////////////////
//  Template Name: octAdmin
//  Author: octathemes
//  Email: octathemes@gmail.com
//  File: landing-page.js
///////////////////////////////////////////////////

$(function () {
    "use strict";

var $window = $(window);

  $window.on('scroll', function () {
    if ($window.scrollTop() > 48) {
        $('.header_area').addClass('sticky slideInDown');
    } else {
        $('.header_area').removeClass('sticky slideInDown');
    }
});

});

var scrollLink = $('.scroll');
 // Smooth scrolling
 scrollLink.click(function(e) {
    e.preventDefault();
    $('body,html').animate({
      scrollTop: $(this.hash).offset().top
    }, 1000 );
  });
  
  // Active link switching
  $(window).scroll(function() {
    var scrollbarLocation = $(this).scrollTop();
    
    scrollLink.each(function() {
      
      var sectionOffset = $(this.hash).offset().top - 120;
      
      if ( sectionOffset <= scrollbarLocation ) {
        $(this).parent().addClass('active');
        $(this).parent().siblings().removeClass('active');
      }
    })
    
  });

function swapStyleSheet(sheet) {
    $('body').loading({
        //stoppable: true
      });
    document.getElementById('pageStyle').setAttribute('href', sheet);

    setInterval(function() {
        $(':loading').loading('stop');
    }, 10000);
   

}