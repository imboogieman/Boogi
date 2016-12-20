YUI.add('user-model', function(Y) {

    'use strict';

    Y.UserModel = Y.Base.create('userModel', Y.BaseModel, [], {

        login: function (data) {
            var callback = Y.bind(function (response) {
                if (response.result == this.apiStatus.SUCCESS) {
                    window.appConfig.user = response.data;
                    this.fire('user:login');
                }
            }, this);

            this.getData('/api/user/login', data, callback, this, true);
        },

        switch_role: function (data) {
            var callback = Y.bind(function (response) {
                if (response.result == this.apiStatus.SUCCESS) {
                    window.appConfig.user = response.data;
                    this.fire('user:switched');
                }
            }, this);

            this.getData('/api/user/switch', data, callback, this, true);
        },

        logout: function (data) {
            var callback = Y.bind(function (response) {
                if (response.result == this.apiStatus.SUCCESS) {
                    window.appConfig.user = null;
                    this.fire('user:logout');
                }
            }, this);

            this.getData('/api/user/logout', data, callback, this, true);
        },

        fbRegister: function () {
            var callback = Y.bind(function (response) {
                if (response.result == this.apiStatus.SUCCESS) {
                    this.fire('user:fb-register', { response: response });
                }
            }, this);

            this.getData('/api/user/fbregister', {}, callback, this, true);
        },

        getRecommendedArtists: function (from, to, mode) {
            var callback = Y.bind(function (response) {
                if (response.result == this.apiStatus.SUCCESS) {
                    if (mode === 'first') {
                        this.fire('user:get-artists', {response: response});
                    } else if (mode === 'next') {
                        this.fire('user:get-artists-next', {response: response});
                    }
                }
            }, this);
            this.getData('/api/user/getrecommendedart', {from: from, to: to}, callback, this, true);
        },

        restore: function(data) {
            var callback = Y.bind(function (response) {
                if (response.result == this.apiStatus.SUCCESS) {
                    this.fire('user:restored', { message: response.message });
                }
            }, this);

            this.getData('/api/user/restore', data, callback, this, true);
        },

        getCallingCode: function() {
            var callback = Y.bind(function (response) {
                if (response.result == this.apiStatus.SUCCESS) {
                    this.fire('user:callingcode', { code: response.data });
                }
            }, this);

            this.getData('/api/user/getcallingcode', {}, callback, this, true);
        },

        //register: function(data) {
        //    var callback = Y.bind(function (response) {
        //        if (response.result == this.apiStatus.SUCCESS) {
        //            window.appConfig.user = response.data;
        //            this.fire('user:registered', { message: response.message });
        //        } else if (response.result == this.apiStatus.INVALID) {
        //            this.fire('user:register-invalid', { message: response.message, errors: response.errors });
        //        }
        //    }, this);
        //
        //    this.getData('/api/user/register', data, callback, this, true);
        //},

        submitRegister: function(data) {
            var callback = Y.bind(function (response) {
                if (response.result == this.apiStatus.SUCCESS) {
                    window.appConfig.user = response.data;
                    this.fire('user:registered', { message: response.message });
                } else if (response.result == this.apiStatus.INVALID) {
                    this.fire('user:register-invalid', { message: response.message, errors: response.errors });
                }
            }, this);

            this.getData('/api/user/submitregister', data, callback, this, true);
        },

        checkhash: function(hash) {
            var callback = Y.bind(function (response) {
                if (response.result == this.apiStatus.SUCCESS) {
                    this.fire('hash:checked', { response: response });
                }
            }, this);

            this.getData('/api/user/checkhash', { hash: hash }, callback, this, true);
        },

        newpass: function(data) {
            var callback = Y.bind(function (response) {
                if (response.result == this.apiStatus.SUCCESS) {
                    this.fire('user:newpass');
                }
            }, this);

            this.getData('/api/user/newpass', data, callback, this, true);
        },

        upgrade: function(data) {
            var callback = Y.bind(function (response) {
                if (response.result == this.apiStatus.SUCCESS) {
                    this.fire('user:upgraded', { response: response });
                }
            }, this);

            this.getData('/api/user/upgrade', data, callback, this, true);
        }

    }, {
        ATTRS: {

        }
    });
},
'0.1',
{
    requires: [
        'base-model'
    ]
});