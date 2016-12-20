YUI.add('base-app', function(Y) {

    'use strict';

    Y.BaseApp = Y.Base.create('baseApp', Y.App, [Y.LogExtension, Y.LoaderExtension, Y.OverlayExtension,
        Y.ToolbarExtension, Y.RouterExtension, Y.FollowExtension], {

        views: {
            user     : { type: 'UserView' },
            artist   : { type: 'ArtistView' },
            promoter : { type: 'PromoterView' },
            gig      : { type: 'GigView' },
            venue    : { type: 'VenueView' },
            site     : { type: 'SiteView' }
        },

        transitions: true,

        initializer: function() {
            this.log('Init application');

            // Init router
            this.initRouter();

            // Bind global functions
            this.bindGlobalFunctions();

            // Register Handlebar helpers
            this.registerHandlebarHelpers();

            // Render application
            this.renderApplication();
        },

        bindGlobalFunctions: function() {
            this.log('Register global functions');

            // More visual clearance
            var config = window.appConfig;

            // Make global base application
            window.app = this;

            // Date formats
            window.app.dtFormat = {
                date: {
                    edit   : '%d.%m.%Y',
                    print  : '%b, %e %Y',
                    iso    : '%Y-%m-%d'
                },
                time: {
                    edit   : '%l:%M %P',
                    print  : '%l:%M %P',
                    iso    : '%H:%M:%S'
                },
                full: {
                    print: '%b, %e %Y %l:%M %P'
                }
            };

            // Get book status Id by name
            window.app.getStatus = function(status) {
                var current;
                for (var i = 0; i < config.bookStatuses.length; i++) {
                    current = config.bookStatuses[i];
                    if (current.name.toLowerCase().trim() == status.toLowerCase().trim()) {
                        return current.id;
                    }
                }
                return 0;
            };

            // Get VA string by ID
            window.app.getVAStringById = function(type, id) {
                var options = config.venueAttrs[type];
                for (var i = 0; i < options.length; i++) {
                    if (options[i].id == id) {
                        return options[i].name;
                    }
                }
                return null;
            };

            // Get currency symbol by ID
            window.app.getCurrencySymbolById = function(id) {
                if (id == 2) return '&euro;';
                return '$'
            };

            // Get currency symbol by ID
            window.app.getTZInfoById = function(name) {
                for (var i = 0; i < config.tzInfo.length; i++) {
                    if (config.tzInfo[i].name == name) {
                        return config.tzInfo[i];
                    }
                }
                return window.appConfig.defaultTZ;
            };

            // Get timepickers data
            window.app.getTimepickerData = function() {
                var result = [], date;
                for (var i = 0; i < 48; i++) {
                    date = new Date(1970, 0, 0, 0, 0, 0, 0);
                    date.setMinutes(i * 30);
                    result.push(Y.Date.format(date, { format: window.app.dtFormat.time.print }));
                }
                return result;
            };

            // Google Analytics Tracker
            window.app.track = function(category, action, label, value) {
                if (!config.enableStats) return;

                return ga('send', 'event', {
                    'eventCategory'   : category,
                    'eventAction'     : action,
                    'eventLabel'      : label,
                    'eventValue'      : value
                });
            };

            // Get Plan name by Id
            window.app.getPlan = function(plan) {
                if (plan == 1) {
                    return 'PromoOne';
                } else if (plan == 2) {
                    return 'PromoStar';
                }
                return 'Demo';
            };
        },

        registerHandlebarHelpers: function () {
            this.log('Register Handlebar helpers');

            // Helper for dashboard events
            Y.Handlebars.registerHelper('listWithHeaders', function (context, options) {
                var headerField = 'date',
                    header,
                    fnFalse = options.inverse;

                if (context && context.length > 0) {
                    return context.map(function (item) {
                        var html = '', current,
                            today = Y.Date.format(new Date, {format: window.app.dtFormat.date.iso});

                        if (header != item[headerField]) {
                            current = Y.Date.parse(item[headerField]);
                            current = Y.Date.format(current, {format: window.app.dtFormat.date.iso});

                            if (current == today) {
                                html += '<div class="clear"></div>';
                                html += '<h3 class="today">Today</h3>';
                            } else {
                                html += '<div class="clear"></div>';
                                html += '<h3>' + item[headerField] + '</h3>';
                            }
                        }

                        html += options.fn(item);
                        header = item[headerField];

                        return html;
                    }).join("\n");
                } else {
                    return fnFalse();
                }
            });

            Y.Handlebars.registerHelper('isEven', function (conditional, options) {
                if ((conditional % 2) == 0) {
                    return options.fn(this);
                } else {
                    return options.inverse();
                }
            });

            Y.Handlebars.registerHelper('json', function (obj) {
                return JSON.stringify(obj);
            });

            Y.Handlebars.registerHelper('ifCond', function (v1, v2, options) {
                if (v1 == v2) {
                    return options.fn(this);
                }
                return options.inverse(this);
            });

            Y.Handlebars.registerHelper('ifNotCond', function (v1, v2, options) {
                if (v1 != v2) {
                    return options.fn(this);
                }
                return options.inverse(this);
            });

            Y.Handlebars.registerHelper('formatTime', function (datetime, format) {
                format = window.app.dtFormat.time[format] || format;
                datetime = Y.Date.parse(datetime);
                return Y.Date.format(datetime, { format: format });
            });

            Y.Handlebars.registerHelper('formatDate', function (datetime, format) {
                format = window.app.dtFormat.date[format] || format;
                datetime = Y.Date.parse(datetime);
                return Y.Date.format(datetime, { format: format });
            });

            Y.Handlebars.registerHelper('formatDateRange', function (from, to) {
                from = Y.Date.parse(from);
                to = Y.Date.parse(to);

                var from_date = Y.Date.format(from, { format: window.app.dtFormat.date.iso }),
                    to_date = Y.Date.format(to, { format: window.app.dtFormat.date.iso }),
                    result;

                if (from_date == to_date) {
                    result = Y.Date.format(from, { format: window.app.dtFormat.time.print });
                    result += ' - ';
                    result += Y.Date.format(to, { format: window.app.dtFormat.time.print });
                    result += ' / ';
                    result += Y.Date.format(from, { format: window.app.dtFormat.date.print });
                } else {
                    result = Y.Date.format(from, { format: window.app.dtFormat.full.print });
                    result += ' - ';
                    result += Y.Date.format(to, { format: window.app.dtFormat.full.print });
                }
                return result;
            });
        },

        registerHandlebarPartials: function() {
            Y.Array.each([
                'features', 'footer', 'pricing', 'statuses',
                'artist-booking', 'promoter-booking', 'promoter-profile-booking', 'promoter-profile-booking-past'
            ], function(name) {
                Y.Handlebars.registerPartial(name, Y.one('#t-' + name + '-partial').getHTML());
            });
        },

        renderApplication: function() {
            this.log('Render base app');

            // Ready state
            this.once('ready', Y.bind(function () {
                this.log('App ready');

                // Show default view
                var route = window.location.pathname;
                if (this.router && this.router.hasRoute(route)) {
                    this.router.save(route);
                } else if (window.appConfig.user) {
                    // Show artist list
                    this.showView('artist');
                } else {
                    // Show site index
                    this.showView('site');
                }

                // Render toolbar and user menu
                this.renderToolbar();

                // Register partial templates
                this.registerHandlebarPartials();

                // Bind events
                this.bindEvents();
            }, this));
        },

        bindEvents: function () {
            this.log('Bind base events');

            // Init follow events
            this.initFollowEvents();

            // Fix router links
            Y.delegate('click', Y.bind(function(e) {
                var link = e.currentTarget.get('href'),
                    route = link ? this.router.removeRoot(link) : false;

                // Skip external links
                if (e.currentTarget.hasClass('external')) {
                    return true;
                }

                // Skip control clicks
                if (e.button !== 1 || e.ctrlKey || e.metaKey) {
                    return;
                }

                // Check router
                if (route && this.router.hasRoute(route)) {
                    e.preventDefault();

                    this.hideOverlay();
                    this.router.save(route);

                    return false;
                }
            }, this), 'body', 'a');

            // Run live data keeper
            if (window.appConfig.params.liveToolbar) {
                setInterval(Y.bind(function () {
                    var model = this.get('model');
                    model.live()
                }, this), 5000);
            }
        }

    }, {
        ATTRS: {

            router: {
                value: null
            },

            model: {
                valueFn: function () {
                    return new Y.BaseModel();
                }
            }
        }
    });
},
'0.1',
{
    requires: [
        'app',
        'plugin',
        'base-model',
        'user-view',
        'artist-view',
        'promoter-view',
        'gig-view',
        'venue-view',
        'site-view',
        'overlay-extension',
        'log-extension',
        'toolbar-extension',
        'loader-extension',
        'follow-extension',
        'router-extension'
    ]
});
