(function($, window, require, undefined) {
    "use strict";

    window.Class         = require('class-js2');
    window.EventAbstract = require('local/event_abstract');
    window.JCache        = require('local/jcache');

    JCache.set('form_builder', new (require('local/form_builder')));

    // initialize configuration filter
    require('local/configuration/filter')();

})(jQuery, window, require);