YUI.add('site-view', function(Y) {

    'use strict';

    Y.SiteView = Y.Base.create('siteView', Y.BaseView, [Y.RouterExtension, Y.SearchExtension, Y.LoaderExtension,
            Y.FormExtension, Y.PricingExtension], {

        events: {
            '#contact'                  : { click: 'contact' },
            '#home-autocomplete-submit' : { click: 'addArtist' },
            '#not-found-submit'         : { click: 'notFound' }
        },

        initializer: function() {
            this.log('Init');
            this.model = this.get('model');
        },

        render: function(e) {
            this.log('Render');

            // Hide loader
            this.hideLoader();

            // Page tracker
            window.app.track('User', 'Visit', this.get('action'));

            // Switch actions
            switch (this.get('action')) {
                case '404':
                case 'team':
                case 'terms':
                case 'privacy':
                case 'about':
                case 'pricing':
                case 'contact':
                    this.show(this.get('action'));
                    break;
                default:
                    this.index();
                    break;
            }
        },

        index: function () {
            this.log('Show index');

            Y.one('#menu-search').addClass('hidden');

            var source   = Y.one('#t-index').getHTML(),
                template = Y.Handlebars.compile(source);

            this.get('container').setHTML(template({
                featured_artists: window.appConfig.featuredArtists,
                artists_count   : window.appConfig.artistsCount
            }));

            this.bindHomeEvents();
        },

        bindHomeEvents: function () {
            var container = this.get('container');

            // Init search autocomplete
            // @TODO: Remove timeout
            setTimeout(Y.bind(this.bindHomeSearch, this), 500);

            // Init artist edit buttons
            Y.delegate('click', Y.bind(function(e) {
                e.preventDefault();

                var self = e.currentTarget,
                    target = self.getData('target');

                container.all('.switch-to-benefits').removeClass('active');
                self.addClass('active');

                container.all('.benefits').addClass('hidden');
                container.one('#' + target).removeClass('hidden');

                return false;
            }, this), container, '.switch-to-benefits');
        },

        show: function(name) {
            this.log('Show ' + name);

            var container = this.get('container'),
                source   = Y.one('#t-' + name).getHTML(),
                template = Y.Handlebars.compile(source);

            container.setHTML(template());

            if (name == 'pricing') {
                this.bindPricingEvents();
            }
        },

        addArtist: function (e) {
            var query = Y.one('#home-ac-input').get('value');
            window.location.href = '/artist/add/' + encodeURIComponent(query);
        },

        contact: function(e) {
            this.log('Submit contact form');
            e.preventDefault();

            var form = this.get('container').one('#contact-form'),
                data = this.serializeToJSON(form);

            this.model.contact(data);

            this.model.once('sent', Y.bind(function(e) {
                form.reset();
                this.showOverlay(e.message);
            }, this));
        },

        notFound: function(e) {
            this.log('Submit not found form');
            e.preventDefault();

            var form = this.get('container').one('#not-found-form'),
                data = this.serializeToJSON(form);

            this.model.notFound(data);

            this.model.once('not-found', Y.bind(function(e) {
                form.reset();
                this.showOverlay(e.message);
            }, this));
        }

    }, {
        ATTRS: {
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
        'json',
        'event-hover',
        'handlebars',
        'base-view',
        'base-model',
        'form-extension',
        'loader-extension',
        'router-extension',
        'search-extension',
        'pricing-extension'
    ]
});
