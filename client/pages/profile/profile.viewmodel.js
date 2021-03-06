'use strict';

define(function (require) {
	var $ = require('jquery');
	var auth = require('auth');
	var ko = require('knockout');
	var modal = require('modal');
	var role = require('role');
	var sandbox = require('sandbox');
	var tour = require('tour');

	var ProfileViewModel = function () {
		this.currentUser = auth.currentUser();
		this.currentUser.Status = role.getStatus(this.currentUser.Position);
		
		this.upcomingEvents = ko.observableArray([]);
		this.waitlistedEvents = ko.observableArray([]);

		this.formViewModel = {
			phone: ko.observable(this.currentUser.Phone),
			provider: ko.observable(this.currentUser.Provider || ''),
			email: ko.observable(this.currentUser.Email),
			shirtSize: ko.observable(this.currentUser.ShirtSize),
			schoolAddress: ko.observable(this.currentUser.TempAddress),
			permAddress: ko.observable(this.currentUser.PermAddress),
			newPassword: ko.observable(''),
			confirmPassword: ko.observable(''),
			confirmError: ko.observable(false),
			isDirty: ko.observable(false)
		};

		// format currentUser data
		this.currentUser.Notes = sandbox.util.nlToBr(this.currentUser.Notes);

		// setup submit actions for each form inputs
		sandbox.util.forIn(this.formViewModel, function (val, key) {
			var oldValue;

			if (!val.subscribe || key === 'isDirty') { return; }	// not all properties
			
			// get old value of observable
			val.subscribe(function (oldVal) { oldValue = oldVal; }, this, 'beforeChange');
			
			// compare new value to old value
			val.subscribe(function (newVal) {
				if (oldValue !== newVal) { this.formViewModel.isDirty(true); }
			}, this);
		}, this);

		// get upcoming events
		this.getUpcomingEvents();
		this.getWaitlistedEvents();
		tour.start('profile');
	};

	// Edit Profile
	ProfileViewModel.prototype.reset = function () {
		this.formViewModel.phone(this.currentUser.Phone);
		this.formViewModel.provider(this.currentUser.Provider || '');
		this.formViewModel.email(this.currentUser.Email);
		this.formViewModel.shirtSize(this.currentUser.ShirtSize);
		this.formViewModel.schoolAddress(this.currentUser.TempAddress);
		this.formViewModel.permAddress(this.currentUser.PermAddress);
		this.formViewModel.newPassword('');
		this.formViewModel.confirmPassword('');
		this.formViewModel.confirmError(false);
		this.formViewModel.isDirty(false);
	};
	
	ProfileViewModel.prototype.save = function () {
		var cancel, submit;

		// check password
		if (!this.doesPasswordsMatch()) { 
			this.formViewModel.confirmError(true);
			this.formViewModel.newPassword('');
			this.formViewModel.confirmPassword('');
			sandbox.notification.error('ConfirmPasswordError', 'Passwords do no match.');
			return; 
		} else if (this.formViewModel.confirmError() && !this.formViewModel.newPassword()) {
			sandbox.notification.error('ConfirmPasswordError', 'Passwords cannot be blank.');
			return;
		}
		
		// subscribe to save/cancel topics
		submit = sandbox.msg.subscribe('profile.save', function () {
			var url = window.env.SERVER_HOST + '/member/update',
				userData = this.serializeUserData();
			
			sandbox.http.post(url, userData)
			.then(function (user) {
				auth.logout();
				auth.setCurrentUser(user);
				this.currentUser = auth.currentUser();
				this.formViewModel.isDirty(false);
				this.reset();
				sandbox.notification.success('SaveProfileSuccess', 'Profile Saved.');
			}.bind(this))
			.catch(function (err) {
				sandbox.notification.success('SaveProfileError', 'Could not save profile, please try again later.');
				console.error('Error: There was a problem saving profile (', err, ')');
			})
			.done();

			sandbox.msg.dispose(submit, cancel);
		}, this);

		cancel = sandbox.msg.subscribe('profile.cancel', function () {
			sandbox.msg.dispose(submit, cancel);
		});

		// open up modal
		this.setupConfirmModal();
	};

	ProfileViewModel.prototype.serializeUserData = function () {
		return {
			apiKey: window.env.API_KEY,
			_id: this.currentUser.Id,
			phone: this.formViewModel.phone(),
			provider: this.formViewModel.provider(),
			email: this.formViewModel.email(),
			shirtSize: this.formViewModel.shirtSize(),
			tempAddress: this.formViewModel.schoolAddress(),
			permAddress: this.formViewModel.permAddress(),
			password: (this.formViewModel.newPassword()) ? sandbox.crypto.encrypt(this.formViewModel.newPassword()) : undefined
		};
	};

	ProfileViewModel.prototype.setupConfirmModal = function () {
		var selector = '#ConfirmModal',
			$kendoWindow = $(selector).data('kendoWindow');
			
		if ($kendoWindow) { 
			$kendoWindow.open();
		} else {
			modal('saveConfirm', {
				selector: selector,
				cancel: function () { sandbox.msg.publish('profile.cancel'); },
				confirm: function () { sandbox.msg.publish('profile.save'); }
			});
		}
	};

	ProfileViewModel.prototype.doesPasswordsMatch = function () {
		return this.formViewModel.newPassword() === this.formViewModel.confirmPassword();
	};

	// Upcoming Events
	ProfileViewModel.prototype.getUpcomingEvents = function () {
		var url = window.env.SERVER_HOST + '/signup/user',
			data = {
				apiKey: window.env.API_KEY,
				id: this.currentUser.Id,
				startTime: sandbox.date.toUnix()
			};

		sandbox.http.get(url, data)
		.then(function (events) {
			this.upcomingEvents(this.formatEventData(events));
		}.bind(this))
		.catch(function (err) {
			console.error('Error: Cannot get upcoming events (', err, ')');
		})
		.done();
	};

	// Waitlisted Events
	ProfileViewModel.prototype.getWaitlistedEvents = function () {
		var url = window.env.SERVER_HOST + '/waitlist/user',
			data = {
				apiKey: window.env.API_KEY,
				id: this.currentUser.Id,
				startTime: sandbox.date.toUnix()
			};

		sandbox.http.get(url, data)
		.then(function (events) {
			this.waitlistedEvents(this.formatEventData(events));
		}.bind(this))
		.catch(function (err) {
			console.error('Error: Cannot get waitlisted events (', err, ')');
		})
		.done();
	};

	ProfileViewModel.prototype.formatEventData = function (events) {
		var _events = [];
		events.forEach(function (e) {
			var conflict;
			if (e.StartTime) {
				conflict = sandbox.util.find(_events, function (_e) { 
					return e.StartTime >= _e.StartTime && e.StartTime <= _e.EndTime && e.Name !== _e.Name; });
				_events.push(sandbox.util.clone(e));
			}

			if (e.StartTime) { e.StartTime = sandbox.date.parseUnix(e.StartTime).format('h:mm A'); }
			if (e.EndTime) { e.EndTime = sandbox.date.parseUnix(e.EndTime).format('h:mm A'); }
			if (e.Date) { e.Date = sandbox.date.parseUnix(e.Date).format('M/D'); }
			if (conflict) { e.conflict = true; } else { e.conflict = false; }
		});

		return events;
	};

	// SMS Settings
	ProfileViewModel.prototype.testSMS = function () {
		var url = window.env.SERVER_HOST + '/sms/test',
			phone = this.formViewModel.phone().match(/\d+/g).join(''),
			address = phone + this.formViewModel.provider();

		sandbox.http.post(url, { 
			apiKey: window.env.API_KEY,
			to: address 
		})
		.then(function () { sandbox.notification.success('SMSTestSuccess', 'SMS Sent.'); })
		.catch(function () { sandbox.notification.error('SMSTestError', 'Could not send SMS, please try again later.'); })
		.done();
	};

	return ProfileViewModel;
});