YUI.add('user-view', function(Y) {

    'use strict';

    Y.UserView = Y.Base.create('userView', Y.BaseView, [Y.FormExtension, Y.ToolbarExtension, Y.LoaderExtension], {

        events: {
            '.cancel'               : { click: 'loginForm' },
            '#show-register-form'   : { click: 'registerForm' },
            '#show-restore-form'    : { click: 'restoreForm' },
            '#login-form input'     : { keydown: 'checkEnter' },
            '#login'                : { click: 'login' },
            '#logout'               : { click: 'logout' },
            '#register'             : { click: 'register' },
            '#restore'              : { click: 'restore' },
            '#newpass'              : { click: 'newpass' }
        },

        initializer: function() {
            this.log('Init');
            this.model = this.get('model');
        },

        render: function() {
            this.log('Render');

            // Extract the template string and compile it into a reusable function.
            var container = this.get('container'),
                source   = Y.one('#t-user').getHTML(),
                template = Y.Handlebars.compile(source),
                html, url;

            // Render the template to HTML using the specified data
            // And append the rendered template to the page.
            html = template({
                latitude    : this.center.lat(),
                longitude   : this.center.lng(),
                radius      : this.radius,
                fbLoginUrl  : window.appConfig.params.fbLoginUrl
            });
            container.setHTML(html);

            // Hide loader
            this.hideLoader();

            // Switch actions
            switch (this.get('action')) {
                case 'switch':
                    this.switch_role();
                    break;
                case 'logout':
                    this.logout();
                    break;
                case 'register':
                    this.registerForm();
                    break;
                case 'restore':
                    this.restoreForm();
                    break;
                case 'newpass':
                    this.newpassForm();
                    break;
                case 'upgrade':
                    this.upgrade(this.get('plan'), this.get('status'));
                    break;
                default:
                    this.loginForm();
                    break;
            }
        },

        checkEnter: function(e) {
            if (e.keyCode == 13) {
                this.login();
            }
        },

        loginForm: function() {
            this.log('Show login form');

            this.get('container').all('.form').addClass('hidden');
            this.get('container').one('#login-form').removeClass('hidden');
        },

        registerForm: function() {
            this.log('Show register form');

            this.get('container').all('.form').addClass('hidden');
            this.get('container').one('#register-form').removeClass('hidden');
        },

        restoreForm: function() {
            this.log('Show register form');

            this.get('container').all('.form').addClass('hidden');
            this.get('container').one('#restore-form').removeClass('hidden');
        },

        newpassForm: function() {
            this.log('Show register form');

            this.model.checkhash(this.get('hash'));

            // Update view internals
            this.model.once('hash:checked', Y.bind(function(e) {
                if (e.response.result == this.apiStatus.SUCCESS) {
                    this.get('container').all('.form').addClass('hidden');
                    this.get('container').one('#newpass-form').removeClass('hidden');
                } else {
                    this.showOverlay(e.response.message);
                    this.redirect('/user/restore');
                }
            }, this));
        },

        login: function() {
            this.log('Submit login form');

            this.model.login({
                email       : this.get('container').one('#email').get('value'),
                password    : this.get('container').one('#password').get('value')
            });

            // Update view internals
            this.model.once('user:login', Y.bind(function() {
                this._gotoBookingPanel();
            }, this));
        },

        switch_role: function() {
            this.log('Switch user account');

            this.model.switch_role();
            this.model.once('user:switched', Y.bind(function() {
                this._gotoBookingPanel();
            }, this));
        },

        _gotoBookingPanel: function() {
            this.renderToolbar();
            if (window.appConfig.user.role == 1) {
                window.app.track('User', 'Switch', 'Promoter');
                this.redirect('/promoter/bookings');
            } else {
                window.app.track('User', 'Switch', 'Artist');
                this.redirect('/artist/bookings');
            }
        },

        logout: function() {
            this.log('Submit logout form');

            this.model.logout();

            this.model.once('user:logout', Y.bind(function() {
                this.renderToolbar();
                this.redirect('/');
            }, this));
        },

        restore: function() {
            this.log('Submit restore password form');

            this.model.restore({
                email : this.get('container').one('#restore-email').get('value')
            });

            this.model.once('user:restored', Y.bind(function(e) {
                this.showOverlay(e.message);
                this.redirect('/user/restore');
            }, this));

            window.app.track('User', 'Restore password');
        },

        register: function() {
            this.log('Submit register form');

            var form = this.get('container').one('#register-form'),
                data = this.serializeToJSON(form);

            this.model.register(data);

            this.model.once('user:registered', Y.bind(function(e) {
                this.renderToolbar();
                this.showOverlay(e.message, true);

                if (window.appConfig.user.role == 1) {
                    window.app.track('User', 'Register', 'Promoter');
                    this.redirect('/promoter/profile');
                } else {
                    window.app.track('User', 'Register', 'Artist');
                    this.redirect('/artist/profile');
                }
            }, this));

            this.model.once('user:register-invalid', Y.bind(function(e) {
                this.highlightErrors(form, e.message, e.errors);
                window.app.track('User', 'Register', 'Error');
            }, this));
        },

        newpass: function() {
            this.log('Submit newpass form');

            this.model.newpass({
                hash      : this.get('hash'),
                password  : this.get('container').one('#newpass-password').get('value'),
                password2 : this.get('container').one('#newpass-password2').get('value')
            });

            this.model.once('user:newpass', Y.bind(function(e) {
                this.showOverlay(e.message);
                this.redirect('/user/login');
            }, this));

            window.app.track('User', 'Update password');
        },

        upgrade: function(plan, status) {
            this.log('Upgrade plane to ' + plan + ', status - ' + status);

            if (window.appConfig.user) {
                if (status == 'success') {
                    this.model.upgrade({ plan: plan });

                    this.model.once('user:upgraded', Y.bind(function (e) {
                        window.appConfig.user = e.response.user;
                        this.showOverlay(e.response.message, true);

                        if (window.appConfig.user.role == 1) {
                            window.app.track('Promoter', 'Upgrade', window.app.getPlan(plan));
                            this.redirect('/promoter/profile');
                        } else {
                            window.app.track('Artist', 'Upgrade', window.app.getPlan(plan));
                            this.redirect('/artist/profile');
                        }
                    }, this));
                } else {
                    this.showOverlay('Something went wrong so we can\'t update your plan, please try later');
                    if (window.appConfig.user.role == 1) {
                        window.app.track('Promoter', 'Upgrade', 'Error');
                        this.redirect('/promoter/profile');
                    } else {
                        window.app.track('Artist', 'Upgrade', 'Error');
                        this.redirect('/artist/profile');
                    }
                }
            } else {
                this.showOverlay('You can\'t perform this action, please login first');
                this.loginForm();
            }
        }

    }, {
        ATTRS: {
            model: {
                valueFn: function () {
                    return new Y.UserModel();
                }
            }
        }
    });
},
'0.1',
{
    requires: [
        'json',
        'handlebars',
        'base-view',
        'user-model',
        'form-extension',
        'loader-extension',
        'toolbar-extension'
    ]
});
