YUI({
    combine : true,
    modules :  {
        'base-app': {
            fullpath: '/js/base-app.js'
        },
        'base-view': {
            fullpath: '/js/base-view.js'
        },
        'base-model': {
            fullpath: '/js/base-model.js'
        },
        'user-view': {
            fullpath: '/js/views/user-view.js'
        },
        'user-model': {
            fullpath: '/js/models/user-model.js'
        },
        'promoter-view': {
            fullpath: '/js/views/promoter-view.js'
        },
        'promoter-model': {
            fullpath: '/js/models/promoter-model.js'
        },
        'artist-view': {
            fullpath: '/js/views/artist-view.js'
        },
        'artist-model': {
            fullpath: '/js/models/artist-model.js'
        },
        'gig-view': {
            fullpath: '/js/views/gig-view.js'
        },
        'gig-model': {
            fullpath: '/js/models/gig-model.js'
        },
        'venue-view': {
            fullpath: '/js/views/venue-view.js'
        },
        'venue-model': {
            fullpath: '/js/models/venue-model.js'
        },
        'site-view': {
            fullpath: '/js/views/site-view.js'
        },
        'log-extension': {
            fullpath: '/js/extensions/log-extension.js'
        },
        'live-extension': {
            fullpath: '/js/extensions/live-extension.js'
        },
        'form-extension': {
            fullpath: '/js/extensions/form-extension.js'
        },
        'loader-extension': {
            fullpath: '/js/extensions/loader-extension.js'
        },
        'calendar-extension': {
            fullpath: '/js/extensions/calendar-extension.js'
        },
        'overlay-extension': {
            fullpath: '/js/extensions/overlay-extension.js'
        },
        'router-extension': {
            fullpath: '/js/extensions/router-extension.js'
        },
        'map-extension': {
            fullpath: '/js/extensions/map-extension.js'
        },
        'book-form-extension': {
            fullpath: '/js/extensions/book-form-extension.js'
        },
        'bookings-artist-extension': {
            fullpath: '/js/extensions/bookings-artist-extension.js'
        },
        'bookings-promoter-extension': {
            fullpath: '/js/extensions/bookings-promoter-extension.js'
        },
        'genres-extension': {
            fullpath: '/js/extensions/genres-extension.js'
        },
        'toolbar-extension': {
            fullpath: '/js/extensions/toolbar-extension.js'
        },
        'search-extension': {
            fullpath: '/js/extensions/search-extension.js'
        },
        'pricing-extension': {
            fullpath: '/js/extensions/pricing-extension.js'
        },
        'follow-extension': {
            fullpath: '/js/extensions/follow-extension.js'
        },
        'base-helper': {
            fullpath: '/js/helpers/base-helper.js'
        },
        'upload-helper': {
            fullpath: '/js/helpers/upload-helper.js'
        }
    }
}).use('base-app', function(Y) {
    // Init application
    window.app = new Y.BaseApp();
    window.app.render();
});