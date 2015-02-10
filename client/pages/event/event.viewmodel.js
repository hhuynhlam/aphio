'use strict';

define(function (require) {
	var $ = require('jquery');
	var _ = require('lodash');
	var constant = require('constant');
	var env = require('env');
	var ko = require('knockout');
	var moment = require('moment');
	var utils = require('utils');
	require('customBindings');

	// Locals
	var _increment = 30;
	var _limit = 30;
	var _offset = 0;

	var eventViewModel = {

		_clientRoot: env.CLIENT_ROOT,
		events: ko.observableArray([]),
		eventDetail: ko.observable({}),
		eventLoading: ko.observable(true),
		filter: ko.observable(0),
		pageLoading: ko.observable(true),
		shifts : ko.observableArray([]),
		
		general: ['general'],
		services: ['service', 'community', 'campus', 'fraternity', 'nation', 'fundraiser', 'general_service'],
		fellowships: ['fellowship', 'crazy', 'cool', 'sexy'],
		interchapters: ['interchapter', 'interchapter_home', 'interchapter_away'],

		// Filter Events
		filterEvents: function (viewmodel, event) {
			var self, filterArray, selectedFilters;
			
			// only if the thing being clicked is not disabled
			if( !$('#' + event.currentTarget.id).hasClass('disabled') ) {
				self = this;
				filterArray = [];
				selectedFilters = $('.active');
				
				// reset filters and offset
				self.filter(0);
				_offset = 0;

				// select all active filters
				selectedFilters.each(function () {
					filterArray.push(this.id);
				});

				// add to filter for each active filter
				filterArray.forEach(function (f) {
					switch(f) {
						case 'general':
							self.filter( self.filter() + constant.OTHER + constant.MEETING );
							break;

						case 'service':
							self.filter( self.filter() + constant.SERVICE );
							break;
						case 'community':
							self.filter( self.filter() + constant.COMMUNITY );
							break;
						case 'campus':
							self.filter( self.filter() + constant.CAMPUS );
							break;
						case 'fraternity':
							self.filter( self.filter() + constant.FRATERNITY );
							break;
						case 'nation':
							self.filter( self.filter() + constant.NATION );
							break;
						case 'fundraiser':
							self.filter( self.filter() + constant.FUNDRAISER );
							break;
						case 'general_service':
							self.filter( self.filter() + constant.GENERAL );
							break;

						case 'fellowship':
							self.filter( self.filter() + constant.FELLOWSHIP );
							break;
						case 'cool':
							self.filter( self.filter() + constant.COOL_FELLOWSHIP );
							break;
						case 'crazy':
							self.filter( self.filter() + constant.CRAZY_FELLOWSHIP );
							break;
						case 'sexy':
							self.filter( self.filter() + constant.SEXY_FELLOWSHIP );
							break;

						case 'interchapter':
							self.filter( self.filter() + constant.INTERCHAPTER_AWAY + constant.INTERCHAPTER_HOME );
							break;
						case 'interchapter_away':
							self.filter( self.filter() + constant.INTERCHAPTER_AWAY );
							break;
						case 'interchapter_home':
							self.filter( self.filter() + constant.INTERCHAPTER_HOME );
							break;
					}
				});

				// clear events
				self.events([]);
				self.loadEvents( self.filter() );

			}

		},

		// Loading events
		loadEvents: function (type, startDate, endDate) {
			var self = this;
			var getEvents = (type) ? utils.getEvents(type, startDate, endDate, _limit, _offset) : utils.getEvents(null, startDate, endDate, _limit, _offset);
			
			self.eventLoading(true);

			getEvents.done(function (data) {
				data.forEach(function (e) {

					// convert to formatted date string from unix timestamp
					e.date = moment.unix(e.date).format('MM/DD/YYYY');
					self.events.push(e);
				});

				_offset += _increment;
				self.eventLoading(false);
				self.pageLoading(false);
			});

			getEvents.fail(function (error) {
				self.eventLoading(false);
				self.pageLoading(false);
				console.error('error: ' + error);
			});

			return getEvents;
		},

		showFilters: function () {
			$('.filter-collapse').toggle();
		},

		// Event Details
		initDetails: function (code) {
			var self = this;
			var eventIndex = _.findIndex(self.events(), { id: code });
			var promise = $.Deferred();

			// if the event is already loaded in event list
			if( eventIndex && eventIndex !== -1 ) {
				var selectedEvent = self.events()[eventIndex];

				if(selectedEvent && selectedEvent.description) {
					selectedEvent.description = utils.nl2br(selectedEvent.description);
				}

				self.eventDetail( selectedEvent );

				promise.resolve(true);
			}

			// else, we will look it up
			else {
				utils.getEvent(code)
					.done(function (data) {
						
						if (data[0] && data[0].date) {
							data[0].date = moment.unix(data[0].date).format('dddd, MMMM Do YYYY');
						}

						if (data[0] && data[0].description) {
							data[0].description = utils.nl2br(data[0].description);
						}

						self.eventDetail(data[0]);
						promise.resolve(true);
					})
					.fail(function () {
						promise.resolve(false);
					});
			}

			// set default description
			if(!self.eventDetail().description) {
				var _event = self.eventDetail();
				_.assign( _event, { description: 'No event description.' } );
				self.eventDetail(_event);
			}

			return promise;
		},

		// Shifts
		initShifts: function (eventId) {
			var self = this;
			var getShifts = utils.getShifts(eventId);
			var promise = $.Deferred();

			getShifts.done(function (data) {		
				if (data) {
					self.shifts([]);
					data.forEach(function (s) {
						var getSignups = utils.getSignups(s.id);
						s.start_time = moment.unix(s.start_time).format('h:mm a');
						s.end_time = moment.unix(s.end_time).format('h:mm a');
						
						getSignups.done(function (signups) {
							s.signups = signups;
							self.shifts.push(s);
							promise.resolve();
						});

						getSignups.fail(function () {
							promise.reject();
						});
						
					});
				}
				else {
					promise.reject();
				}
			});

			getShifts.fail(function () {
				promise.reject();
			});

			return promise;
		}

	};

	// Computed Observables
	eventViewModel.loaderEnabled = ko.computed(function () {
		return eventViewModel.pageLoading() || eventViewModel.eventLoading();
	});
	
	// Init
	(function init() {
		eventViewModel.loadEvents();
		
		// lazy load events
		$(window).on("scroll", function() {
			var scrollHeight = $(document).height();
			var scrollPosition = $(window).height() + $(window).scrollTop();
			
			// scroll is pass document height
			if (scrollPosition > (scrollHeight + 50) ) {
				eventViewModel.loadEvents( eventViewModel.filter() );
			}
		});
	})();

	return eventViewModel;

});