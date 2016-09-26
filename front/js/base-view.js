YUI.add('base-view', function(Y) {

    'use strict';

    Y.BaseView = Y.Base.create('baseView', Y.View, [Y.MapExtension, Y.LogExtension, Y.LoaderExtension, Y.OverlayExtension], {

        initializer: function() {
            this.log('Base init');
            this.model = this.get('model');
            this.apiStatus = this.get('apiStatus');
            this.updateMapParams();
        },

        redirect: function(url) {
            if (window.app.router.hasRoute(url)) {
                window.app.router.save(url);
            } else {
                var source = Y.one('#t-404').getHTML(),
                    template = Y.Handlebars.compile(source);
                this.get('container').setHTML(template());
            }
        }

    }, {
        ATTRS: {
            model: {
                valueFn: function () {
                    return new Y.BaseModel();
                }
            },

            center: {
                value: null
            },

            offsetCenter: {
                value: null
            },

            radius: {
                value: null
            },

            map: {
                value: null
            },

            userMarker: {
                value: null
            },

            radiusCircle: {
                value: null
            },

            config: {
                value: null
            },

            apiStatus:  {
                value: window.appConfig.apiStatusDict
            }

        }
    });
},
'0.1',
{
    requires: [
        'node',
        'view',
        'log-extension',
        'map-extension',
        'loader-extension',
        'overlay-extension'
    ]
});