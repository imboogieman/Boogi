YUI.add('artist-view', function(Y) {

    'use strict';

    Y.ArtistView = Y.Base.create('artistView', Y.BaseView, [Y.CalendarExtension, Y.BookFormExtension, Y.FormExtension,
        Y.BookingsArtistExtension, Y.SearchExtension, Y.ToolbarExtension, Y.UploadHelper], {

        events: {
            '.add-message'      : { click: 'addMessage' },
            '.update-artist-gig': { click: 'updateArtistGig' },
            '#book'             : { click: 'bookArtist' },
            '.import-artist'    : { click: 'importArtist' },
            '.cancel-update'    : { click: 'cancelUpdate' },
            '#gig-filter'       : { change: 'switchGigFilter' }
        },

        initializer: function() {
            this.log('Init');
            this.model = this.get('model');
            this.artistMarkers = [];
            this.gigMarkers = [];
            this.month = new Date();
        },

        render: function() {
            this.log('Render');

            switch (this.get('action')) {
                case 'profile':
                    this.profile();
                    this.hideLoader();
                    break;
                case 'bookings':
                    this.bookings(this.get('id'));
                    break;
                case 'add':
                    this.addArtist(this.get('query'), this.get('mild'));
                    break;
                case 'book':
                    this.book(this.get('id'), this.get('alias'), this.get('date'));
                    break;
                case 'show':
                    this.show(this.get('id'), this.get('alias'), this.get('gig'));
                    break;
                default:
                    this.list();
                    break;
            }
        },

        list: function() {
            this.log('Show artists');

            // Extract the template string and compile it into a reusable function.
            var source   = Y.one('#t-artist-list').getHTML(),
                template = Y.Handlebars.compile(source),
                offset   = 0,
                html;

            this.model.list(offset);

            this.model.once('artist:list', Y.bind(function() {
                this.log('Artist list loaded');

                var options = { artists: this.model.get('list') };

                // Render the template to HTML using the specified data.
                html = template(options);

                // Append the rendered template to the page.
                this.get('container').setHTML(html);

                // Load map
                this.loadArtistsMap(options);

                // Set map center by user
                this.updateMapCenter(true, true);

                // Init pagination
                this.get('container').one('#load-more-artists').on('click', Y.bind(function(e) {
                    var button = e.target;

                    offset = button.getData('offset');
                    this.model.list(offset);

                    this.model.once('artist:list', Y.bind(function() {
                        this.log('Artist list updated');

                        // Extract the template string and compile it into a reusable function.
                        var source   = Y.one('#t-raw-artist-list').getHTML(),
                            template = Y.Handlebars.compile(source),
                            html;

                        var options = { artists: this.model.get('list') };

                        // Render the template to HTML using the specified data.
                        html = template(options);

                        // Append the rendered template to the page.
                        this.get('container').one('#load-more-artists').insert(html, 'before');

                        // Load map
                        this.loadArtistsMap(options);

                        // Set map center by user
                        this.updateMapCenter(true, true);

                        // Update pagination offset
                        button.setData('offset', parseInt(offset) + 30)
                    }, this));
                }, this));
            }, this));
        },

        show: function(id, alias, selected_gig) {
            this.log('Show artist #' + id + '; alias: ' + alias);

            // Track artist profile
            window.app.track('User', 'Visit artist profile', alias);

            // Extract the template string and compile it into a reusable function.
            var source      = Y.one('#t-artist').getHTML(),
                container   = this.get('container'),
                template    = Y.Handlebars.compile(source),
                html;

            this.model.find({ id: id, alias: alias, radius: this.radius, center: this.center });

            this.model.once('artist:404', Y.bind(function() {
                this.model.detachAll();
                window.app.showView('site', { action: '404' });
            }, this));

            this.model.once('artist:show', Y.bind(function() {
                this.log('Artist loaded');

                // Artist calendar
                var artist = this.model.get('item'),
                    gigs   = this.model.get('gigs');

                // Render artist
                html   = template({
                    artist      : artist,
                    venueAttrs  : window.appConfig.venueAttrs
                });
                container.setHTML(html);

                // Merge gigs
                gigs = gigs.active.concat(gigs.past);

                // Update current month
                this.month = selected_gig ? new Date(selected_gig.date) : new Date;
                this.set('calendarFirstDate', this.month);

                // Init calendar
                var rules = this.prepareRulesFromGigs(gigs, this.month == new Date);
                this.initCalendar('#artist-calendar-block', rules);

                // Load map
                this.loadGigsMap(gigs, selected_gig);
                this.updateMapCenter(false, true);
                this.panMapToGigMarkersCenter(selected_gig);

                // Bind calendar events
                this.bindCalendarEvents();
            }, this));
        },

        loadArtistsMap: function(options) {
            this.log('Load artists map');

            this.map = new google.maps.Map(document.getElementById('map'), window.appConfig.mapOptions);

            // Set artist markers on the map
            for (var i = 0; i < options.artists.length; i++) {
                if (options.artists[i].latitude && options.artists[i].longitude) {
                    this.setArtistMarker(options.artists[i]);
                }
            }
        },

        setArtistMarker: function(artist) {
            if (parseFloat(artist.latitude) && parseFloat(artist.longitude)) {
                var position = new google.maps.LatLng(artist.latitude, artist.longitude),
                    marker   = new google.maps.Marker({
                        position: position,
                        map     : this.map,
                        title   : artist.name,
                        icon    : '/images/marker/m-artist.png'
                    });

                var source     = Y.one('#t-artist-iw-block').getHTML(),
                    template   = Y.Handlebars.compile(source),
                    content    = template(artist),
                    infowindow = new google.maps.InfoWindow({ content: content });

                google.maps.event.addListener(marker, 'click', Y.bind(function() {
                    // Close other windows
                    for (var i = 0; i < this.artistMarkers.length; i++) {
                        this.artistMarkers[i].infowindow.close();
                    }

                    infowindow.open(this.map, marker);
                }, this));

                this.artistMarkers.push({
                    name        : artist.name,
                    marker      : marker,
                    infowindow  : infowindow
                });
            }
        },

        loadGigsMap: function(gigs, selected_gig) {
            this.log('Load gigs map');

            var i;

            if (!this.map || !this.get('container').one('#map').get('text')) {
                this.map = new google.maps.Map(document.getElementById('map'), window.appConfig.mapOptions);
            } else {
                for (i = 0; i < this.gigMarkers.length; i++) {
                    this.gigMarkers[i].marker.setMap(null);
                    this.gigMarkers[i].infowindow.setMap(null);
                }
            }

            // Set gig markers on the map
            this.gigMarkers = [];
            for (i = 0; i < gigs.length; i++) {
                if (gigs[i].withMarker) {
                    this.setGigMarker(gigs[i], selected_gig);
                }
            }
        },

        setGigMarker: function(gig, selected_gig) {
            var gigDate = Y.Date.parse(gig.date), icon;

            if (gigDate.getMonth() == this.month.getMonth() && gigDate.getYear() == this.month.getYear()) {
                icon = gig.isGigInRadius ? '/images/marker/m-gig-in-radius.png' : '/images/marker/m-gig.png';
                icon = gigDate >= new Date() ? icon  : '/images/marker/m-past-gig.png';

                // Create marker
                var marker = new MarkerWithLabel({
                        map             : this.map,
                        position        : gig.position,
                        title           : gig.name + ' @ ' + gig.venue.name,
                        icon            : icon,
                        labelClass      : gig.isGigInRadius ? 'gigInRadiusLabel' : 'gigLabel',
                        labelContent    : gig.is_multi ? 'x' + gig.is_multi : gig.label,
                        labelAnchor     : new google.maps.Point(22, 33),
                        labelStyle      : { opacity: 0.75 }
                    });

                // Compile marker info window
                var source     = Y.one('#t-gig-iw-block').getHTML(),
                    template   = Y.Handlebars.compile(source),
                    content    = template(gig),
                    infowindow = new google.maps.InfoWindow({ content: content });

                // Add marker click listener
                google.maps.event.addListener(marker, 'click', Y.bind(function() {
                    // Close other windows
                    for (var i = 0; i < this.gigMarkers.length; i++) {
                        this.gigMarkers[i].infowindow.close();
                    }

                    // Open current
                    infowindow.open(this.map, marker);
                }, this));

                // Save marker to array
                this.gigMarkers.push({
                    id          : gig.id,
                    name        : gig.name,
                    alias       : gig.alias,
                    date        : gig.date,
                    marker      : marker,
                    infowindow  : infowindow
                });

                if (selected_gig && selected_gig.id == gig.gig_id) {
                    infowindow.open(this.map, marker);
                }
            }
        },

        bindCalendarEvents: function() {
            this.log('Bind calendar events');

            var showSelectedDateNotice = true,
                container = this.get('container'),
                gigs = this.model.get('gigs'),
                rules;

            // Concat gigs
            gigs = gigs.active.concat(gigs.past);
            rules = this.prepareRulesFromGigs(gigs);

            // Bind select date
            container.on('calendar:selected', Y.bind(function(e) {
                var currentDate,
                    today = Y.Date.format(new Date, { format: '%Y-%m-%d' }),
                    selected = this.GIG_FROM_CLASS;

                // Remove all selected class
                container.all('.' + selected).removeClass(selected);

                // Check markers
                for (var i = 0; i < this.gigMarkers.length; i++) {
                    currentDate = Y.Date.parse(this.gigMarkers[i].date);
                    currentDate = Y.Date.format(currentDate, { format: '%Y-%m-%d' });
                    if (currentDate == e.date) {
                        // Center map selected marker
                        this.map.panTo(this.gigMarkers[i].marker.position);
                        this.map.panBy(this.offsetCenter.x, this.offsetCenter.y);

                        // Close other windows
                        for (var j = 0; j < this.gigMarkers.length; j++) {
                            this.gigMarkers[j].infowindow.close();
                        }

                        // Show infowindow
                        this.gigMarkers[i].infowindow.open(this.map, this.gigMarkers[i].marker);

                        // Disable book button
                        container.one('#book-artist').removeClass('active');
                        return;
                    }
                }

                // Skip click for past dates
                if (e.date < today) {
                    showSelectedDateNotice && this.showOverlay('Selected date in the past, try other');
                    showSelectedDateNotice = false;

                    container.one('#book-artist').removeClass('active');
                } else {
                    // Add date to link
                    var link = container.one('#book-artist').get('pathname').split('/');
                    container.one('#book-artist').set('pathname', '/' + link[1] + '/book/' + e.date);

                    // Activate book button
                    container.one('#book-artist').addClass('active');

                    // Update current month colors
                    this.updateCalendar(e.date, rules, this.gigMarkers);
                }

                window.app.track('User', 'Select artist date');
            }, this));

            // Update markers when calendar month changed
            container.on('calendar:monthChanged', Y.bind(function(e) {
                this.month = e.month;

                // Update current month
                this.loadGigsMap(gigs);
                this.updateCalendar(null, rules, this.gigMarkers);

                // Update map center
                this.panMapToGigMarkersCenter();

                window.app.track('User', 'Select artist next month');
            }, this));

            // Remove selection if same day clicked
            container.delegate('click', Y.bind(function(e) {
                e.currentTarget.removeClass('artist-date-selected yui3-calendar-day-selected');
                container.one('#book-artist').removeClass('active');
            }, this), '.artist-date-selected');
        },

        book: function(id, alias, book_date) {
            this.log('Show book form');

            // Extract the template string and compile it into a reusable function.
            var source      = Y.one('#t-gig-book-form').getHTML(),
                template    = Y.Handlebars.compile(source),
                data        = { artist_id: id, alias: alias, venueAttrs: window.appConfig.venueAttrs,
                                radius: this.radius, center: this.center },
                container   = this.get('container'),
                html;

            // Trying to get artist
            this.model.getItem(data);

            this.model.once('artist:get', Y.bind(function() {
                this.log('Artist loaded');

                // Compile data
                data = this.model.get('item');
                data.venueAttrs = window.appConfig.venueAttrs;

                // Check book date not empty
                book_date = book_date ? book_date : Y.Date.format(new Date, { format: '%Y-%m-%d'});

                // Fix dates
                var datetime = Y.Date.parse(new Date(book_date).getTime() + 3600 * 19 * 1000),
                    date_from = Y.Date.format(datetime, { format: '%d.%m.%Y'}),
                    time_from = Y.Date.format(datetime, { format: '%l:%M %P'}),
                    date_to, time_to;

                datetime.setDate(datetime.getDate() + 1);
                date_to = Y.Date.format(datetime, { format: '%d.%m.%Y'});
                time_to = Y.Date.format(datetime, { format: '%l:%M %P'});

                data.gig_date_from = data.gig_date_from ? data.gig_date_from : date_from;
                data.gig_date_to = data.gig_date_to ? data.gig_date_to : date_to;

                data.gig_time_from = data.gig_time_from ? data.gig_time_from : time_from;
                data.gig_time_to = data.gig_time_to ? data.gig_time_to : time_to;

                data.book_date_from = data.book_date_from ? data.book_date_from : date_from;
                data.book_date_to = data.book_date_to ? data.book_date_to : date_to;

                data.book_time_from = data.book_time_from ? data.book_time_from : time_from;
                data.book_time_to = data.book_time_to ? data.book_time_to : time_to;

                // Update additional fields
                data.name = data.gig_date_from + ' ' + data.name;
                data.address = data.description;
                data.description = '';

                // Add disabled dates
                data.disable = [];
                for (var i = 0; i < data.gigs.active.length; i++) {
                    var gig = data.gigs.active[i];
                    for (var date = new Date(gig.datetime_from); date <= new Date(gig.datetime_to); date.setDate(date.getDate() + 1)) {
                        data.disable.push(Y.Date.format(date, { format: '%Y-%m-%d' }));
                    }
                }

                // Render book form
                html = template(data);
                container.setHTML(html);

                // Hook for widget renderer
                this.initBookForm(data);
                this.hideLoader();

                if (window.appConfig.user && window.appConfig.user.role == 1) {
                    window.app.track('Promoter', 'Open book form');
                } else {
                    window.app.track('User', 'Open book form');
                }
            }, this));
        },

        bookArtist: function () {
            this.log('Submit book form');

            var form = this.get('container').one('#booking-form'),
                data = this.serializeToJSON(form);

            // Update model
            this.model.book(data);

            this.model.once('artist:booked', Y.bind(function(e) {
                this.showOverlay(e.message, true);

                if (!window.appConfig.user) {
                    window.app.showView('user', { action: 'register' });
                } else {
                    this.show(data.artist_id);
                }

                if (window.appConfig.user && window.appConfig.user.role == 1) {
                    window.app.track('Promoter', 'Book artist');
                } else {
                    window.app.track('User', 'Book artist');
                }
            }, this));

            this.model.once('artist:errors', Y.bind(function(e) {
                var message = e.message;

                message += '<ul class="error-list">';
                for (var i = 0; i < e.errors.length; i++) {
                    message += '<li>' + e.errors[i].message + '</li>';
                }
                message += '</ul>';

                this.showOverlay(message);
                this.setErrors(e.errors);
            }, this));
        },

        profile: function() {
            this.log('Show profile');

            // Extract the template string and compile it into a reusable function.
            var source      = Y.one('#t-artist-profile').getHTML(),
                template    = Y.Handlebars.compile(source),
                data        = window.appConfig.user,
                container   = this.get('container'),
                html;

            // Render artist profile template
            data.allowedTags = window.appConfig.allowedTags;
            html = template(data);
            container.setHTML(html);

            // Bind update event
            container.one('#update').on('click', Y.bind(function(e) {
                this.update(e);
            }, this));

            // Tabs
            Y.delegate('click', Y.bind(function(e) {
                var target = e.target.getData('target');

                container.all('.tab').removeClass('active');
                e.target.addClass('active');

                if (target == 'social') {
                    this.renderProfileMapControl();
                }

                container.all('.tab-pane').addClass('hidden');
                container.one('#' + target).removeClass('hidden');
            }, this), container, '.tab');

            // Hook for map renderer
            this.initUploader({ container: container });
        },

        renderProfileMapControl: function() {
            var container = this.get('container');

            // LatLon map
            var options = window.appConfig.mapOptions;
            options.center = this.center;
            this.map = new google.maps.Map(document.getElementById('profile-map'), options);

            // User marker
            var marker = new google.maps.Marker({
                position: this.center,
                map: this.map,
                draggable: true,
                title: 'Your current position',
                icon: '/images/marker/m-artist.png'
            });

            // Update user position with radius update
            google.maps.event.addListener(marker, 'dragend', function () {
                container.one('#latitude').set('value', this.getPosition().lat());
                container.one('#longitude').set('value', this.getPosition().lng());
            });
        },

        update: function(e) {
            this.log('Submit profile form');
            e.preventDefault();

            var form = this.get('container').one('#profile-form'),
                data = this.serializeToJSON(form);

            this.model.update(data);

            this.model.once('artist:updated', Y.bind(function(e) {
                this.renderToolbar();
                this.showOverlay(e.message);
                window.app.showView('artist', { action: 'profile' });
            }, this));

            this.model.once('artist:update-errors', Y.bind(function(e) {
                this.highlightErrors(form, e.message, e.errors);
            }, this));
        },

        getTransferInfo: function (artist) {
            var result = {
                    start: null, end: null
                },
                startDate = this.get('startDate'),
                endDate = this.get('endDate');

            for (var i = 0; i < artist.gigs.length; i++) {
                if (artist.gigs[i].date == startDate) {
                    result.start = artist.gigs[i];
                }
                if (artist.gigs[i].date == endDate) {
                    result.end = artist.gigs[i];
                }
            }

            return result;
        },

        bookings: function(id) {
            this.log('Show bookings');

            // Update model
            this.model.bookingList();

            // Update view internals
            this.model.once('artist:bookings', Y.bind(function () {
                this._renderBookings(id);
            }, this));

            this._bindArtistEditEvents();
            this._bindArtistSidebarEvents();
        },

        addArtist: function(query, mild) {
            this.log('Search artist with query: ' + query + ', is mild search - ' + (mild ? 'True' : 'False'));

            if (query) {
                // Try to find artist on Facebook
                this.model.searchArtistOnFacebook({ query: query, mild: mild ? 1 : 0 });

                // Update view internals
                this.model.once('artist:found', Y.bind(function () {
                    var artists = this.model.get('search'),
                        source = Y.one('#t-artist-import').getHTML(),
                        template = Y.Handlebars.compile(source),
                        container = this.get('container'),
                        html;

                    // Add to container bookings block
                    html = template({ artists: artists, show_extended: 0 });
                    container.setHTML(html);
                    this.hideLoader();
                }, this));

                this.model.once('artist:not-found', Y.bind(function () {
                    var source = Y.one('#t-artist-import').getHTML(),
                        template = Y.Handlebars.compile(source),
                        container = this.get('container'),
                        html;

                    // Add to container bookings block
                    html = template({ show_extended: 1, query: encodeURIComponent(query), mild: mild });
                    container.setHTML(html);
                    this.hideLoader();
                }, this));
            } else {
                this.showOverlay('Please enter artist name for search');
                window.location.href = '/';
            }
        },

        importArtist: function(e) {
            var fb_id = e.target.getData('id');

            // Try to import artist from Facebook
            this.model.importArtistFromFacebook(fb_id);

            // Update view internals
            this.model.once('artist:imported', Y.bind(function () {
                var artist = this.model.get('import'),
                    source = Y.one('#t-artist-import-result').getHTML(),
                    template = Y.Handlebars.compile(source),
                    container = this.get('container'),
                    html;

                container.one('#artist-import-item-' + fb_id).remove();

                html = template({ artist: artist });
                container.one('#imported-items').removeClass('hidden')
                    .one('.result').append(html);

                this.hideLoader();
                this.importArtistGigs(fb_id);
            }, this));

            window.app.track('User', 'Import Artist');
        },

        importArtistGigs: function (fb_id) {
            var container = this.get('container'),
                progress = container.one('#artist-import-item-' + fb_id).one('.import-progress');

            progress.removeClass('hidden').addClass('loading');

            // Try to import artist gigs
            this.model.importArtistGigs(fb_id);

            // Update gig counters
            this.model.once('artist:gigs-imported', Y.bind(function () {
                var count = this.model.get('gigs-imported');
                progress.setHTML(count + ' gig(s) imported to our system');
                progress.removeClass('loading');
            }, this));

            // Update gig counters
            this.model.once('artist:gigs-not-found', Y.bind(function () {
                progress.setHTML('Currently we can\'t find any gigs for this artist. Our managers will check this artist profile to update gigs.');
                progress.removeClass('loading');
            }, this));
        },

        updateArtistGig: function(e) {
            this.log('Submit artist gig form');
            e.preventDefault();

            var form = this.get('container').one('#book-form form'),
                data = this.serializeToJSON(form);

            this.model.updateArtistGig(data);

            this.model.once('artistGig:updated', Y.bind(function(e) {
                this._renderBookings(data.gig_id + '-' + data.artist_id);
            }, this));
        },

        updateGigList: function() {
            // Render bookings HTML
            var data     = this.model.get('gigList'),
                source   = Y.one('#t-raw-artist-bookings').getHTML(),
                template = Y.Handlebars.compile(source),
                html;

            html = template({
                active          : data.active,
                past            : data.past,
                show_past_label : data.show_past_label,
                venueAttrs      : window.appConfig.venueAttrs
            });

            this.get('container').one('#bookings').setHTML(html);
        },

        addMessage: function(e) {
            this.log('Submit message form');
            e.preventDefault();

            var form = e.target.ancestor('form.booking-message'),
                data = {
                    gig_id      : form.one('.gig_id').get('value'),
                    artist_id   : form.one('.artist_id').get('value'),
                    type        : form.one('.type').get('value'),
                    message     : form.one('.message').get('value')
                };

            this.model.message(data);

            this.model.once('message:sent', Y.bind(function() {
                var data = { messages: this.model.get('messageList') },
                    source   = Y.one('#t-artist-messages').getHTML(),
                    template = Y.Handlebars.compile(source);

                // Compile and show booking artists
                this.get('container').one('#details').setHTML(template(data));

                // Update window height and messages list height
                this.updateWindowHeight(true);
            }, this));
        },

        cancelUpdate: function(e) {
            e.preventDefault();
            this._renderBookings(e.target.getData('rel'));
            return false;
        },

        switchGigFilter: function (e) {
            this.log('Switch gig filter');
            e.preventDefault();

            var container = this.get('container'),
                filter = e.target.get('value');

            container.all('.gig-list').addClass('hidden');
            if (filter == 'active') {
                container.one('#active-gigs'). removeClass('hidden');
            } else {
                container.one('#past-gigs'). removeClass('hidden');
            }
        }

    }, {
        ATTRS: {
            model: {
                valueFn: function () {
                    return new Y.ArtistModel();
                }
            },

            artistMarkers: {
                value: null
            },

            gigMarkers: {
                value: null
            },

            calendar: {
                value: null
            },

            selectedDate: {
                value: null
            },

            startDate: {
                value: null
            },

            endDate: {
                value: null
            },

            month: {
                value: null
            },

            calendarFirstDate: {
                value: new Date
            }
        }
    });
},
'0.1',
{
    requires: [
        'json',
        'io-form',
        'handlebars',
        'base-view',
        'artist-model',
        'gig-model',
        'map-extension',
        'form-extension',
        'toolbar-extension',
        'loader-extension',
        'book-form-extension',
        'calendar-extension',
        'search-extension',
        'bookings-artist-extension',
        'upload-helper'
    ]
});