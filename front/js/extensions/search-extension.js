YUI.add('search-extension', function (Y) {

    Y.SearchExtension = function () {

        this.defaults = {
            source              : '/api/site/search?q={query}',
            minQueryLength      : 3,
            resultListLocator   : 'data',
            resultTextLocator   : 'name',
            resultHighlighter   : 'phraseMatch',
            resultFormatter     : function (query, results) {
                var source      = Y.one('#t-ac-item').getHTML(),
                    template    = Y.Handlebars.compile(source);

                return Y.Array.map(results, function (result) {
                    return template(result.raw);
                });
            },
            on : {
                select : Y.bind(function(e) {
                    e.itemNode.one('a').simulate('click');
                }, this)
            }
        };

        this.bindToolbarSearch = function () {
            Y.one('#toolbar-ac-input').plug(Y.Plugin.AutoComplete, this.defaults);
        };

        this.bindHomeSearch = function () {
            var is_typed= true,
                params  = this.defaults;

            // Add tracker event
            params.on.results =  Y.bind(function(e) {
                if (!is_typed) {
                    window.app.track('User', 'Search Artist');
                    is_typed = true;
                }
            }, this);

            Y.one('#home-ac-input').plug(Y.Plugin.AutoComplete, params);
        };

        this.bindBookSearch = function () {
            var params = this.defaults,
                gigModel = new Y.GigModel();

            // Replace endpoint and formatter
            params.source = '/api/promoter/bookingdetails?q={query}';

            params.resultFormatter = function (query, results) {
                var source      = Y.one('#t-booking-ac-item').getHTML(),
                    template    = Y.Handlebars.compile(source);

                return Y.Array.map(results, function (result) {
                    return template(result.raw);
                });
            };

            params.on = {
                select : Y.bind(function(e) {
                    var id = e.itemNode.one('div').getData('id');
                    gigModel.getForBookingForm({ id: id });
                }, this)
            };

            gigModel.on('gig:bookingForm', Y.bind(function (e) {
                var form = Y.one('#booking-form'),
                    data = gigModel.get('bookingFormData'),
                    datetime, date_from, date, time;

                if (data.id) {
                    form.one('#gig_id').set('value', data.id);

                    if (data.type_id)
                        form.one('#type').set('value', data.type_id);

                    if (data.datetime_from) {
                        datetime = Y.Date.parse(data.datetime_from);

                        date = Y.Date.format(datetime, { format: window.app.dtFormat.date.edit });
                        form.one('#gig_date_from').set('value', date);
                        form.one('#book_date_from').set('value', date);

                        time = Y.Date.format(datetime, { format: window.app.dtFormat.time.edit });
                        form.one('#gig_time_from').set('value', time);
                        form.one('#book_time_from').set('value', time);
                    }

                    if (data.datetime_to) {
                        datetime = Y.Date.parse(data.datetime_to);

                        date = Y.Date.format(datetime, { format: window.app.dtFormat.date.edit });
                        form.one('#gig_date_to').set('value', date);
                        form.one('#book_date_to').set('value', date);

                        time = Y.Date.format(datetime, { format: window.app.dtFormat.time.edit });
                        form.one('#gig_time_to').set('value', time);
                        form.one('#book_time_to').set('value', time);
                    }

                    if (data.timezone) {
                        form.one('#gig_timezone').set('value', data.timezone.name);
                        form.one('#gig-tz-toggle').setHTML(data.timezone.canonical);
                    }


                    if (data.venue) {
                        form.one('#venue').set('value', data.venue.name);
                        form.one('#venue_id').set('value', data.venue.id);
                    }

                    if (data.address)
                        form.one('#address').set('value', data.address);
                    if (data.capacity)
                        form.one('#capacity').set('value', data.capacity);
                    if (data.price)
                        form.one('#gig_price').set('value', data.price);
                    if (data.revenue)
                        form.one('#revenue').set('value', data.revenue);
                    if (data.currency)
                        form.one('#gig_currency').set('value', data.currency);
                    if (data.description)
                        form.one('#description').set('value', data.description);
                }
            }, this));

            var ac_input = Y.one('#booking-gig #name').plug(Y.Plugin.AutoComplete, params);
            Y.one('#booking-gig #ac-all').on('click', Y.bind(function() {
                ac_input.ac.sendRequest('');
            }, this));
        };
    };

},
'0.1',
{
    requires: [
        'node',
        'handlebars',
        'autocomplete'
    ]
});