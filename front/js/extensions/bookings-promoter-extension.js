YUI.add('bookings-promoter-extension', function (Y) {

    Y.BookingsPromoterExtension = function () {

        this._bindPromoterSidebarEvents = function() {
            var container = this.get('container');

            Y.delegate('click', Y.bind(function(e) {
                var source   = Y.one('#t-features-partial').getHTML(),
                    template = Y.Handlebars.compile(source);

                e.stopPropagation();
                Y.fire('toolbar:hide');

                // Check chat view state
                container.all('.subpage').removeClass('active');
                e.target.addClass('active');

                // Show features partial
                container.one('#details').setHTML(template());

                return false;
            }, this), container, '.features');

            Y.delegate('click', Y.bind(function(e) {
                e.stopPropagation();
                Y.fire('toolbar:hide');

                // Check chat view state
                container.all('.chat').removeClass('active');
                container.all('.features').removeClass('active');
                e.target.addClass('active');

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
                    var source   = Y.one('#t-promoter-messages').getHTML(),
                        template = Y.Handlebars.compile(source);

                    // Compile and show messages
                    data.messages = this.model.get('messageList');
                    container.one('#details').setHTML(template(data));

                    // Update window height and messages list height
                    this.updateWindowHeight(true);
                }, this));

                // Update view internals
                this.model.once('messages:empty', Y.bind(function () {
                    var source   = Y.one('#t-promoter-messages').getHTML(),
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
                var block    = e.target.hasClass('booking') ? e.target : e.target.ancestor('.booking'),
                    source   = Y.one('#t-promoter-booking-details').getHTML(),
                    template = Y.Handlebars.compile(source),
                    data     = this.model.getArtistGig(block.getData('id'));

                // Compile and show booking details
                container.one('#details').setHTML(template(data));

                // Check artist view state
                container.all('.booking').removeClass('active');
                block.addClass('active');

                // Update pointers
                container.all('.pointer').removeClass('opened');
                block.one('.pointer').addClass('opened');

                // Close all sub pages
                container.all('.subpage').removeClass('active');

                // Show actions
                container.all('.actions').addClass('hidden');
                block.one('.actions').removeClass('hidden');

                // Update window height
                this.updateWindowHeight();

                return false;
            }, this), container, '.booking');

            Y.delegate('click', Y.bind(function(e) {
                // Compile params
                var block    = e.target.hasClass('gig') ? e.target : e.target.ancestor('.gig'),
                    source   = Y.one('#t-promoter-gig-details').getHTML(),
                    template = Y.Handlebars.compile(source),
                    data     = this.model.getGig(block.getData('id'));

                // Compile and show booking details
                container.one('#details').setHTML(template(data));

                // Close all artists
                container.all('.gig').removeClass('active');
                container.all('.bookings').addClass('hidden');
                container.all('.actions').addClass('hidden');
                container.all('.booking').removeClass('active');
                container.all('.pointer').removeClass('opened');

                // Check bookings view state
                if (!block.hasClass('active')) {
                    block.addClass('active');
                    block.one('.bookings').removeClass('hidden');
                }

                // Close all sub pages
                container.all('.subpage').removeClass('active');

                // Init Gig map and update window height
                this._initGigMap(data);
                this.updateWindowHeight();
            }, this), container, '.gig');
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

        this._bindPromoterEditEvents = function() {
            var container = this.get('container');

            // Init gig edit buttons
            Y.delegate('click', Y.bind(function(e) {
                e.preventDefault();

                var source   = Y.one('#t-promoter-gig-form').getHTML(),
                    template = Y.Handlebars.compile(source),
                    data     = this.model.getGig(e.target.getData('id'));

                // Set content and show panel
                container.one('#details').setHTML(template(data));

                // Render controls and update window height
                this.renderDatePickers();
                this.renderTZPicker();
                this.renderVenueAutocomplete();
                this.updateWindowHeight();

                return false;
            }, this), container, '.edit-gig');

            // Init booking edit buttons
            Y.delegate('click', Y.bind(function(e) {
                e.preventDefault();

                var source   = Y.one('#t-promoter-book-form').getHTML(),
                    template = Y.Handlebars.compile(source),
                    data     = this.model.getArtistGig(e.target.getData('id'));

                // Set content and show form
                container.one('#details').setHTML(template(data));

                // Render controls and update window height
                this.renderDatePickers();
                this.renderTZPicker();
                this.updateWindowHeight();

                return false;
            }, this), container, '.edit-booking');

            // Init status buttons
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

            // Init gig edit calc
            Y.delegate('change', Y.bind(function(e) {
                this.calculateGigRevenue();
            }, this), container, '#gig-form #price, #capacity');

            // Init booking edit calc
            Y.delegate('change', Y.bind(function(e) {
                this.calculateBookingRevenue();
            }, this), container, '#book-form #price, #revenue_share');
        };

        this._renderBookings = function(open_id) {
            // Extract the template string and compile it into a reusable function.
            var source = Y.one('#t-promoter-bookings').getHTML(),
                template = Y.Handlebars.compile(source),
                container = this.get('container'),
                data = this.model.get('gigList'),
                parent_block, block, first_block, open_block, html;

            // Add to container bookings block
            html = template({
                active          : data.active,
                past            : data.past,
                show_past_label : data.show_past_label,
                venueAttrs      : window.appConfig.venueAttrs
            });
            container.setHTML(html);

            // Compile and show opened gig
            first_block = container.one('.gig');
            open_block = container.one('#' + open_id);
            if (first_block || open_block) {
                open_id = open_block ? open_block.get('id') : first_block.get('id');
                block = open_block ? open_block : first_block;
                block.removeClass('hidden').addClass('active');

                // If single Id then compiling Gig
                if (open_id.split('-').length == 1) {
                    block.one('.bookings').removeClass('hidden');

                    source = Y.one('#t-promoter-gig-details').getHTML();
                    template = Y.Handlebars.compile(source);

                    data = this.model.getGig(block.getData('id'));
                    container.one('#details').setHTML(template(data));

                    this._initGigMap(data);

                    // Otherwise compiling ArtistGig (Booking)
                } else {
                    block.one('.pointer').addClass('opened');
                    block.one('.actions').removeClass('hidden');

                    parent_block = container.one('#' + open_id.split('-')[0]);
                    parent_block.removeClass('hidden').addClass('active');
                    parent_block.one('.bookings').removeClass('hidden');

                    source = Y.one('#t-promoter-booking-details').getHTML();
                    template = Y.Handlebars.compile(source);

                    data = this.model.getArtistGig(block.getData('id'));
                    container.one('#details').setHTML(template(data));
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

        this.calculateGigRevenue = function () {
            var container = this.get('container'),
                capacity = container.one('#capacity').get('value'),
                price = container.one('#price').get('value'),
                value;

            capacity = parseInt(capacity);
            price = parseInt(price);

            if (capacity && price) {
                value = capacity * price;
                container.one('#revenue').set('value', value)
            }
        };

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

        this.updateWindowHeight = function (check_messages) {
            var container = this.get('container'),
                height = Y.one('body').get('winHeight') - 140;

            container.all('.scrollable').setStyle('height', height);
            if (check_messages) {
                container.one('#message-list').setStyle('height', height - 140);
            }
        };

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
