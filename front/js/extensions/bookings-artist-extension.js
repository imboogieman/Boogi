YUI.add('bookings-artist-extension', function (Y) {

    Y.BookingsArtistExtension = function () {

        this._bindArtistSidebarEvents = function() {
            var container = this.get('container');

            Y.delegate('click', Y.bind(function(e) {
                e.stopPropagation();
                Y.fire('toolbar:hide');

                // Check chat view state
                this._showCurrentChat(container, e.target);

                // Compile params
                var data = {
                    gig_id      : e.target.getData('gig-id'),
                    artist_id   : e.target.getData('artist-id'),
                    is_past     : e.target.ancestor('.booking').hasClass('past')
                };

                // Get messages from server
                this.model.messages(data);

                // Update view internals
                this.model.once('messages:list', Y.bind(function () {
                    var source   = Y.one('#t-artist-messages').getHTML(),
                        template = Y.Handlebars.compile(source);

                    // Compile and show messages
                    data.messages = this.model.get('messageList');
                    container.one('#details').setHTML(template(data));

                    // Update window height and messages list height
                    this.updateWindowHeight(true);
                }, this));

                // Update view internals
                this.model.once('messages:empty', Y.bind(function () {
                    var source   = Y.one('#t-artist-messages').getHTML(),
                        template = Y.Handlebars.compile(source);

                    // Compile and show messages
                    container.one('#details').setHTML(template(data));

                    // Update window height and messages list height
                    this.updateWindowHeight(true);
                }, this));

                return false;
            }, this), container, '.chat');

            Y.delegate('click', Y.bind(function(e) {
                e.stopPropagation();
                Y.fire('toolbar:hide');

                // Compile params
                var block    = e.target,
                    source   = Y.one('#t-artist-booking-details').getHTML(),
                    template = Y.Handlebars.compile(source),
                    data     = this.model.getArtistGig(block.getData('id'));

                // Compile and show booking details
                container.one('#details').setHTML(template(data));

                // Check booking view state
                this._showCurrentBooking(container, block);
                this.updateWindowHeight();

                return false;
            }, this), container, '.details');

            Y.delegate('click', Y.bind(function(e) {
                // Compile params
                var block    = e.target.hasClass('booking') ? e.target : e.target.ancestor('.booking'),
                    source   = Y.one('#t-artist-gig-details').getHTML(),
                    template = Y.Handlebars.compile(source),
                    data     = this.model.getArtistGig(block.getData('id'));

                // Compile and show booking details
                container.one('#details').setHTML(template(data));

                // Init Gig map and show gig
                this._initGigMap(data);
                this._showCurrentGig(container, block);
                this.updateWindowHeight();

                return false;
            }, this), container, '.booking');
        };

        this._initGigMap = function(data) {
            if (!data || !data.venue) {
                return;
            }

            var lat = parseFloat(data.venue.latitude),
                lon = parseFloat(data.venue.longitude),
                options = window.appConfig.mapOptions,
                map, marker;

            if (lat && lon) {
                // Update map center
                options.center = new google.maps.LatLng(lat, lon);
                map = new google.maps.Map(document.getElementById('map'), options);

                // User marker
                marker = new google.maps.Marker({
                    position: options.center,
                    map     : map,
                    title   : data.name,
                    icon    : '/images/marker/m-artist.png'
                });
            }
        };

        this._bindArtistEditEvents = function() {
            var container = this.get('container');

            // Init artist edit buttons
            Y.delegate('click', Y.bind(function(e) {
                e.preventDefault();

                var source   = Y.one('#t-artist-book-form').getHTML(),
                    template = Y.Handlebars.compile(source),
                    data     = this.model.getArtistGig(e.target.getData('id'));

                // Set content and show panel
                data.venueAttrs = window.appConfig.venueAttrs;
                container.one('#details').setHTML(template(data));

                // Render controls
                this.renderDatePickers();
                this.renderTZPicker();
                this.updateWindowHeight();

                return false;
            }, this), container, '.edit-booking');

            // Init artist edit buttons
            Y.delegate('click', Y.bind(function(e) {
                e.preventDefault();

                var gig_id = e.target.getData('gig-id'),
                    artist_id = e.target.getData('artist-id'),
                    status = e.target.getData('status');

                this.model.updateStatus({
                    gig_id      : gig_id,
                    artist_id   : artist_id,
                    status      : status
                });

                this.model.once('status:updated', Y.bind(function () {
                    this._renderBookings(gig_id + '-' + artist_id);
                }, this));
                return false;
            }, this), container, '.update-status');

            // Init booking edit calc
            Y.delegate('change', Y.bind(function(e) {
                this.calculateBookingRevenue();
            }, this), container, '#book-form #price, #revenue_share');
        };

        this._renderBookings = function(open_id) {
            // Extract the template string and compile it into a reusable function.
            var source = Y.one('#t-artist-bookings').getHTML(),
                template = Y.Handlebars.compile(source),
                container = this.get('container'),
                data = this.model.get('bookingList'),
                block, first_block, open_block, html;

            // Add to container bookings block
            html = template({
                active          : data.active,
                past            : data.past,
                show_past_label : data.show_past_label,
                venueAttrs      : window.appConfig.venueAttrs
            });
            container.setHTML(html);

            // Compile and show opened gig
            first_block = container.one('.booking');
            open_block = container.one('#' + open_id);
            if (first_block || open_block) {
                open_id = open_block ? open_block.get('id') : first_block.get('id');
                block = open_block ? open_block : first_block;

                // If single Id then compiling Gig
                if (open_id.split('-').length == 1) {
                    source = Y.one('#t-artist-gig-details').getHTML();
                    template = Y.Handlebars.compile(source);

                    data = this.model.getArtistGig(block.getData('id'));
                    container.one('#details').setHTML(template(data));

                    this._initGigMap(data);
                    this._showCurrentGig(container, block);
                } else {
                    source = Y.one('#t-artist-booking-details').getHTML();
                    template = Y.Handlebars.compile(source);

                    data = this.model.getArtistGig(block.getData('id'));
                    container.one('#details').setHTML(template(data));

                    this._showCurrentBooking(container, block);
                }

                // Check past tab
                if (data.is_past) {
                    container.all('.gig-list').addClass('hidden');
                    container.one('#gig-filter').set('value', 'past');
                    container.one('#past-gigs'). removeClass('hidden');
                }
            } else {
                // @TODO: Add empty page template
                // container.one('#details').setHTML('<div class="empty">There are no gigs</div>');
            }

            this.updateWindowHeight();
        };

        this._cleanActiveState = function (container) {
            container.all('.booking').removeClass('active');
            container.all('.details').removeClass('active');
            container.all('.chat').removeClass('active');
            container.all('.actions').addClass('hidden');
        };

        this._showCurrentChat = function (container, block) {
            this._cleanActiveState(container);
            block.addClass('active');
            block.ancestor('.booking').addClass('active');
            block.ancestor('.actions').removeClass('hidden');
        };

        this._showCurrentGig = function (container, block) {
            this._cleanActiveState(container);
            block.addClass('active');
            block.one('.actions').removeClass('hidden');
        };

        this._showCurrentBooking = function (container, block) {
            this._cleanActiveState(container);
            block.addClass('active');
            block.ancestor('.booking').addClass('active');
            block.ancestor('.actions').removeClass('hidden');
        };

        // @TODO: Merge with bookings-promoter-extension.js:289
        this.calculateBookingRevenue = function () {
            var container = this.get('container'),
                potential_revenue = container.one('#potential_revenue').get('value'),
                revenue_share = container.one('#revenue_share').get('value'),
                price = container.one('#price').get('value'),
                potential_fee_input = container.one('#potential_fee'),
                price_min_input = container.one('#price-min'),
                price_max_input = container.one('#price-max'),
                value;

            potential_revenue = parseInt(potential_revenue);
            revenue_share = parseInt(revenue_share);
            price = parseInt(price);

            if (potential_revenue && revenue_share && price) {
                value = potential_revenue * (revenue_share / 100);
                potential_fee_input.set('value', price + value);

                price_min_input.setHTML(price);
                price_max_input.setHTML(price + value);
            }
        };

        // @TODO: Merge with bookings-promoter-extension.js:313
        this.updateWindowHeight = function (check_messages) {
            var container = this.get('container'),
                height = Y.one('body').get('winHeight') - 140;

            container.all('.scrollable').setStyle('height', height);
            if (check_messages) {
                container.one('#message-list').setStyle('height', height - 140);
            }
        };

        // @TODO: Merge with bookings-promoter-extension.js:323
        this.renderDatePickers = function () {
            // Calendar widget
            var datepickers = new Y.DatePicker({
                trigger     : '.datepicker',
                mask        : '%d.%m.%Y',
                popover     : {
                    zIndex  : 100
                }
            });
        };

        // @TODO: Merge with bookings-promoter-extension.js:334
        this.renderTZPicker = function () {
            this.log('Book form TZ pickers');

            // Book TZ pickers
            var container = this.get('container'),
                toggle = Y.one('#tz-toggle'),
                tz = new Y.Popover({
                    align: {
                        node        : toggle,
                        points      : [Y.WidgetPositionAlign.TC, Y.WidgetPositionAlign.BC]
                    },
                    bodyContent     : Y.one('#tz-menu').getHTML(),
                    position        : 'bottom',
                    zIndex          : 100,
                    render          : true,
                    visible         : false
                });

            // Bind clicks
            toggle.on('click', function () {
                tz.set('visible', !tz.get('visible'));
            });

            toggle.on('clickoutside', function () {
                tz.set('visible', false);
            });

            Y.on('popover:hide', function () {
                tz.set('visible', false);
            });

            Y.all('.tz-item').on('click', Y.bind(function(e) {
                var target = e.target.getData('target'),
                    label = e.target.getData('label'),
                    value = e.target.getData('value'),
                    canonical = e.target.getData('canonical');

                container.one('#' + target).set('value', value);
                container.one('#' + label).setHTML(canonical);
            }, this));
        };
    };
},
'0.1',
{
    requires: [
        'node',
        'form-extension'
    ]
});
