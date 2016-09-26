YUI.add('promoter-model', function(Y) {

    'use strict';

    Y.PromoterModel = Y.Base.create('promoterModel', Y.BaseModel, [], {

        update: function(data) {
            var callback = Y.bind(function (response) {
                    if (response.result == this.apiStatus.SUCCESS) {
                        window.appConfig.user = response.data;
                        this.fire('promoter:updated', { message: response.message });
                    } else if (response.result == this.apiStatus.INVALID) {
                        this.fire('promoter:update-errors', { message: response.message, errors: response.errors });
                    }
                }, this);

            this.getData('/api/promoter/update', data, callback, this, true);
        },

        list: function() {
            var callback = Y.bind(function (response) {
                    if (response.result == this.apiStatus.SUCCESS) {
                        this.set('list', response.data);
                        this.fire('promoter:list');
                    }
                }, this);

            this.getData('/api/promoter/list', {}, callback, this, true);
        },

        message: function (data) {
            var callback = Y.bind(function (response) {
                if (response.result == this.apiStatus.SUCCESS) {
                    this.set('messageList', response.data);
                    this.fire('message:sent');
                }
            }, this);

            this.getData('/api/message/add', data, callback, this, true);
        },

        messages: function (data) {
            var callback = Y.bind(function (response) {
                if (response.result == this.apiStatus.SUCCESS) {
                    this.set('messageList', response.data);
                    this.fire('messages:list');
                } else if (response.result == this.apiStatus.NO_RECORDS) {
                    this.fire('messages:empty');
                }
            }, this);

            this.getData('/api/message/get', data, callback, this, true);
        },

        bookingList: function (data) {
            var callback = Y.bind(function (response) {
                if (response.result == this.apiStatus.SUCCESS) {
                    this.set('gigList', response.data);
                    this.fire('booking:list');
                }
            }, this);

            this.getData('/api/promoter/bookings', data, callback, this, true);
        },

        updateStatus: function (data) {
            var callback = Y.bind(function (response) {
                if (response.result == this.apiStatus.SUCCESS) {
                    this.set('gigList', response.data);
                    this.fire('status:updated');
                }
            }, this);

            this.getData('/api/gig/updatestatus', data, callback, this, true);
        },

        events: function (offset) {
            var callback = Y.bind(function (response) {
                if (response.result == this.apiStatus.SUCCESS) {
                    this.set('eventList', response.data);
                    this.fire('events:list');
                }
            }, this);

            this.getData('/api/promoter/events', { offset: offset }, callback, this, true);
        },

        trackings: function () {
            var callback = Y.bind(function (response) {
                if (response.result == this.apiStatus.SUCCESS) {
                    this.set('trackingList', response.data);
                    this.fire('trackings:list');
                }
            }, this);

            this.getData('/api/promoter/trackings', { }, callback, this, true);
        },

        updateGig: function (data) {
            var callback = Y.bind(function (response) {
                if (response.result == this.apiStatus.SUCCESS) {
                    this.set('gigList', response.data);
                    this.fire('gig:updated');
                }
            }, this);

            this.getData('/api/gig/update', data, callback, this, true);
        },

        updateArtistGig: function (data) {
            var callback = Y.bind(function (response) {
                if (response.result == this.apiStatus.SUCCESS) {
                    this.set('gigList', response.data);
                    this.fire('artistGig:updated');
                }
            }, this);

            this.getData('/api/gig/updatebooking', data, callback, this, true);
        },

        find: function(data) {
            var callback = Y.bind(function (response) {
                if (response.result == this.apiStatus.SUCCESS) {
                    this.set('item', response.data);
                    this.fire('promoter:show');
                } else if (response.result == this.apiStatus.NOT_FOUND) {
                    this.fire('promoter:404');
                }
            }, this);

            this.getData('/api/promoter/get', data, callback, this, true);
        },

        getGig: function(id) {
            var items = this.get('gigList'), i;

            // Check active items
            for (i = 0; i < items.active.length; i++) {
                if (items.active[i].id == id) {
                    return this.updateAdditionalGigInfo(items.active[i]);
                }
            }

            // Check past items
            for (i = 0; i < items.past.length; i++) {
                if (items.past[i].id == id) {
                    return this.updateAdditionalGigInfo(items.past[i]);
                }
            }

            return false;
        },

        getArtistGig: function(id) {
            var items = this.get('gigList'), i, j;

            // Check active items
            for (i = 0; i < items.active.length; i++) {
                for (j = 0; j < items.active[i].bookings.length; j++) {
                    if (items.active[i].bookings[j].id == id) {
                        return this.updateAdditionalBookingInfo(items.active[i].bookings[j]);
                    }
                }
            }

            // Check past items
            for (i = 0; i < items.past.length; i++) {
                for (j = 0; j < items.past[i].bookings.length; j++) {
                    if (items.past[i].bookings[j].id == id) {
                        return this.updateAdditionalBookingInfo(items.past[i].bookings[j]);
                    }
                }
            }

            return false;
        },

        updateAdditionalGigInfo: function(gig) {
            gig.time_from = Y.Date.format(Y.Date.parse(gig.datetime_from), { format: '%l:%M %P' });
            gig.time_to = Y.Date.format(Y.Date.parse(gig.datetime_to), { format: '%l:%M %P' });
            gig.times = window.app.getTimepickerData();
            gig.tzInfo = window.appConfig.tzInfo;
            gig.venueAttrs = window.appConfig.venueAttrs;
            return gig;
        },

        updateAdditionalBookingInfo: function(booking) {
            booking.is_promoter = window.appConfig.user.role == 1 ? 1 : 0;
            booking.status_edit = window.app.getStatus('Edit');
            booking.status_rejected = window.app.getStatus('Closed');
            booking.book_date = Y.Date.format(Y.Date.parse(booking.datetime_from), { format: '%Y-%m-%d'});
            booking.time_from = Y.Date.format(Y.Date.parse(booking.datetime_from), { format: '%l:%M %P' });
            booking.time_to = Y.Date.format(Y.Date.parse(booking.datetime_to), { format: '%l:%M %P' });
            booking.times = window.app.getTimepickerData();
            booking.tzInfo = window.appConfig.tzInfo;
            booking.venueAttrs = window.appConfig.venueAttrs;
            return booking;
        }

    }, {
        ATTRS: {

            gig: {
                value: null
            },

            artistGig: {
                value: null
            },

            gigList: {
                value: null
            },

            artistGigList: {
                value: null
            },

            eventList: {
                value: null
            },

            trackingList: {
                value: null
            },

            messageList: {
                value: null
            }

        }
    });
},
'0.1',
{
    requires: [
        'base-model'
    ]
});