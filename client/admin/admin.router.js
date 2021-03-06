'use strict';

define(function (require) {
    var auth = require('auth');
    var ko = require('knockout');
    var sandbox = require('sandbox');
    var DashboardViewModel = require('admin.dashboard.viewmodel');
    var NavbarViewModel = require('navbar.viewmodel');

    var adminRouter = function (app) {   
        
        app.get('/#/admin', function (context) {
            if(!auth.isLoggedIn()) { window.location.replace(window.env.CLIENT_HOST + '/login'); }
            else {
                require(['text!admin/dashboard/dashboard.html'], function (template) {
                    context.swap(sandbox.util.template(template));

                    // apply ko bindings
                    ko.applyBindings(new NavbarViewModel(), document.getElementById('Navbar'));
                    ko.applyBindings(new DashboardViewModel(), document.getElementById('AdminDashboard'));
                });
            }
        });

    };

    return adminRouter;

});