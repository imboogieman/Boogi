YUI.add('venue-view', function(Y) {

    'use strict';

    Y.VenueView = Y.Base.create('venueView', Y.BaseView, [], {

        initializer: function() {
            this.log('Init');
            this.model = this.get('model');
            this.venueMarkers = [];
            this.clusterMarkers = [];
        },

        render: function(e) {
            this.log('Render');

            switch (this.get('action')) {
                case 'show':
                    this.list();
                    this.model.after('venue:list', Y.bind(function() {
                        this.show(this.get('id'), this.get('alias'));
                        this.map.setZoom(window.appConfig.params.itemMapZoom);
                    }, this));
                    break;
                default:
                    this.list();
                    this.model.after('venue:list', Y.bind(function() {
                        this.map.setZoom(window.appConfig.params.listMapZoom);
                    }, this));
                    break;
            }
        },

        list: function() {
            this.log('Show venues');

            // Extract the template string and compile it into a reusable function.
            var source   = Y.one('#t-venue-list').getHTML(),
                template = Y.Handlebars.compile(source),
                html;

            this.model.list();

            this.model.once('venue:list', Y.bind(function() {
                this.log('Venue list loaded');

                var options = { venues: this.model.get('list') };

                // Render the template to HTML using the specified data.
                html = template(options);

                // Append the rendered template to the page.
                this.get('container').setHTML(html);

                // Load map
                this.loadMap(options);

                // Bind clicks
                this.get('container').all('.venue').on('click', Y.bind(function(e) {
                    e.preventDefault();
                    this.map.setZoom(window.appConfig.params.itemMapZoom);
                    this.show(e.target.getData('id'), null);
                }, this));
            }, this));
        },

        loadMap: function(options) {
            this.log('Load venue map');

            this.map = new google.maps.Map(document.getElementById('map'), window.appConfig.mapOptions);

            // Set venue markers on the map
            for (var i = 0; i < options.venues.length; i++) {
                if (options.venues[i].latitude && options.venues[i].longitude) {
                    this.setMarker(options.venues[i]);
                }
            }

            // Add clasterization
            //var mc = new MarkerClusterer(this.map, this.clusterMarkers, { gridSize: 100, maxZoom: 15 });

            // Set map center
            this.updateMapCenter(true, true);
        },

        setMarker: function(venue) {
            if (parseFloat(venue.latitude) && parseFloat(venue.longitude)) {
                var position = new google.maps.LatLng(venue.latitude, venue.longitude),
                    marker   = new google.maps.Marker({
                        position: position,
                        title   : venue.name,
                        map     : this.map,
                        icon    : '/images/marker/m-venue.png'
                    });

                var source     = Y.one('#t-venue-iw-block').getHTML(),
                    template   = Y.Handlebars.compile(source),
                    content    = template(venue),
                    infowindow = new google.maps.InfoWindow({ content: content });

                google.maps.event.addListener(marker, 'click', Y.bind(function() {
                    // Close other windows
                    for (var i = 0; i < this.venueMarkers.length; i++) {
                        this.venueMarkers[i].infowindow.close();
                    }

                    infowindow.open(this.map, marker);
                }, this));

                this.venueMarkers.push({
                    id          : venue.id,
                    name        : venue.name,
                    alias       : venue.alias,
                    marker      : marker,
                    infowindow  : infowindow
                });

                this.clusterMarkers.push(marker);
            }
        },

        show: function (id, alias) {
            this.log('Show venue #' + id + ' / ' + alias);

            for (var i = 0; i < this.venueMarkers.length; i++) {
                if ((id && this.venueMarkers[i].id == id) || (alias && this.venueMarkers[i].alias == alias)) {
                    // Open marker infowindow
                    this.venueMarkers[i].infowindow.open(this.map, this.venueMarkers[i].marker);

                    // Pan map to this marker
                    this.map.panTo(this.venueMarkers[i].marker.getPosition());
                } else {
                    this.venueMarkers[i].infowindow.close();
                }
            }
        }


    }, {
        ATTRS: {
            model: {
                valueFn: function () {
                    return new Y.VenueModel();
                }
            },

            venueMarkers: {
                value: null
            },

            clusterMarkers: {
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
        'venue-model'
    ]
});
