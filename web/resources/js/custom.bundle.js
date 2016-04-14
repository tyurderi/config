(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
(function($, window, require, undefined) {
    "use strict";

    // initialize configuration filter
    require('configuration/filter')();

})(jQuery, window, require);
},{"configuration/filter":2}],2:[function(require,module,exports){
module.exports = function()
{
    var $configurationList  = $('.configuration--list .list--items'),
        $configurationForm  = $('.configuration-filter--form form'),
        $formInput          = $configurationForm.find('input'),
        timeout             = null,
        $configurationCount = $('.configuration--count');

    $formInput.on('change input', function() {
        if(timeout)
        {
            clearTimeout(timeout);
        }

        timeout = setTimeout(function() {
            $configurationForm.submit();
        }, 250);
    });

    $configurationForm.on('submit', function(e) {
        e.preventDefault();

        var url  = $(this).attr('action'),
            data = $(this).serialize();

        $.post(url, data, function(response) {
            $configurationList.empty();

            response.data.forEach(function(item) {
                var $item = $('<div />', {
                    'data-configId': item.id,
                    'html': item.label,
                    'class': 'item'
                });

                $item.appendTo($configurationList);
                $item.on('click', function() {
                    console.log('Loading configuration with id %d...', item.id);
                });
            });

            $configurationCount.html(response.count)
        });

    });

    $configurationForm.submit();
};
},{}]},{},[1]);
