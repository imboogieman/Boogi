YUI.add('router-extension', function (Y) {

    Y.RouterExtension = function() {

        this.redirect = function (url) {
            var view = new Y.BaseView;
            view.redirect(url);
        };

        this._beforeRoute = function () {
            Y.one('#menu-logo').removeClass('hidden');
            Y.one('#menu-search').removeClass('hidden');
            Y.all('#menu-site li').removeClass('active');
        };

        this._afterRoute = function (request, type) {
            // Get metadata
            var target = request.route.target,
                data = window.appConfig.metadata.default;

            // Check extra options
            switch (type) {
                case 'list':
                    target += '_list';
            }

            // Get target data
            if (window.appConfig.metadata.hasOwnProperty(target)) {
                data = window.appConfig.metadata[target];
            }

            // Update page tags
            Y.one('title').setHTML(data.title);
            Y.one('meta[name="description"]').set('content', data.metadesc);
            Y.one('meta[name="keywords"]').set('content', data.metakeys);
        };

        this.showBookForm = function (request) {
            this._beforeRoute();
            this.log('Router artist ' + request.params.alias);
            this.showView('artist', {
                action  : 'book',
                alias   : request.params.alias,
                date    : request.params.date
            });
            this._afterRoute(request);
        };

        this.showAddForm = function (request) {
            this._beforeRoute();
            this.log('Router artist add');
            this.showView('artist', {
                action  : 'add',
                query   : request.params.query,
                mild    : request.params.mild
            });
            this._afterRoute(request);
        };

        this.showPage = function (request) {
            this._beforeRoute();
            this.log('Router ' + request.route.target);
            this.showView('site', { action: request.route.target });
            this._afterRoute(request, 'page');
        };

        this.showList = function (request) {
            this._beforeRoute();
            this.log('Router ' + request.route.target + ' list');
            this.showView(request.route.target);
            this._afterRoute(request, 'list');
        };

        this.showItem = function (request) {
            this._beforeRoute();
            this.log('Router ' + request.route.target + ' ' + request.params.alias);
            this.showView(request.route.target, { action: 'show', alias: request.params.alias });
            this._afterRoute(request, 'item');
        };

        this.initRouter = function () {
            this.log('Init router');

            this.router = new Y.Router({
                html5  : true,
                root   : '/',
                routes : [
                    {
                        path: '/',
                        target: 'index',
                        callbacks: Y.bind(this.showPage, this)
                    },
                    {
                        path: '/user/login',
                        target: 'login',
                        callbacks: Y.bind(function (request) {
                            this._beforeRoute();
                            this.log('Router login form');
                            if (window.appConfig.user) {
                                if (window.appConfig.user.role == 1) {
                                    this.redirect('/promoter/profile');
                                } else {
                                    this.redirect('/artist/profile');
                                }
                            } else {
                                this.showView('user', { action: 'login' });
                            }
                            this._afterRoute(request);
                        }, this)
                    },
                    {
                        path: '/user/logout',
                        target: 'default',
                        callbacks: Y.bind(function (request) {
                            this._beforeRoute();
                            this.log('Router logout');
                            this.showView('user', { action: 'logout' });
                            this._afterRoute(request);
                        }, this)
                    },
                    {
                        path: '/user/switch/:role',
                        target: 'default',
                        callbacks: Y.bind(function (request) {
                            this._beforeRoute();
                            this.log('Router switch');
                            this.showView('user', { action: 'switch', role: request.params.role });
                            this._afterRoute(request);
                        }, this)
                    },
                    {
                        path: '/user/signup',
                        target: 'signup',
                        callbacks: Y.bind(function (request) {
                            this._beforeRoute();
                            this.log('Router signup form');
                            if (window.appConfig.user) {
                                if (window.appConfig.user.role == 1) {
                                    this.redirect('/promoter/profile');
                                } else {
                                    this.redirect('/artist/profile');
                                }
                            } else {
                                this.showView('user', { action: 'register' });
                            }
                            this._afterRoute(request);
                        }, this)
                    },
                    {
                        path: '/user/fb-register',
                        target: 'fb-register',
                        callbacks: Y.bind(function (request) {
                            this._beforeRoute();
                            this.log('Router facebook register form');
                            this.showView('user', { action: 'fbRegister' });
                            this._afterRoute(request);
                        }, this)
                    },
                    {
                        path: '/user/restore',
                        target: 'restore',
                        callbacks: Y.bind(function (request) {
                            this._beforeRoute();
                            this.log('Router restore form');
                            this.showView('user', { action: 'restore' });
                            this._afterRoute(request);
                        }, this)
                    },
                    {
                        path: '/user/newpass/:hash',
                        target: 'restore',
                        callbacks: Y.bind(function (request) {
                            this._beforeRoute();
                            this.log('Router newpass form');
                            this.showView('user', { action: 'newpass', hash: request.params.hash });
                            this._afterRoute(request);
                        }, this)
                    },
                    {
                        path: '/user/upgrade/:plan/:status',
                        target: 'default',
                        callbacks: Y.bind(function (request) {
                            this._beforeRoute();
                            this.log('User upgrade');
                            this.showView('user', {
                                action  : 'upgrade',
                                plan    : request.params.plan,
                                status  : request.params.status
                            });
                            this._afterRoute(request);
                        }, this)
                    },
                    {
                        path: '/artist/profile',
                        target: 'artist_profile',
                        callbacks: Y.bind(function (request) {
                            this._beforeRoute();
                            this.log('Router artist');
                            if (window.appConfig.user) {
                                if (window.appConfig.user.role == 2) {
                                    this.showView('artist', { action: 'profile' });
                                } else {
                                    this.redirect('/promoter/bookings');
                                }
                            } else {
                                this.redirect('/user/login');
                            }
                            this._afterRoute(request);
                        }, this)
                    },
                    {
                        path: '/artist/bookings',
                        target: 'artist_booking_list',
                        callbacks: Y.bind(function (request) {
                            this._beforeRoute();
                            this.log('Router bookings');
                            if (window.appConfig.user) {
                                if (window.appConfig.user.role == 2) {
                                    this.showView('artist', { action: 'bookings' });
                                } else {
                                    this.redirect('/promoter/bookings');
                                }
                            } else {
                                this.redirect('/user/login');
                            }
                            this._afterRoute(request);
                        }, this)
                    },
                    {
                        path: '/artist/bookings/:id',
                        target: 'artist_booking',
                        callbacks: Y.bind(function (request) {
                            this._beforeRoute();
                            this.log('Router bookings');
                            if (window.appConfig.user) {
                                this.showView('artist', { action: 'bookings', id: request.params.id });
                            } else {
                                this.redirect('/user/login');
                            }
                            this._afterRoute(request);
                        }, this)
                    },
                    {
                        path: '/promoter/bookings',
                        target: 'promoter_booking_list',
                        callbacks: Y.bind(function (request) {
                            this._beforeRoute();
                            this.log('Router bookings');
                            if (window.appConfig.user) {
                                if (window.appConfig.user.role == 1) {
                                    this.showView('promoter', {action: 'bookings'});
                                } else {
                                    this.redirect('/artist/bookings');
                                }
                            } else {
                                this.redirect('/user/login');
                            }
                            this._afterRoute(request);
                        }, this)
                    },
                    {
                        path: '/promoter/bookings/:id',
                        target: 'promoter_booking',
                        callbacks: Y.bind(function (request) {
                            this._beforeRoute();
                            this.log('Router bookings');
                            if (window.appConfig.user) {
                                if (window.appConfig.user.role == 1) {
                                    this.showView('promoter', {action: 'bookings', id: request.params.id});
                                } else {
                                    this.redirect('/artist/bookings');
                                }
                            } else {
                                this.redirect('/user/login');
                            }
                            this._afterRoute(request);
                        }, this)
                    },
                    {
                        path: '/promoter/events',
                        target: 'promoter_events',
                        callbacks: Y.bind(function (request) {
                            this._beforeRoute();
                            this.log('Router events');
                            if (window.appConfig.user) {
                                this.showView('promoter', { action: 'events' });
                            } else {
                                this.redirect('/user/login');
                            }
                            this._afterRoute(request);
                        }, this)
                    },
                    {
                        path: '/promoter/trackings',
                        target: 'promoter_trackings',
                        callbacks: Y.bind(function (request) {
                            this._beforeRoute();
                            this.log('Router trackings');
                            if (window.appConfig.user) {
                                this.showView('promoter', { action: 'trackings' });
                            } else {
                                this.redirect('/user/login');
                            }
                            this._afterRoute(request);
                        }, this)
                    },
                    {
                        path: '/promoter/profile',
                        target: 'promoter_profile',
                        callbacks: Y.bind(function (request) {
                            this._beforeRoute();
                            this.log('Router profile');
                            if (window.appConfig.user) {
                                this.showView('promoter', { action: 'profile' });
                            } else {
                                this.redirect('/user/login');
                            }
                            this._afterRoute(request);
                        }, this)
                    },
                    {
                        path: '/promoter/list',
                        target: 'promoter',
                        callbacks: Y.bind(this.showList, this)
                    },
                    {
                        path: '/promoter/:alias',
                        target: 'promoter',
                        callbacks: Y.bind(this.showItem, this)
                    },
                    {
                        path: '/gig/list',
                        target: 'gig',
                        callbacks: Y.bind(this.showList, this)
                    },
                    {
                        path: '/gig/:alias',
                        target: 'gig',
                        callbacks: Y.bind(this.showItem, this)
                    },
                    {
                        path: '/venue/list',
                        target: 'venue',
                        callbacks: Y.bind(this.showList, this)
                    },
                    {
                        path: '/venue/:alias',
                        target: 'venue',
                        callbacks: Y.bind(this.showItem, this)
                    },
                    {
                        path: '/terms',
                        target: 'terms',
                        callbacks: Y.bind(this.showPage, this)
                    },
                    {
                        path: '/privacy',
                        target: 'privacy',
                        callbacks: Y.bind(this.showPage, this)
                    },
                    {
                        path: '/team',
                        target: 'team',
                        callbacks: Y.bind(this.showPage, this)
                    },
                    {
                        path: '/about',
                        target: 'about',
                        callbacks: Y.bind(this.showPage, this)
                    },
                    {
                        path: '/contact',
                        target: 'contact',
                        callbacks: Y.bind(this.showPage, this)
                    },
                    {
                        path: '/pricing',
                        target: 'pricing',
                        callbacks: Y.bind(this.showPage, this)
                    },
                    {
                        path: '/artist/list',
                        target: 'artist',
                        callbacks: Y.bind(this.showList, this)
                    },
                    {
                        path: '/artist/add/:query',
                        target: 'artist_import',
                        callbacks: Y.bind(this.showAddForm, this)
                    },
                    {
                        path: '/artist/add/:query/:mild',
                        target: 'artist_import',
                        callbacks: Y.bind(this.showAddForm, this)
                    },
                    {
                        path: '/:alias/book',
                        target: 'artist_book',
                        callbacks: Y.bind(this.showBookForm, this)
                    },
                    {
                        path: '/:alias/book/:date',
                        target: 'artist_book',
                        callbacks: Y.bind(this.showBookForm, this)
                    },
                    {
                        path: '/:alias',
                        target: 'artist',
                        callbacks: Y.bind(this.showItem, this)
                    }
                ]
            });
        };
    }
},
'0.1',
{
    requires: [
        'router',
        'base-view',
        'log-extension'
    ]
});
