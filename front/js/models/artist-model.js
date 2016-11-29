YUI.add('artist-model', function(Y) {

    'use strict';

    Y.ArtistModel = Y.Base.create('artistModel', Y.BaseModel, [], {

        list: function(offset) {
            var callback = Y.bind(function (response) {
                    if (response.result == this.apiStatus.SUCCESS) {
                        this.set('list', response.data);
                        this.fire('artist:list');
                    }
                }, this);

            this.getData('/api/artist/list', { offset: offset }, callback, this, true);
        },

        getItem: function(data) {
            var artist = this.get('item');
            if (artist && (artist.id == data.artist_id || artist.link == '/' + data.alias)) {
                this.fire('artist:get');
            }

            var callback = Y.bind(function (response) {
                if (response.result == this.apiStatus.SUCCESS) {
                    this.set('item', response.data);
                    this.set('gigs', this._prepareGigs(response.data.gigs, data));
                    this.fire('artist:get');
                } else if (response.result == this.apiStatus.NOT_FOUND) {
                    this.fire('artist:404');
                }
            }, this);

            this.getData('/api/artist/get', data, callback, this, true);
        },

        find: function(data) {
            var callback = Y.bind(function (response) {
                    if (response.result == this.apiStatus.SUCCESS) {
                        this.set('item', response.data);
                        this.set('gigs', this._prepareGigs(response.data.gigs, data));
                        this.fire('artist:show');
                    } else if (response.result == this.apiStatus.NOT_FOUND) {
                        this.fire('artist:404');
                    }
                }, this);

            this.getData('/api/artist/get', data, callback, this, true);
        },

        _prepareGigs: function (gigs, data) {
            var i, latitude, longitude, isGigInRadius, distance;

            if (gigs.active) {
                for (i = 0; i < gigs.active.length; i++) {
                    latitude = parseFloat(gigs.active[i].venue.latitude);
                    longitude = parseFloat(gigs.active[i].venue.longitude);

                    if (latitude != 0 && longitude != 0) {
                        // Check location
                        gigs.active[i].withMarker = true;
                        gigs.active[i].position = new google.maps.LatLng(latitude, longitude);

                        // Check radius
                        isGigInRadius = false;
                        if (gigs.active[i].hasOwnProperty('inRadius')) {
                            if (gigs.active[i].inRadius) {
                                isGigInRadius = true;
                            }
                        } else if (gigs.active[i].withMarker) {
                            distance = google.maps.geometry.spherical.computeDistanceBetween(data.center, gigs.active[i].position);
                            if (distance < data.radius) {
                                isGigInRadius = true;
                            }
                        }

                        gigs.active[i].isGigInRadius = isGigInRadius;
                    } else {
                        gigs.active[i].withMarker = false;
                    }
                }
            }

            if (gigs.past) {
                for (i = 0; i < gigs.past.length; i++) {
                    latitude = parseFloat(gigs.past[i].venue.latitude);
                    longitude = parseFloat(gigs.past[i].venue.longitude);

                    if (latitude != 0 && longitude != 0) {
                        // Check location
                        gigs.past[i].withMarker = true;
                        gigs.past[i].position = new google.maps.LatLng(latitude, longitude);

                        // Check radius
                        isGigInRadius = false;
                        if (gigs.past[i].hasOwnProperty('inRadius')) {
                            if (gigs.past[i].inRadius) {
                                isGigInRadius = true;
                            }
                        } else if (gigs.past[i].withMarker) {
                            distance = google.maps.geometry.spherical.computeDistanceBetween(data.center, gigs.past[i].position);
                            if (distance < data.radius) {
                                isGigInRadius = true;
                            }
                        }

                        gigs.past[i].isGigInRadius = isGigInRadius;
                    } else {
                        gigs.past[i].withMarker = false;
                    }
                }
            }

            return gigs;
        },

        book: function(data) {
            var callback = Y.bind(function (response) {
                    if (response.result == this.apiStatus.SUCCESS) {
                        this.fire('artist:booked', { message: response.message, is_new_user: response.is_new_user });
                    } else if (response.result == this.apiStatus.INVALID) {
                        this.fire('artist:errors', { message: response.message, errors: response.errors });
                    }
                }, this);

            this.getData('/api/artist/book', data, callback, this, true);
        },

        update: function(data) {
            var callback = Y.bind(function (response) {
                if (response.result == this.apiStatus.SUCCESS) {
                    window.appConfig.user = response.data;
                    this.fire('artist:updated', { message: response.message });
                } else if (response.result == this.apiStatus.INVALID) {
                    this.fire('artist:update-errors', { message: response.message, errors: response.errors });
                }
            }, this);

            this.getData('/api/artist/update', data, callback, this, true);
        },

        bookingList: function () {
            var callback = Y.bind(function (response) {
                if (response.result == this.apiStatus.SUCCESS) {
                    this.set('bookingList', response.data);
                    this.fire('artist:bookings');
                }
            }, this);

            this.getData('/api/artist/bookings', {}, callback, this, true);
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
                }
            }, this);

            this.getData('/api/site/messages', data, callback, this, true);
        },

        updateArtistGig: function (data) {
            var callback = Y.bind(function (response) {
                if (response.result == this.apiStatus.SUCCESS) {
                    this.set('bookingList', response.data);
                    this.fire('artistGig:updated');
                }
            }, this);

            this.getData('/api/gig/updatebooking', data, callback, this, true);
        },

        updateStatus: function (data) {
            var callback = Y.bind(function (response) {
                if (response.result == this.apiStatus.SUCCESS) {
                    this.set('bookingList', response.data);
                    this.fire('status:updated');
                }
            }, this);

            this.getData('/api/gig/updatestatus', data, callback, this, true);
        },

        searchArtistOnFacebook: function (data) {
            var callback = Y.bind(function (response) {
                if (response.result == this.apiStatus.SUCCESS) {
                    this.set('search', response.data);
                    this.fire('artist:found');
                } else if (response.result == this.apiStatus.NO_RECORDS) {
                    this.fire('artist:not-found');
                }
            }, this);

            this.getData('/api/artist/searchonfacebook', data, callback, this, true);
        },

        importArtistFromFacebook: function (fb_id) {
            var callback = Y.bind(function (response) {
                if (response.result == this.apiStatus.SUCCESS) {
                    this.set('import', response.data);
                    this.fire('artist:imported');
                }
            }, this);

            this.getData('/api/artist/importfromfacebook', { fb_id: fb_id }, callback, this, true);
        },

        importArtistGigs: function (fb_id) {
            var callback = Y.bind(function (response) {
                if (response.result == this.apiStatus.SUCCESS) {
                    this.set('gigs-imported', response.data);
                    this.fire('artist:gigs-imported');
                } else if (response.result == this.apiStatus.NO_RECORDS) {
                    this.fire('artist:gigs-not-found');
                }
            }, this);

            this.getData('/api/artist/importgigs', { fb_id: fb_id }, callback, this, false);
        },

        getArtistGig: function(id) {
            var items = this.get('bookingList'), i;

            // Check active items
            for (i = 0; i < items.active.length; i++) {
                if (items.active[i].id == id) {
                    return this.updateAdditionalBookingInfo(items.active[i]);
                }
            }

            // Check past items
            for (i = 0; i < items.past.length; i++) {
                if (items.past[i].id == id) {
                    return this.updateAdditionalBookingInfo(items.past[i]);
                }
            }

            return false;
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
            return booking;
        }

    }, {
        ATTRS: {

            item: {
                value: null
            },

            bookingList: {
                value: null
            },

            list: {
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