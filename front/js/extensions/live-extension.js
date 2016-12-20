YUI.add('live-extension', function (Y) {

    Y.LiveExtension = function () {

        this.processLiveData = function(response) {
            this.log('Process live data');

            if (window.appConfig.user) {
                Y.one('#menu-updates').removeClass('hidden');

                var selector = Y.one('#promoter-booking-updates'),
                    all_link = '/promoter/events';

                if (window.appConfig.user.role == 2) {
                    selector = Y.one('#artist-booking-updates');
                    all_link = '/artist/events'
                }

                if (response.events.length) {
                    var source      = Y.one('#t-event-list').getHTML(),
                        template    = Y.Handlebars.compile(source),
                        data = {
                            events_count: response.events.length,
                            events      : response.events
                        };

                    // Show counter
                    selector.setHTML('<div id="counter">' + response.events.length + '</div>').removeClass('hidden');

                    // Create toolbar on first call
                    if (!window.app.liveToolbar) {
                        window.app.liveToolbar = new Y.Popover({
                            align: {
                                node        : selector,
                                points      :[Y.WidgetPositionAlign.TC, Y.WidgetPositionAlign.BC]
                            },
                            bodyContent     : template(data),
                            headerContent   : 'Notifications',
                            footerContent   : '<a href="' + all_link + '" class="see-all">See all...</a>',
                            position        : 'bottom',
                            zIndex          : 100,
                            render          : true,
                            visible         : false
                        });

                        // Bind actions
                        selector.on('click', Y.bind(function() {
                            window.app.liveToolbar.set('visible', !window.app.liveToolbar.get('visible'));
                        }, this));

                        selector.on('clickoutside', Y.bind(function() {
                            window.app.liveToolbar.set('visible', false);
                        }, this));

                        Y.on('toolbar:hide', Y.bind(function () {
                            window.app.liveToolbar.set('visible', false);
                        }, this));
                    }

                    // Append new content
                    window.app.liveToolbar.bodyNode.html(template(data));
                } else {
                    selector.addClass('hidden');
                }
            }
        };

    };

},
'0.1',
{
    requires: [
        'aui-popover'
    ]
});
