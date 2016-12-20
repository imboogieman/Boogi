YUI.add('gig-view', function(Y) {

    'use strict';

    Y.GigView = Y.Base.create('gigView', Y.BaseView, [], {

        events: {
            '#filter': { click: 'list' }
        },

        initializer: function() {
            this.log('Init');
            this.model = this.get('model');
            this.markers = [];
            this.clusterMarkers = [];
            this.month = new Date();
        },

        render: function(e) {
            this.log('Render');

            switch (this.get('action')) {
                case 'show':
                    this.show(this.get('id'), this.get('alias'));
                    break;
                default:
                    this.list();
                    break;
            }
        },

        list: function() {
            this.log('Show gigs');

            // Extract the template string and compile it into a reusable function.
            var source   = Y.one('#t-gig-list').getHTML(),
                template = Y.Handlebars.compile(source),
                container = this.get('container'),
                html;

            // Get filtered data
            var params = {};
            if (container.one('#from_date') && container.one('#to_date')) {
                params = {
                    from_date : container.one('#from_date input').get('value'),
                    to_date   : container.one('#to_date input').get('value')
                };
            }
            this.model.list(params);

            this.model.once('gig:list', Y.bind(function() {
                this.log('Gig list loaded');

                var options = {
                    gigs    : this.model.get('list'),
                    params  : this.model.get('params')
                };

                // Render the template to HTML using the specified data.
                html = template(options);

                // Append the rendered template to the page.
                container.setHTML(html);

                // Load map
                this.loadMap(options);

                // Bind events
                container.all('.gig').on('click', Y.bind(function(e) {
                    e.preventDefault();
                    this.show(e.target.getData('id'), null);
                    this.map.setZoom(window.appConfig.params.itemMapZoom);
                }, this));

                // Bind calendars
                var calendar = new Y.CalendarWidget({
                    triggerNodes: '.calendar',
                    zIndex      : 1000
                });
                calendar.render();
            }, this));
        },

        loadMap: function(options) {
            this.log('Load gig map');

            this.map = new google.maps.Map(document.getElementById('map'), window.appConfig.mapOptions);

            // Set venue markers on the map
            for (var i = 0; i < options.gigs.length; i++) {
                if (options.gigs[i].venue.latitude && options.gigs[i].venue.longitude) {
                    this.setMarker(options.gigs[i]);
                }
            }

            // Add clasterization
            var mc = new MarkerClusterer(this.map, this.clusterMarkers, { gridSize: 100, maxZoom: 15 });

            // Set map center
            this.updateMapCenter(true, true);
        },

        setMarker: function(gig) {
            if (parseFloat(gig.venue.latitude) && parseFloat(gig.venue.longitude)) {
                var position = new google.maps.LatLng(gig.venue.latitude, gig.venue.longitude),
                    distance = google.maps.geometry.spherical.computeDistanceBetween(this.center, position),
                    marker = new MarkerWithLabel({
                        position: position,
                        map: this.map,
                        title: gig.name + ' @ ' + gig.venue.name,
                        icon: (distance < this.radius) ? '/images/marker/m-gig-in-radius.png' : '/images/marker/m-gig.png',
                        labelContent: gig.is_multi ? 'x' + gig.is_multi : gig.label,
                        labelAnchor: new google.maps.Point(22, 33),
                        labelClass: (distance < this.radius) ? 'gigInRadiusLabel' : 'gigLabel',
                        labelStyle: {opacity: 0.75}
                    });

                var source = Y.one('#t-gig-iw-block').getHTML(),
                    template = Y.Handlebars.compile(source),
                    content = template(gig),
                    infowindow = new google.maps.InfoWindow({content: content});

                google.maps.event.addListener(marker, 'click', Y.bind(function () {
                    // Close other windows
                    for (var i = 0; i < this.markers.length; i++) {
                        this.markers[i].infowindow.close();
                    }

                    // Open current
                    infowindow.open(this.map, marker);
                }, this));

                this.markers.push({
                    id: gig.id,
                    name: gig.name,
                    alias: gig.alias,
                    date: gig.date,
                    marker: marker,
                    infowindow: infowindow
                });

                this.clusterMarkers.push(marker);
            }
        },

        show: function (id, alias) {
            this.log('Show gig #' + id + ' / ' + alias);

            this.model.find({ id: id, alias: alias });

            this.model.once('gig:show', Y.bind(function(e) {
                if (e.data.bookings.length) {
                    window.app.showView('artist', { action: 'show', id: e.data.bookings[0].artist_id, gig: e.data });
                } else {
                    window.app.showView('site', { action: '404' });
                }
            }, this));

            this.model.once('gig:not-found', Y.bind(function(e) {
                window.app.showView('site', { action: '404' });
            }, this));

            /**
             * @TODO: Replace when gig page will be created
            for (var i = 0; i < this.markers.length; i++) {
                if ((id && this.markers[i].id == id) || (alias && this.markers[i].alias == alias)) {
                    // Open marker infowindow
                    this.markers[i].infowindow.open(this.map, this.markers[i].marker);

                    // Pan map to this marker
                    this.map.setZoom(window.appConfig.params.itemMapZoom);
                    this.map.panTo(this.markers[i].marker.getPosition());
                } else {
                    this.markers[i].infowindow.close();
                }
            }
            */
        }

    }, {
        ATTRS: {
            model: {
                valueFn: function () {
                    return new Y.GigModel();
                }
            },

            markers: {
                value: null
            },

            clusterMarkers: {
                value: null
            },

            month: {
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
        'base-view',
        'gig-model',
        'loader-extension'
    ]
});
