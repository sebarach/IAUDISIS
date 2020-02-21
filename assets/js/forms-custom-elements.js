 //////////////////////////////////////////////////////
 //  Template Name: octAdmin
 //  Author: octathemes
 //  Email: octathemes@gmail.com
 //  File: forms-custom-elements.js
 ///////////////////////////////////////////////////

 $(function () {
     "use strict";

     // switchery
     var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

     elems.forEach(function (html) {
         var switchery = new Switchery(html);
     });

     var elem_primary = document.querySelector('#switch-primary');
     var switchery = new Switchery(elem_primary, {
         color: '#188ae2'
     });

     var elem_info = document.querySelector('#switch-info');
     var switchery = new Switchery(elem_info, {
         color: '#1BC9E4'
     });

     var elem_success = document.querySelector('#switch-success');
     var switchery = new Switchery(elem_success, {
         color: '#10c469'
     });

     var elem_warning = document.querySelector('#switch-warning');
     var switchery = new Switchery(elem_warning, {
         color: '#ffc107'
     });

     var elem_danger = document.querySelector('#switch-danger');
     var switchery = new Switchery(elem_danger, {
         color: '#FF5252'
     });

     var elem_small = document.querySelector('#switch-small');
     var switchery = new Switchery(elem_small, {
         size: 'small'
     });

     var elem_medium = document.querySelector('#switch-medium');
     var switchery = new Switchery(elem_medium);

     var elem_large = document.querySelector('#switch-large');
     var switchery = new Switchery(elem_large, {
         size: 'large'
     });

 });