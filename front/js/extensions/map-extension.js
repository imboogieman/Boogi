YUI.add('map-extension', function (Y) {

    Y.MapExtension = function () {

        this.updateMapParams = function () {
            var config = window.appConfig,
                latitude, longitude, radius;

            // Set default location
            if (config.user) {
                if (config.user.role == 1) {
                    latitude = parseFloat(config.user.promoter.latitude);
                    longitude = parseFloat(config.user.promoter.longitude);
                    radius = parseInt(config.user.promoter.radius);
                } else {
                    latitude = parseFloat(config.user.artist.latitude);
                    longitude = parseFloat(config.user.artist.longitude);
                }
            }

            // Try to use google API to get user location
            if (!latitude || !longitude) {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        latitude  = position.coords.latitude;
                        longitude = position.coords.longitude;

                        Y.Cookie.set('latitude', latitude);
                        Y.Cookie.set('longitude', longitude);
                    });
                }
            }

            // Check defaults
            if (!latitude || !longitude) {
                latitude = parseFloat(config.params.defaultPosition.latitude);
                longitude = parseFloat(config.params.defaultPosition.longitude);
            }
            if (!radius) {
                radius = parseInt(config.params.defaultPosition.radius);
            }

            // Update globals
            this.center = new google.maps.LatLng(latitude, longitude);
            this.radius = radius;
            this.offsetCenter = { x: -200, y: 0 };
        };

        this.panMapToGigMarkersCenter = function (selected_gig) {
            if (selected_gig && selected_gig.venue &&
                selected_gig.venue.latitude && selected_gig.venue.longitude) {
                    // Pan map to open gig
                    this.map.panTo(
                        new google.maps.LatLng(selected_gig.venue.latitude, selected_gig.venue.longitude)
                    );
                    this.map.panBy(this.offsetCenter.x, this.offsetCenter.y);
            }

            if (this.gigMarkers && this.gigMarkers.length > 0) {
                var maxRadius = 2000000, distance = 0,
                    allBounds = new google.maps.LatLngBounds(),
                    inRadiusBounds = new google.maps.LatLngBounds(),
                    inRadiusBoundsCount = 0,
                    northEastBounds = new google.maps.LatLngBounds(),
                    northEastBoundsCount = 0,
                    southWestBounds = new google.maps.LatLngBounds(),
                    southWestCount = 0;

                // Get bounds
                for (var i = 0; i < this.gigMarkers.length; i++) {
                    allBounds.extend(this.gigMarkers[i].marker.position);
                }

                // Get bounds
                for (var i = 0; i < this.gigMarkers.length; i++) {
                    // Center bounds
                    distance = google.maps.geometry.spherical.computeDistanceBetween(
                        allBounds.getCenter(), this.gigMarkers[i].marker.position
                    );
                    if (distance < maxRadius) {
                        inRadiusBounds.extend(this.gigMarkers[i].marker.position);
                        inRadiusBoundsCount++;
                    }

                    // North East bounds
                    distance = google.maps.geometry.spherical.computeDistanceBetween(
                        allBounds.getNorthEast(), this.gigMarkers[i].marker.position
                    );
                    if (distance < maxRadius) {
                        northEastBounds.extend(this.gigMarkers[i].marker.position);
                        northEastBoundsCount++;
                    }

                    // South West bounds
                    distance = google.maps.geometry.spherical.computeDistanceBetween(
                        allBounds.getSouthWest(), this.gigMarkers[i].marker.position
                    );
                    if (distance < maxRadius) {
                        southWestBounds.extend(this.gigMarkers[i].marker.position);
                        southWestCount++;
                    }
                }

                if (inRadiusBoundsCount) {
                    this.map.panTo(inRadiusBounds.getCenter());
                    this.map.panBy(this.offsetCenter.x, this.offsetCenter.y);
                } else if (northEastBoundsCount || southWestCount) {
                    if (northEastBoundsCount > southWestCount) {
                        this.map.panTo(northEastBounds.getCenter());
                    } else {
                        this.map.panTo(southWestBounds.getCenter());
                    }
                    this.map.panBy(this.offsetCenter.x, this.offsetCenter.y);
                }
            }
        };

        // @TODO: Debug exceptions
        this.updateMapCenter = function(panToCenter, showRadius) {
            this.log('Update map center');

            // Update map params from config
            this.updateMapParams();

            // Center map and shift away from panels
            if (panToCenter) {
                this.map.panTo(this.center);
                this.map.panBy(this.offsetCenter.x, this.offsetCenter.y);
            }

            // Destroy old circle
            this.userMarker && this.userMarker.setMap(null);

            // Show user icon
            var marker = new google.maps.Marker({
                position: this.center,
                map     : this.map,
                title   : 'You',
                icon    : '/images/marker/m-promoter.png'
            });

            this.userMarker = marker;

            // Show radius overlay
            if (showRadius) {
                // Destroy old circle
                this.radiusCircle && this.radiusCircle.setMap(null);

                // Add new
                var circle = new google.maps.Circle({
                    map             : this.map,
                    radius          : parseInt(this.radius),
                    fillColor       : '#80CFFF',
                    strokeColor     : "#0066A4",
                    strokeOpacity   : 0.8,
                    strokeWeight    : 2
                });

                circle.bindTo('center', marker, 'position');
                this.radiusCircle = circle;
            }
        }
    }
},
'0.1',
{
    requires: [
        'cookie'
    ]
});
