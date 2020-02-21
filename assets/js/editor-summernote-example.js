//////////////////////////////////////////////////////
//  Template Name: octAdmin
//  Author: octathemes
//  Email: octathemes@gmail.com
//  File: editor-summernote-example.js
///////////////////////////////////////////////////

$(function () {
    "use strict";

$('#summernote').summernote({
    placeholder: 'Hello bootstrap 4',
    tabsize: 2,
    height: 500
});

$('#summernote-air').summernote({
    airMode: true
});



// basic hint

$(".hint2basic").summernote({
    height: 100,
    toolbar: false,
    placeholder: 'type with apple, orange, watermelon, lemon',
    hint: {
        words: ['apple', 'orange', 'watermelon', 'lemon'],
        match: /\b(\w{1,})$/,
        search: function (keyword, callback) {
            callback($.grep(this.words, function (item) {
                return item.indexOf(keyword) === 0;
            }));
        }
    }
});



// hint for emoji

$.ajax({
    url: 'https://api.github.com/emojis'
}).then(function (data) {
    window.emojis = Object.keys(data);
    window.emojiUrls = data;
});

$(".hint2emoji").summernote({
    height: 100,
    toolbar: false,
    placeholder: 'type starting with : and any alphabet',
    hint: {
        match: /\B:([\-+\w]+)$/,
        search: function (keyword, callback) {
            callback($.grep(emojis, function (item) {
                return item.indexOf(keyword) === 0;
            }));
        },
        template: function (item) {
            var content = emojiUrls[item];
            return '<img src="' + content + '" width="20" /> :' + item + ':';
        },
        content: function (item) {
            var url = emojiUrls[item];
            if (url) {
                return $('<img />').attr('src', url).css('width', 20)[0];
            }
            return '';
        }
    }
});



// hint mention

$(".hint2mention").summernote({
    height: 100,
    toolbar: false,
    placeholder: 'type starting with @',
    hint: {
      mentions: ['jayden', 'sam', 'alvin', 'david'],
      match: /@(\w*)$/,
      search: function (keyword, callback) {
        callback($.grep(this.mentions, function (item) {
          return item.indexOf(keyword) == 0;
        }));
      },
      content: function (item) {
        return '@' + item;
      }    
    }
  });

});


//Click to Edit

var edit = function () {
    $('.click2edit').summernote({
        focus: true
    });
};

var save = function () {
    var markup = $('.click2edit').summernote('code');
    $('.click2edit').summernote('destroy');
};