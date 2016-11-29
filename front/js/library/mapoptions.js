// Default map options
window.appConfig.mapOptions = {
    center              : new google.maps.LatLng(
        window.appConfig.params.defaultPosition.latitude,
        window.appConfig.params.defaultPosition.longitude
    ),
    zoom                : window.appConfig.params.listMapZoom,
    mapTypeId           : google.maps.MapTypeId.ROADMAP,
    mapTypeControl      : true,
    panControl          : false,
    zoomControl         : true,
    scaleControl        : false,
    streetViewControl   : false,
    mapTypeControlOptions   : {
        style       : google.maps.MapTypeControlStyle.DROPDOWN_MENU,
        position    : google.maps.ControlPosition.RIGHT_BOTTOM
    },
    zoomControlOptions  : {
        style       : google.maps.ZoomControlStyle.LARGE,
        position    : google.maps.ControlPosition.RIGHT_CENTER
    }
};