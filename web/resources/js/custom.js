(function($, window, require, undefined) {
    "use strict";

    window.Class         = require('class-js2');
    window.EventAbstract = require('local/event_abstract');
    window.JCache        = require('local/jcache');
    window.__url         = require('local/url_resolver');

    // central location to load everything from database
    window.EntityManager = new (require('local/entity/manager'))();
    window.FormBuilder   = new (require('local/form_builder'))();

    // this class is required to make the entire application work
    window.ConfigFilter  = new (require('local/configuration/filter'))();

})(jQuery, window, require);