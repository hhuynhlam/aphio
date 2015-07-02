'use strict';

define(function (require) {
    var auth = require('auth');
    var sandbox = require('sandbox');

    describe('Auth', function() {
        it('can auth', function () {
            expect(auth.login).toBeDefined();
            expect(auth.logout).toBeDefined();
            expect(auth.isLoggedIn).toBeDefined();
            expect(auth.currentUser).toBeDefined();
            expect(auth.setCurrentUser).toBeDefined();
        });

        // @TODO: test auth.login
        
        it('can logout', function () {
            sandbox.storage.set('apo_user', {});    
            auth.logout();
            expect(sandbox.storage.read('apo_user')).toBeNull();
        });

        it('can logout', function () {
            expect(auth.isLoggedIn()).toBe(false);
            sandbox.storage.set('apo_user', {}); 
            expect(auth.isLoggedIn()).toBe(true);
        });

        it('can get setCurrentUser', function () {
            var user = [{ name: 'Lionel Richie' }];
            auth.setCurrentUser(user);
            expect(JSON.parse(window.sessionStorage.apo_user)).toEqual(user[0]);
        });

        it('can get currentUser', function () {
            var user = [{ name: 'Lionel Richie' }];
            auth.setCurrentUser(user);
            expect(auth.currentUser()).toEqual(user[0]);
        });
    });
});