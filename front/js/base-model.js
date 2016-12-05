YUI.add('base-model', function(Y) {

    'use strict';

    Y.BaseModel = Y.Base.create('baseModel', Y.Model, [Y.LiveExtension, Y.LogExtension, Y.LoaderExtension,
                                                       Y.OverlayExtension], {

        initializer: function() {
            this.log('Base Init');
            this.apiStatus = this.get('apiStatus');
        },

        getData: function (url, data, callback, context, showLoader) {
            this.log('Call to backend: ' + url);

            showLoader && this.showLoader();

            Y.io(url, {
                method  : 'POST',
                data    : data,
                context : context,
                on : {
                    success: Y.bind(function (txid, response) {
                        showLoader && this.hideLoader();

                        var resp = Y.JSON.parse(response.responseText);
                        if (resp.result == this.apiStatus.REQ_LOGIN) {
                            this.showLoginOverlay(resp.message, {
                                //url         : url,
                                //data        : data,
                                //callback    : callback,
                                //context     : context,
                                //showLoader  : showLoader
                            });
                        } else if (resp.result == this.apiStatus.ERROR) {
                            this.showOverlay(resp.message);
                        } else {
                            callback && callback.call(context, resp);

                            // Update live data
                            if (resp.live) {
                                this.processLiveData(resp.live);
                            }
                        }
                    }, this)
                }
            });
        },

        live: function () {
            this.getData('/api/site/live');
        },

        contact: function (data) {
            this.log('Contact submit');

            var callback = Y.bind(function (response) {
                if (response.result == this.apiStatus.SUCCESS) {
                    this.fire('sent', { message: response.message });
                }
            }, this);

            this.getData('/api/site/contact', data, callback, this, true);
        },

        notFound: function (data) {
            this.log('Not found submit');

            var callback = Y.bind(function (response) {
                if (response.result == this.apiStatus.SUCCESS) {
                    this.fire('not-found', { message: response.message });
                }
            }, this);

            this.getData('/api/site/contact', data, callback, this, true);
        },

        follow: function(id, type) {
            var data = { id: id, type: type },
                callback = Y.bind(function (response) {
                    if (response.result == this.apiStatus.SUCCESS) {
                        this.fire('item:follow', { response: response });
                    }
                }, this);

            this.getData('/api/site/follow', data, callback, this, true);
        },

        unfollow: function(id, type) {
            var data = { id: id, type: type },
                callback = Y.bind(function (response) {
                    if (response.result == this.apiStatus.SUCCESS) {
                        this.fire('item:unfollow', { response: response });
                    }
                }, this);

            this.getData('/api/site/unfollow', data, callback, this, true);
        },

        error: function(message) {
            this.getData('/api/site/error', { e: message }, null, this, false);
        }

    }, {
        ATTRS: {

            apiStatus:  {
                value: window.appConfig.apiStatusDict
            }

        }
    });
},
'0.1',
{
    requires: [
        'io-base',
        'model',
        'log-extension',
        'live-extension',
        'loader-extension',
        'overlay-extension',
        'json'
    ]
});