(function($, window, require, undefined) {
    "use strict";

    window.Class         = require('class-js2');
    window.EventAbstract = require('local/event_abstract');

    // initialize configuration filter
    require('local/configuration/filter')();

})(jQuery, window, require);