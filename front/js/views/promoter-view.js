YUI.add('promoter-view', function(Y) {

    'use strict';

    Y.PromoterView = Y.Base.create('promoterView', Y.BaseView, [Y.FormExtension, Y.BookingsPromoterExtension,
            Y.PricingExtension, Y.ToolbarExtension, Y.UploadHelper], {

        events: {
            '.add-message'      : { click: 'addMessage' },
            '.update-gig'       : { click: 'updateGig' },
            '.update-artist-gig': { click: 'updateArtistGig' },
            '.cancel-update'    : { click: 'cancelUpdate' },
            '#gig-filter'       : { change: 'switchGigFilter' }
        },

        initializer: function() {
            this.log('Init');
            this.model = this.get('model');
            this.promoterMarkers = [];
            this.gigMarkers = [];
            this.clusterMarkers = [];
        },

        render: function() {
            this.log('Render');

            switch (this.get('action')) {
                case 'profile':
                    this.profile();
                    this.hideLoader();
                    break;
                case 'bookings':
                    Y.one('#menu-promoter-bookings').addClass('active');
                    this.bookings(this.get('id'));
                    break;
                case 'events':
                    Y.one('#menu-promoter-events').addClass('active');
                    this.eventList();
                    break;
                case 'trackings':
                    Y.one('#menu-promoter-trackings').addClass('active');
                    this.trackings();
                    break;
                case 'show':
                    this.show(this.get('id'), this.get('alias'));
                    break;
                default:
                    this.list();
                    this.model.after('promoter:list', Y.bind(function() {
                        this.map.setZoom(window.appConfig.params.listMapZoom);
                    }, this));
                    break;
            }
        },

        profile: function() {
            this.log('Show profile');

            // Extract the template string and compile it into a reusable function.
            var source      = Y.one('#t-promoter-profile').getHTML(),
                template    = Y.Handlebars.compile(source),
                data        = window.appConfig.user,
                container   = this.get('container'),
                html;

            // Render the template to HTML using the specified data.
            if (data.promoter) {
                data.latitude = data.promoter.latitude ? data.promoter.latitude : this.center.lat();
                data.longitude = data.promoter.longitude ? data.promoter.longitude : this.center.lng();
                data.radius = data.promoter.radius ? data.promoter.radius : this.radius;
            } else {
                data.latitude = this.center.lat();
                data.longitude = this.center.lng();
                data.radius = this.radius;
            }
            data.allowedTags = window.appConfig.allowedTags;
            html = template(data);

            // Append the rendered template to the page.
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

                container.all('.tab-pane').addClass('hidden');
                container.one('#' + target).removeClass('hidden');
                
                if (target == 'location') {
                    this.renderProfileMapControl();
                }

                if (target == 'payment') {
                    container.all('.buttons').addClass('hidden');
                } else {
                    container.all('.buttons').removeClass('hidden');
                }
            }, this), container, '.tab');

            // Init uploader and pricing table
            this.initUploader({ container: container });
            this.bindPricingEvents();
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
                icon: '/images/marker/m-promoter.png'
            });

            // User radius
            var radius = window.appConfig.user.promoter.radius,
                circle = new google.maps.Circle({
                    map: this.map,
                    radius: parseInt(radius),
                    editable: true,
                    fillColor: '#80CFFF',
                    strokeColor: "#0066A4",
                    strokeOpacity: 0.8,
                    strokeWeight: 2
                });
            circle.bindTo('center', marker, 'position');

            // Update user position with radius update
            google.maps.event.addListener(marker, 'dragend', function () {
                container.one('#latitude').set('value', this.getPosition().lat());
                container.one('#longitude').set('value', this.getPosition().lng());

                circle.setCenter(this.getPosition());

                // Update location field
                var geocoder = new google.maps.Geocoder();
                geocoder.geocode({ location: this.getPosition() }, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK && results.length) {
                        container.one('#address').set('value', results[0].formatted_address);
                    }
                });
            });

            // Update radius slider on map circle change
            google.maps.event.addListener(circle, 'radius_changed', function () {
                container.one('#radius').set('value', this.getRadius());
            });
        },

        bookings: function(id) {
            this.log('Show bookings');

            // Update model
            this.model.bookingList();

            // Update view internals
            this.model.once('booking:list', Y.bind(function () {
                this._renderBookings(id);
            }, this));

            this._bindPromoterEditEvents();
            this._bindPromoterSidebarEvents();
        },

        eventList: function() {
            this.log('Show events');

            // Update model
            this.model.events(0);

            // Update view internals
            this.model.once('events:list', Y.bind(function () {
                // Get events data
                var data = this.model.get('eventList'),
                    source   = Y.one('#t-promoter-events').getHTML(),
                    template = Y.Handlebars.compile(source),
                    container = this.get('container'),
                    html;

                // Add to container dashboard block
                html = template({ events: data });
                container.setHTML(html);

                // Init pagination
                this.get('container').one('#load-more-events').on('click', Y.bind(function(e) {
                    var button = e.target,
                        offset = button.getData('offset');

                    this.model.events(offset);

                    this.model.once('events:list', Y.bind(function() {
                        this.log('Events list updated');

                        // Extract the template string and compile it into a reusable function.
                        var source   = Y.one('#t-raw-event-list').getHTML(),
                            template = Y.Handlebars.compile(source),
                            html;

                        var options = { events: this.model.get('eventList') };

                        // Render the template to HTML using the specified data.
                        html = template(options);

                        // Append the rendered template to the page.
                        this.get('container').one('#load-more-events').insert(html, 'before');

                        // Update pagination offset
                        button.setData('offset', parseInt(offset) + 30)
                    }, this));
                }, this));
            }, this));
        },

        trackings: function() {
            this.log('Show trackings');

            // Update model
            this.model.trackings();

            // Update view internals
            this.model.once('trackings:list', Y.bind(function () {
                // Get events data
                var data = this.model.get('trackingList'),
                    source   = Y.one('#t-promoter-trackings').getHTML(),
                    template = Y.Handlebars.compile(source),
                    container = this.get('container'),
                    html;

                // Add to container dashboard block
                html = template(data);
                container.setHTML(html);
            }, this));
        },

        update: function(e) {
            this.log('Submit profile form');
            e.preventDefault();

            var form = this.get('container').one('#profile-form'),
                data = this.serializeToJSON(form);

            this.model.update(data);

            this.model.once('promoter:updated', Y.bind(function(e) {
                this.renderToolbar();
                this.showOverlay(e.message);
                window.app.showView('promoter', { action: 'profile' });
            }, this));

            this.model.once('promoter:update-errors', Y.bind(function(e) {
                this.highlightErrors(form, e.message, e.errors);
            }, this));
        },

        updateGig: function(e) {
            this.log('Submit gig form');
            e.preventDefault();

            var form = this.get('container').one('#gig-form form'),
                data = this.serializeToJSON(form);

            this.model.updateGig(data);

            this.model.once('gig:updated', Y.bind(function() {
                this._renderBookings(data.gig_id);
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

        cancelUpdate: function(e) {
            e.preventDefault();
            this._renderBookings(e.target.getData('rel'));
            return false;
        },

        list: function() {
            this.log('Show promoters');

            // Extract the template string and compile it into a reusable function.
            var self = this,
                source   = Y.one('#t-promoter-list').getHTML(),
                template = Y.Handlebars.compile(source),
                html;

            this.model.list();

            this.model.once('promoter:list', Y.bind(function() {
                this.log('Promoter list loaded');

                var options = { promoters: this.model.get('list') };

                // Render the template to HTML using the specified data.
                html = template(options);

                // Append the rendered template to the page.
                this.get('container').setHTML(html);

                // Load map
                this.loadPromoterMap(options);
            }, this));
        },

        loadPromoterMap: function(options) {
            this.log('Load promoter map');

            this.map = new google.maps.Map(document.getElementById('map'), window.appConfig.mapOptions);

            // Set artist markers on the map
            for (var i = 0; i < options.promoters.length; i++) {
                if (options.promoters[i].latitude && options.promoters[i].longitude) {
                    this.setPromoterMarker(options.promoters[i]);
                }
            }

            // Add clasterization
            //var mc = new MarkerClusterer(this.map, this.clusterMarkers, { gridSize: 100, maxZoom: 15 });

            // Set map center
            this.updateMapCenter(true, true);
        },

        setPromoterMarker: function(promoter) {
            if (parseFloat(promoter.latitude) && parseFloat(promoter.longitude)) {
                var position = new google.maps.LatLng(promoter.latitude, promoter.longitude),
                    marker   = new google.maps.Marker({
                        position: position,
                        title   : promoter.name,
                        map     : this.map,
                        icon    : '/images/marker/m-promoter.png'
                    });

                var source     = Y.one('#t-promoter-iw-block').getHTML(),
                    template   = Y.Handlebars.compile(source),
                    content    = template(promoter),
                    infowindow = new google.maps.InfoWindow({ content: content });

                google.maps.event.addListener(marker, 'click', Y.bind(function() {
                    // Close other windows
                    for (var i = 0; i < this.promoterMarkers.length; i++) {
                        this.promoterMarkers[i].infowindow.close();
                    }

                    infowindow.open(this.map, marker);
                }, this));

                this.promoterMarkers.push({
                    id          : promoter.id,
                    name        : promoter.name,
                    alias       : promoter.alias,
                    marker      : marker,
                    infowindow  : infowindow
                });

                this.clusterMarkers.push(marker);
            }
        },

        show: function (id, alias) {
            this.log('Show promoter #' + id + '; alias: ' + alias);

            // Extract the template string and compile it into a reusable function.
            var source      = Y.one('#t-promoter').getHTML(),
                container   = this.get('container'),
                template    = Y.Handlebars.compile(source),
                html;

            this.model.find({ id: id, alias: alias });

            this.model.once('promoter:404', Y.bind(function() {
                this.showOverlay('<div class="404">404: Could not find this page</div>');
                this.model.detachAll();
                this.list();
            }, this));

            this.model.once('promoter:show', Y.bind(function() {
                this.log('Promoter loaded');

                // Render promoter page
                var promoter = this.model.get('item'),
                    is_current = window.appConfig.user ? promoter.user_id == window.appConfig.user.id : false,
                    data = { promoter: promoter, is_current : is_current };

                html   = template(data);
                container.setHTML(html);

                // Render map
                setTimeout(Y.bind(this.renderPromoterProfileMapControl(data), this), 500);
            }, this));
        },

        renderPromoterProfileMapControl: function(data) {
            var container = this.get('container');

            // LatLon map
            var map, options = window.appConfig.mapOptions;

            if (parseFloat(data.promoter.latitude) && parseFloat(data.promoter.longitude)) {
                options.center = new google.maps.LatLng(data.promoter.latitude, data.promoter.longitude);
                map = new google.maps.Map(document.getElementById('promoter-profile-map'), options);

                // User marker
                var marker = new google.maps.Marker({
                    position: options.center,
                    map: map,
                    draggable: false,
                    title: data.promoter.name + ' current position',
                    icon: '/images/marker/m-promoter.png'
                });

                // User radius
                var radius = data.promoter.radius,
                    circle = new google.maps.Circle({
                        map: map,
                        radius: parseInt(radius),
                        editable: false,
                        fillColor: '#80CFFF',
                        strokeColor: "#0066A4",
                        strokeOpacity: 0.8,
                        strokeWeight: 2
                    });
                circle.bindTo('center', marker, 'position');
            } else {
                map = new google.maps.Map(document.getElementById('promoter-profile-map'), options);
            }

            // Add gigs to map
            for (var i = 0; i < data.promoter.gigs.length; i++) {
                if (parseFloat(gig.venue.latitude) && parseFloat(gig.venue.longitude)) {
                    var gig = data.promoter.gigs[i],
                        gigDate = Y.Date.parse(gig.date), icon;

                    // Create marker
                    icon = gig.isGigInRadius ? '/images/marker/m-gig-in-radius.png' : '/images/marker/m-gig.png';
                    marker = new MarkerWithLabel({
                        map: map,
                        position: new google.maps.LatLng(gig.venue.latitude, gig.venue.longitude),
                        title: gig.name + ' @ ' + gig.venue.name,
                        icon: icon,
                        labelClass: gig.isGigInRadius ? 'gigInRadiusLabel' : 'gigLabel',
                        labelContent: gig.is_multi ? 'x' + gig.is_multi : gig.label,
                        labelAnchor: new google.maps.Point(22, 33),
                        labelStyle: {opacity: 0.75}
                    });

                    // Compile marker info window
                    var source = Y.one('#t-gig-iw-block').getHTML(),
                        template = Y.Handlebars.compile(source),
                        content = template(gig),
                        infowindow = new google.maps.InfoWindow({content: content});

                    // Add marker click listener
                    google.maps.event.addListener(marker, 'click', Y.bind(function (infowindow, marker) {
                        // Close other windows
                        for (var i = 0; i < this.gigMarkers.length; i++) {
                            this.gigMarkers[i].infowindow.close();
                        }

                        // Open current infowindow
                        infowindow.open(map, marker);
                    }, this, infowindow, marker));

                    // Save marker to array
                    this.gigMarkers.push({
                        id: gig.id,
                        name: gig.name,
                        alias: gig.alias,
                        date: gig.date,
                        marker: marker,
                        infowindow: infowindow
                    });
                }
            }
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
                var source   = Y.one('#t-promoter-messages').getHTML(),
                    template = Y.Handlebars.compile(source);

                // Compile and show booking artists
                data.messages = this.model.get('messageList');
                this.get('container').one('#details').setHTML(template(data));

                // Check window height
                this.updateWindowHeight(true);
            }, this));
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
                    return new Y.PromoterModel();
                }
            },

            promoterMarkers: {
                value: null
            },

            gigMarkers: {
                value: null
            },

            clusterMarkers: {
                value: null
            },

            gigEditPanel: {
                value: null
            },

            artistGigEditPanel: {
                value: null
            }
        }
    });
},
'0.1',
{
    requires: [
        'json',
        'handlebars',
        'uploader',
        'base-view',
        'promoter-model',
        'form-extension',
        'toolbar-extension',
        'loader-extension',
        'bookings-promoter-extension',
        'pricing-extension',
        'upload-helper'
    ]
});
