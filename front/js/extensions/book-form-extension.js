YUI.add('book-form-extension', function (Y) {

    Y.BookFormExtension = function () {

        this.errors = {};

        this.initBookForm = function(data) {
            this.log('Book form init');

            // Booking Form tabs click
            this.bindTabClicks();

            // Render initial state
            this.renderActiveTab('booking-gig', data, true);
        };

        this.renderActiveTab = function (target, initial_data, skip_validation) {
            this.log('Book form render active');

            var container = this.get('container'),
                form = container.one('#booking-form'),
                data = initial_data ? initial_data : this.serializeToJSON(form),
                source, template, html;

            // Update common attrs
            data.type = data.type != 'Select' ? data.type : null;
            data.transfer = data.transfer != 'Select' ? data.transfer : null;
            data.accommodation = data.accommodation != 'Select' ? data.accommodation : null;
            data.venueAttrs = window.appConfig.venueAttrs;

            data.type_string = window.app.getVAStringById('types', data.type);
            data.accommodation_string = window.app.getVAStringById('accommodations', data.accommodation);
            data.transfer_string = window.app.getVAStringById('transfertypes', data.transfer);

            data.gig_currency = data.gig_currency ? data.gig_currency : 1;
            data.gig_currency_symbol = window.app.getCurrencySymbolById(data.gig_currency);

            data.book_currency = data.gig_currency;
            data.book_currency_symbol = window.app.getCurrencySymbolById(data.book_currency);

            // Update revenue calc values
            data.revenue_share = data.revenue_share ? data.revenue_share : 10;
            data.potential_fee = this.getOfferRevenue(data);
            data.price_max = parseInt(data.book_price) + parseInt(data.potential_fee);

            data.times = window.app.getTimepickerData();
            data.tzInfo = window.appConfig.tzInfo;
            data.gig_timezone = window.app.getTZInfoById(data.gig_timezone);

            // Update book TZ only on form switch (not on loading)
            if (!initial_data) {
                data.book_timezone = data.book_timezone ? data.book_timezone : data.gig_timezone.name;
                data.book_timezone = window.app.getTZInfoById(data.book_timezone);
            }

            // Validate active
            var active = container.all('.booking-tab.active'),
                current = active ? active.getData('target')[0] : null;

            if (!skip_validation && !this.validateActiveTab(current, target, data)) target = current;

            // Set errors
            data.show_block = target;
            data.errors = this.errors;

            // Hide all TZ Pickers
            Y.fire('popover:hide');

            container.all('.booking-tab').removeClass('active');
            container.all('.' + target).addClass('active');

            source = Y.one('#t-booking-gig').getHTML();
            template = Y.Handlebars.compile(source);
            html = template(data);

            source = Y.one('#t-booking-offer').getHTML();
            template = Y.Handlebars.compile(source);
            html += template(data);

            source = Y.one('#t-booking-confirmation').getHTML();
            template = Y.Handlebars.compile(source);
            html += template(data);

            container.one('#booking-block').setHTML(html);

            // Bind extensions
            if (window.appConfig.user) {
                this.bindBookSearch();
            }
            this.renderVenueAutocomplete();
            this.renderDTPickers();
            this.renderTZPickers();
        };

        this.validateActiveTab = function (current, target, data) {
            this.log('Book form validate');

            var errors = {};

            // Return if current of backward step
            if (current == target || (current == 'booking-offer' && target == 'booking-gig')) {
                return true;
            }

            // Check target
            switch (current) {
                case 'booking-gig':
                    if (!data.name) {
                        errors.name = 'This field is required';
                    }
                    if (!data.type) {
                        errors.type = 'This field is required';
                    }
                    if (!data.capacity) {
                        errors.capacity = 'This field is required';
                    }
                    if (!data.gig_price) {
                        errors.gig_price = 'This field is required';
                    }
                    if (!data.gig_date_from) {
                        errors.gig_datetime = 'This field is required';
                    }
                    if (data.gig_date_from > data.gig_date_to) {
                        errors.gig_datetime = 'Date from is greater than date to';
                    }
                    if (!data.venue && !data.venue_id) {
                        errors.venue = 'This field is required';
                    }
                    break;
                case 'booking-offer':

                    if (!data.book_date_from) {
                        errors.book_datetime = 'This field is required';
                    }
                    if (data.book_date_from > data.book_date_to) {
                        errors.book_datetime = 'Date from is greater than date to';
                    }
                    if (data.gig_date_from > data.book_date_from || data.gig_date_to < data.book_date_to) {
                        errors.book_datetime = 'Set Time must be in the Gig Date range';
                    }
                    if (!data.book_price) {
                        errors.book_price = 'This field is required';
                    }
                    if (!data.transfer) {
                        errors.transfer = 'This field is required';
                    }
                    if (!data.accommodation) {
                        errors.accommodation = 'This field is required';
                    }
                    break;
            }

            this.errors = errors;
            return !Object.keys(errors).length;
        };

        this.bindTabClicks = function () {
            this.log('Book form bind clicks');

            // Calendar widget
            var container = this.get('container');

            Y.delegate('click', Y.bind(function(e) {
                this.renderActiveTab(e.target.getData('target'));
            }, this), container, '.booking-tab');

            // Bind calculators
            Y.delegate('change', Y.bind(function(e) {
                this.calculateGigRevenue();
            }, this), container, '#capacity');

            Y.delegate('change', Y.bind(function(e) {
                this.calculateGigRevenue();
            }, this), container, '#gig_price');

            Y.delegate('change', Y.bind(function(e) {
                this.calculateOfferRevenue();
            }, this), container, '#book_price, #revenue_share');
        };

        this.renderDTPickers = function () {
            this.log('Book form date/time pickers');

            // Date/time pickers
            var date_options = {
                    mask        : '%d.%m.%Y',
                    popover     : {
                        zIndex  : 100
                    }
                },
                gig_date_from, gig_date_to, book_date_from, book_date_to;

            date_options.trigger = '#gig_date_from';
            gig_date_from = new Y.DatePicker(date_options);

            date_options.trigger = '#gig_date_to';
            gig_date_to = new Y.DatePicker(date_options);

            date_options.trigger = '#book_date_from';
            book_date_from = new Y.DatePicker(date_options);

            date_options.trigger = '#book_date_to';
            book_date_to = new Y.DatePicker(date_options);
        };

        this.renderTZPickers = function () {
            this.log('Book form TZ pickers');

            // Book TZ pickers
            var container = this.get('container'),
                gig_toggle = Y.one('#gig-tz-toggle'),
                gig_tz = new Y.Popover({
                    align: {
                        node        : gig_toggle,
                        points      : [Y.WidgetPositionAlign.TC, Y.WidgetPositionAlign.BC]
                    },
                    bodyContent     : Y.one('#gig-tz-menu').getHTML(),
                    position        : 'bottom',
                    zIndex          : 100,
                    render          : true,
                    visible         : false
                }),
                book_toggle = Y.one('#book-tz-toggle'),
                book_tz = new Y.Popover({
                    align: {
                        node        : book_toggle,
                        points      : [Y.WidgetPositionAlign.TC, Y.WidgetPositionAlign.BC]
                    },
                    bodyContent     : Y.one('#book-tz-menu').getHTML(),
                    position        : 'bottom',
                    zIndex          : 100,
                    render          : true,
                    visible         : false
                });

            // Bind clicks
            gig_toggle.on('click', function () {
                gig_tz.set('visible', !gig_tz.get('visible'));
            });

            gig_toggle.on('clickoutside', function () {
                gig_tz.set('visible', false);
            });

            book_toggle.on('click', function () {
                book_tz.set('visible', !book_tz.get('visible'));
            });

            book_toggle.on('clickoutside', function () {
                book_tz.set('visible', false);
            });

            Y.on('popover:hide', function () {
                gig_tz.set('visible', false);
                book_tz.set('visible', false);
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

        this.calculateGigRevenue = function () {
            var container = this.get('container'),
                capacity = container.one('#capacity').get('value'),
                gig_price = container.one('#gig_price').get('value'),
                value;

            capacity = parseInt(capacity);
            gig_price = parseInt(gig_price);

            if (capacity && gig_price) {
                value = capacity * gig_price;
                container.one('#revenue').set('value', !isNaN(value) ? value.toFixed(2) : '');
            } else {
                container.one('#revenue').set('value', '');
            }
        };

        this.calculateOfferRevenue = function () {
            var container = this.get('container'),
                capacity = container.one('#capacity').get('value'),
                gig_price = container.one('#gig_price').get('value'),
                book_price = container.one('#book_price').get('value'),
                revenue_share = container.one('#revenue_share').get('value'),
                value;

            capacity = parseInt(capacity);
            gig_price = parseInt(gig_price);

            if (capacity && gig_price) {
                book_price = parseInt(book_price);
                revenue_share = parseInt(revenue_share);
                value = revenue_share ? capacity * gig_price * (revenue_share / 100): 0;
                value += book_price ? book_price : 0;
                container.one('#potential_fee').set('value', !isNaN(value) ? value.toFixed(2) : '');
            }
        };

        this.getOfferRevenue = function (data) {
            var capacity, gig_price, revenue_share, value = 0;

            capacity = parseInt(data.capacity);
            gig_price = parseInt(data.gig_price);
            revenue_share = parseInt(data.revenue_share);

            if (capacity && gig_price && revenue_share) {
                value = capacity * gig_price * (revenue_share / 100);
                value = !isNaN(value) ? value.toFixed(2) : 0;
            }
            return value;
        };

        this.setErrors = function (errors) {
            this.cleanErrors();
            for (var i = 0; i < errors.length; i++) {
                if (this.errors.hasOwnProperty(errors[i].field)) {
                    this.errors[errors[i].field].append(errors[i].message);
                } else {
                    this.errors[errors[i].field] = [errors[i].message];
                }
            }
        };

        this.cleanErrors = function () {
            this.errors = {};
        };
    };
},
'0.1',
{
    requires: [
        'node',
        'io-form',
        'aui-datepicker',
        'aui-timepicker',
        'aui-dropdown',
        'form-extension',
        'search-extension'
    ]
});
