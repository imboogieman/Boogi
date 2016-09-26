YUI.add('toolbar-extension', function (Y) {

    Y.ToolbarExtension = function () {

        this.renderToolbar = function() {
            // Extract the template string and compile it into a reusable function.
            var source = Y.one('#t-menu').getHTML(),
                template = Y.Handlebars.compile(source),
                data = this.getToolbarUserData();

            // Update menu block with the rendered template
            Y.one('#menu-block').setHTML(template(data));

            this.bindUserMenu();
            this.bindSearch();
            this.bindFixedScroll();
        };

        this.bindUserMenu = function() {
            if (window.appConfig.user) {
                var source = Y.one('#t-user-menu').getHTML(),
                    template = Y.Handlebars.compile(source),
                    data = this.getToolbarUserData(),
                    selector = Y.one('#show-user-menu'),
                    popover = new Y.Popover({
                        align: {
                            node        : selector,
                            points      : [Y.WidgetPositionAlign.TC, Y.WidgetPositionAlign.BL]
                        },
                        bodyContent     : template(data),
                        headerContent   : 'User menu',
                        position        : 'bottom',
                        zIndex          : 100,
                        render          : true,
                        visible         : false,
                        cssClass        : 'user-menu'
                    });

                selector.on('click', function () {
                    popover.set('visible', !popover.get('visible'));
                });

                selector.on('clickoutside', function () {
                    popover.set('visible', false);
                });

                Y.on('toolbar:hide', function () {
                    popover.set('visible', false);
                });
            }
        };

        this.bindSearch = function() {
            var search = new Y.SearchExtension;
            search.bindToolbarSearch();
        };

        this.bindFixedScroll = function () {
            Y.on('scroll', Y.bind(function() {
                var width = Y.one('body').get('winWidth'),
                    offset = 0 - window.scrollX;

                if (width < 960) {
                    Y.one('#menu').setStyle('left', offset);
                } else {
                    Y.one('#menu').setStyle('left', 0);
                }
            }, this));
        };

        this.getToolbarUserData = function () {
            var data = {
                    is_user         : 0,
                    user_role       : 0,
                    role_promoter   : 1,
                    role_artist     : 2,
                    is_admin        : 0,
                    admin_url       : ''
                };

            if (window.appConfig.user) {
                data.is_user = 1;
                data.is_admin = window.appConfig.user.is_admin;
                data.admin_url = window.appConfig.user.is_admin ?  window.appConfig.params.adminUrl : '';

                if (window.appConfig.user.role == 2) {
                    data.user_role = 2;
                    data.booking_link = '/artist/bookings';
                    data.user_name = window.appConfig.user.artist.name;
                    data.user_image = window.appConfig.user.artist.image;
                    data.user_type = 'Artist';
                } else {
                    data.user_role = 1;
                    data.booking_link = '/promoter/bookings';
                    data.user_name = window.appConfig.user.promoter.name;
                    data.user_image = window.appConfig.user.promoter.image;
                    data.user_type = 'Promoter';
                }
            }

            return data;
        }

    };

},
'0.1',
{
    requires: [
        'node',
        'handlebars',
        'aui-popover',
        'search-extension'
    ]
});
