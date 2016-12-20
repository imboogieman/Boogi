YUI.add('user-view', function(Y) {

    'use strict';

    Y.UserView = Y.Base.create('userView', Y.BaseView, [Y.FormExtension, Y.ToolbarExtension, Y.LoaderExtension, Y.GenresExtension], {

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
        genresData: {
            items: {},
            minCountItems: 3,
            placeholder: [
                'select another genre',
                'select two more genre',
                '3 minimum'
            ]
        },
        lehgthArtistItems: 0,
        selectingArtists: 0,

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
                radius      : this.radius / 1000,
                fbLoginUrl  : window.appConfig.params.fbLoginUrl,
                address     : window.appConfig.params.defaultPosition.address,
                imageOops   : '/images/Oops.png',
                genres      : this.getGenresList()

            });
            // Render the template to HTML using the specified data
            // And append the rendered template to the page.
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
                case 'fbRegister':
                    this.fbRegisterForm();
                    break;
                case 'createPage':
                    this.createPageForm();
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

            Y.delegate('click', Y.bind(function(e) {
                this.redirect('/');
            }, this), this.get('container').one('#login-form'), '.top-tab i');
        },

        registerForm: function() {
            this.log('Show register form');
            var container = this.get('container');
            container.all('.form').addClass('hidden');
            container.one('#register-form').removeClass('hidden');

            Y.delegate('click', Y.bind(function(e) {
                this.redirect('/');
            }, this), this.get('container').one('#register-form'), '.top-tab i');
        },

        fbRegisterForm: function() {
            var   container = this.get('container')
                , data = {};

            this.log('Show facebook register form');

            var html = Y.one('html'),
                toggler = container.all('.dropdown-toggle'),
                dropdown = container.all('.dropdown');

            toggler.on('click', function(e) {
                dropdown.toggleClass('open');
                e.preventDefault();
                e.stopPropagation();
            });

            html.on('click', function() {
                if (dropdown.hasClass('open'))
                    dropdown.removeClass('open');
            });

            //date_options.trigger = '#founding-date';
            //var foundingDate = new Y.DatePicker(date_options);

            var genresList = container.one('.genres-list');
            this.genresData.items = genresList.all('li');

            this.model.fbRegister();

             //Get facebook register info
            this.model.once('user:fb-register', Y.bind(function(e) {
                if (e.response.result == this.apiStatus.SUCCESS) {
                    data.pages = e.response.pages.data;
                    data.profile = e.response.profile;

                    if (data.pages.length > 0) {
                        this.setPages(data.pages, '#pages .dropdown-menu');
                        this.setUserAccount(data.profile);
                    } else {
                        container.all('.tab-form').addClass('hidden');
                        container.one('#create-page').removeClass('hidden');
                    }

                    VMasker(document.getElementById('founding-date')).maskPattern("9999");

                    this.model.getRecommendedArtists();

                    var autocomplete = new google.maps.places.Autocomplete(
                        container.one('#address-company').getDOM(),
                        {
                            types: ['(regions)']
                        }
                    );

                    container.all('.form').addClass('hidden');
                    container.one('#fb-form').removeClass('hidden');
                } else {
                    this.showOverlay(e.response.message);
                    this.redirect('/user/login');
                }
            }, this));

            this.model.once('user:get-artists', Y.bind(function(e) {
                if (e.response.result == this.apiStatus.SUCCESS) {
                    var source   = Y.one('#t-s-up-recom-art').getHTML(),
                    template = Y.Handlebars.compile(source),
                    html;
                    Y.Handlebars.registerHelper('ifNotEven', function (item, options) {
                        if (item % 2 === 0) {
                            return options.fn(this);
                        }
                        return options.inverse(this);
                    });

                    html = template({artists: e.response.data});

                    container.one('.artist-items').setHTML(html);
                    this.lehgthArtistItems = e.response.data.length;
                }  else {
                    this.showOverlay(e.response.message);
                    this.redirect('/user/login');
                }
            }, this));

            Y.delegate('click', Y.bind(function(e) {
                this.selectingArtist(e);
            }, this), container.one('.artist-items'), '.artist-item');

            Y.delegate('click', Y.bind(function(e) {
                this.deleteArtist(e);
            }, this), container.one('.artist-items'), '.cross');

            Y.delegate('click', Y.bind(function(e) {
                var target = e.target.getData('target')
                    , current = e.target.getData('current')
                    , error = []
                    , wrapper = container.one('.wrap .wrapper');

                if (target == 'root') this.redirect('/');

                if (target == 'conpany-detail') {
                    if (!wrapper.hasClass('map-run')) {
                        this.setCompanyDetails(data.pages, container.one('#pages').getData('val'));
                    }

                }

                if (target == 'genres-artist') {
                    if (wrapper.hasClass('width-590'))
                        wrapper.removeClass('width-590');
                }

                if (target == 'location') {
                    if (!wrapper.hasClass('map-run')) {
                        wrapper.addClass('map-run');
                        this.renderProfileMapControl();
                    }
                    if (!wrapper.hasClass('width-590'))
                        wrapper.addClass('width-590');
                }

                if (target == 'favorite-artists') {
                    this.showFavoriteArtists();
                }

                this.validateSubForm(current, error);

                if (!e.target.hasClass('disabled')) {
                    if (error.length < 1) {
                        container.all('.tab-form').addClass('hidden');
                        container.one('#' + target).removeClass('hidden');
                    } else {
                        error.forEach(function (er) {
                            container.one('#' + er.id + '-error').setHTML(er.mess);
                        });
                    }
                }
            }, this), container, '.buttons .button, .top-tab .back');

            Y.delegate('click', Y.bind(function(e) {
                this.redirect('/');
            }, this), container.one('#fb-form'), '.top-tab i');

            Y.delegate('change', Y.bind(function(e) {
                var id = e.target.getAttribute('id');
                var cError = container.one('#' + id + '-error');
                if (cError) cError.setHTML();
            }, this), container.one('#fb-form'), 'input, select');

            container.one('#pages').once('c:change', Y.bind(function(e) {
                var button = container.one('#choose-pages .buttons .button');
                button.removeClass('disabled');
            }, this));

            Y.delegate('keyup', Y.bind(function(e) {
                var inputs = container.all('#user-account .row input');
                var trigger = true;
                inputs.each(function(el){
                    if (el.get('value') === '')
                        trigger = false;
                    return false;
                });
                if (trigger) {
                    var button = container.one('#user-account .buttons .button');
                    button.removeClass('disabled');
                }
            }, this), container.one('#fb-form'), '#user-account .row input');

            container.one('#categories').once('c:change', Y.bind(function(e) {
                var button = container.one('#conpany-detail .buttons .button');
                button.removeClass('disabled');
            }, this));

            Y.delegate('focus', Y.bind(function(e) {
                var inputWrap = e.target.ancestor();
                inputWrap.addClass('selected');
            }, this), container.one('#fb-form'), '#genres');

            Y.delegate('blur', Y.bind(function(e) {
                var inputWrap = e.target.ancestor();
                inputWrap.removeClass('selected');
            }, this), container.one('#fb-form'), '#genres');

            Y.delegate('keydown', Y.bind(function(e) {
                var input = e.target;
                var val = input.get('value');

                if (val === '') {
                    genresList.addClass('hidden');
                    if (e.keyCode == 8 || e.keyCode == 46) {
                        var gItem = input.previous('.g-item');
                        if (gItem) gItem.remove(true);
                        this.genresData.minCountItems ++;
                        var placeholder = '';
                        if (this.genresData.minCountItems - 1 > -1) {
                            placeholder = this.genresData.placeholder[this.genresData.minCountItems - 1]
                        }
                        input.set('placeholder', placeholder);
                    }
                }
            }, this), container.one('#fb-form'), '#genres');

            Y.delegate('keyup', Y.bind(function(e) {
                var input = e.target;
                var val = input.get('value');

                if (val !== '') {
                    this.searchGenres(val);
                    genresList.removeClass('hidden');
                }
            }, this), container.one('#fb-form'), '#genres');

            Y.delegate('click', Y.bind(function(e) {
                var button = container.one('#genres-artist .buttons .button');
                var containgerG = container.one('.conteiner-genres');
                var inputG = container.one('#genres');
                var val = e.target.getHTML();
                var gItem = Y.Node.create('<span class="g-item"><span class="val">' + val + '</span><i>&#10005;</i></span>');
                containgerG.insertBefore(gItem, inputG);
                this.genresData.minCountItems --;
                var placeholder = '';
                if (this.genresData.minCountItems - 1 > -1) {
                    placeholder = this.genresData.placeholder[this.genresData.minCountItems - 1]
                } else {
                    button.removeClass('disabled');
                }

                inputG.set('placeholder', placeholder);
                inputG.set('value', '');
                inputG.focus();

                Y.delegate('click', Y.bind(function(e) {
                    gItem.remove(true);
                    this.genresData.minCountItems ++;
                    var placeholder = '';
                    if (this.genresData.minCountItems - 1 > -1) {
                        placeholder = this.genresData.placeholder[this.genresData.minCountItems - 1]
                    }
                    inputG.set('placeholder', placeholder);
                }, this), gItem, 'i');

                genresList.addClass('hidden');
            }, this), container.one('#fb-form'), '.genres-list li');

            Y.delegate('click', Y.bind(function(e) {
                this.log('Submit register form');
                var d = this.prepareDataSubmitRegister(data.pages);
                this.model.submitRegister(d);
            }, this), container.one('#fb-form'), '#submit');

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
                //this.highlightErrors(form, e.message, e.errors);
                //window.app.track('User', 'Register', 'Error');
                this.redirect('/');
            }, this));
        },

        createPageForm: function() {
            this.log('Show create page form');

            this.get('container').all('.form').addClass('hidden');
            this.get('container').one('#fb-form-create-page').removeClass('hidden');
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

        //register: function() {
        //    this.log('Submit register form');
        //
        //    var form = this.get('container').one('#register-form'),
        //        data = this.serializeToJSON(form);
        //
        //    this.model.register(data);
        //
        //    this.model.once('user:registered', Y.bind(function(e) {
        //        this.renderToolbar();
        //        this.showOverlay(e.message, true);
        //
        //        if (window.appConfig.user.role == 1) {
        //            window.app.track('User', 'Register', 'Promoter');
        //            this.redirect('/promoter/profile');
        //        } else {
        //            window.app.track('User', 'Register', 'Artist');
        //            this.redirect('/artist/profile');
        //        }
        //    }, this));
        //
        //    this.model.once('user:register-invalid', Y.bind(function(e) {
        //        this.highlightErrors(form, e.message, e.errors);
        //        window.app.track('User', 'Register', 'Error');
        //    }, this));
        //},

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
        },
        prepareDataSubmitRegister: function(pages) {
            var form = Y.one('#fb-form');
            var genres = '';
            var gItems = form.all('.conteiner-genres .g-item .val');
            gItems.each(function(el, indx){
                var pref = '';
                if (indx > 0)
                    pref = ', ';
                genres += pref + el.getHTML();
            });
            var fArtists = '';
            var aItems = form.all('.artist-items .artist-item h5');
            aItems.each(function(el, indx){
                var pref = '';
                if (indx > 0)
                    pref = ', ';
                fArtists += pref + el.getHTML();
            });
            var lat = window.appConfig.params.currentPosition.latitude !== '' ?
                window.appConfig.params.currentPosition.latitude : window.appConfig.params.defaultPosition.latitude;
            var lng = window.appConfig.params.currentPosition.longitude !== '' ?
                window.appConfig.params.currentPosition.longitude : window.appConfig.params.defaultPosition.longitude;
            var data = {
                page: form.one('#pages .dropdown-toggle .val').getHTML(),
                name: form.one('#f-name').get('value') + ' ' + form.one('#l-name').get('value'),
                fbId: pages[form.one('#pages').getData('val')].id,
                email: form.one('#fb-email').get('value'),
                pass: form.one('#fb-password').get('value'),
                genres: genres,
                experience: form.one('#experience').get('value'),
                address: form.one('#address').get('value'),
                lat: lat,
                lng: lng,
                radius: form.one('#radius').get('value')*1000,
                fArtists: fArtists,
                cName: form.one('#conmpany-name').get('value'),
                category: form.one('#categories .dropdown-toggle .val').getHTML(),
                cAddress: form.one('#address').get('value'),
                foundingDate: form.one('#founding-date').get('value'),
                phone: form.one('#phone').get('value').replace(/[^0-9]/g, ''),
                website: form.one('#website').get('value'),
                description: form.one('#description').get('value')
            };

            return data;
        },
        selectingArtist: function(e) {
            if (!e.target.hasClass('cross')) {
                var button = Y.one('#fb-form #favorite-artists .buttons .button');
                var container = Y.one('#fb-form #favorite-artists .artist-items');

                if (e.target.hasClass('selected-up')) {
                    e.target.removeClass('selected-up');
                    this.selectingArtists--;
                } else {
                    e.target.addClass('selected');
                    setTimeout(function(){
                        e.target.removeClass('selected');
                        e.target.addClass('selected-up');
                        container.prepend(e.target);
                    }, 700);
                    this.selectingArtists++;
                }

                if (this.selectingArtists > 4) {
                    button.removeClass('disabled');
                } else {
                    button.addClass('disabled');
                }
            }
        },
        deleteArtist: function(e) {
            var artistItem = e.target.ancestor('.artist-item');
            if (artistItem.hasClass('selected'))
                this.selectingArtists --;
            artistItem.remove(true);
            this.lehgthArtistItems--;
        },
        showFavoriteArtists: function() {
            var container = this.get('container');
            var params = {
                source              : '/api/user/searchartist?q={query}',
                minQueryLength      : 3,
                resultListLocator   : 'data',
                resultTextLocator   : function(){return '';},
                resultHighlighter   : 'phraseMatch',
                resultFormatter     : function (query, results) {
                    var source      = Y.one('#t-s-up-ac-item').getHTML(),
                        template    = Y.Handlebars.compile(source);

                    return Y.Array.map(results, function (result) {
                        return template(result.raw);
                    });
                },
                on : {
                    select : Y.bind(function(e) {
                        var artistItems = container.one('.artist-items');
                        var length = this.lehgthArtistItems++;
                        var name = e.itemNode.one('h5').getHTML();
                        var location = e.itemNode.one('.location').getHTML();
                        var image = e.itemNode.one('img').get('src');
                        if (name !== 'Artist not finded') {
                            var source   = Y.one('#t-s-up-recom-art').getHTML(),
                                template = Y.Handlebars.compile(source),
                                html;
                            Y.Handlebars.registerHelper('ifNotEven', function (item, options) {
                                if (length % 2 === 0) {
                                    return options.fn(this);
                                }
                                return options.inverse(this);
                            });

                            html = template({
                                artists: [
                                    {
                                        name: name,
                                        location: location,
                                        image: image
                                    }
                                ]
                            });

                            var aItem = Y.Node.create(html);

                            Y.delegate('click', Y.bind(function(e) {
                                this.selectingArtist(e);
                            }, this), aItem, '');

                            Y.delegate('click', Y.bind(function(e) {
                                this.deleteArtist(e);
                            }, this), aItem, '.cross');

                            artistItems.append(aItem);
                        }
                    }, this)
                }
            };
            var ac_input = container.one('#s-up-ac-input').plug(Y.Plugin.AutoComplete, params);
            Y.one('#s-up-ac-submit').on('click', Y.bind(function() {
                ac_input.ac.sendRequest('');
            }, this));
        },
        renderProfileMapControl: function() {
            var container = this.get('container');

            // LatLon map
            var options = window.appConfig.mapOptions;
            options.center = this.center;
            options.zoom = 3;
            this.map = new google.maps.Map(document.getElementById('profile-map'), options);

            var geocoder = new google.maps.Geocoder();

            if (this.getLocation()) {
                geocoder.geocode({ location: this.getLocation() }, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK && results.length) {
                        container.one('#address').set('value', results[0].formatted_address);
                    }
                });
            }

            var autocomplete = new google.maps.places.Autocomplete(
                container.one('#address').getDOM(),
                {
                    types: ['(regions)']
                }
            );

            // User marker
            var marker = new google.maps.Marker({
                position: this.getLocation() || this.center,
                map: this.map,
                draggable: true,
                title: 'Your current position',
                icon: '/images/marker/m-promoter.png'
            });

            // User radius
            var radius = window.appConfig.params.defaultPosition.radius,
                circle = new google.maps.Circle({
                    map: this.map,
                    radius: parseInt(radius),
                    editable: true,
                    fillColor: '#80CFFF',
                    strokeColor: "#0066A4",
                    strokeOpacity: 0.8,
                    strokeWeight: 2
                });
            circle.bindTo('center', marker, 'position');

            // Update user position with radius update
            google.maps.event.addListener(marker, 'dragend', function () {

                circle.setCenter(this.getPosition());

                // Update location field
                window.appConfig.params.currentPosition.latitude = this.getPosition().lat();
                window.appConfig.params.currentPosition.longitude = this.getPosition().lng();
                geocoder.geocode({ location: this.getPosition() }, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK && results.length) {
                        container.one('#address').set('value', results[0].formatted_address);
                    }
                });
            });

            var block = false;

            // Update radius slider on map circle change
            google.maps.event.addListener(circle, 'radius_changed', function () {
                if (!block)
                    container.one('#radius').set('value', Math.round(this.getRadius() / 1000));
                block = false;
            });

            Y.delegate('keyup', Y.bind(function(e) {
                block = true;
                circle.setRadius(parseInt(e.target.get('value'))*1000);
            }, this), container, '#radius');

            Y.delegate('keyup', Y.bind(function(e) {
                if (e.keyCode === 13) {
                    this.setAddress(e, geocoder, marker, circle);
                }
            }, this), container, '#address');

            Y.delegate('blur', Y.bind(function(e) {
                this.setAddress(e, geocoder, marker, circle);
            }, this), container, '#address');
        },
        setAddress: function(e, geocoder, marker, circle) {
            var _this = this;
            geocoder.geocode( { 'address': e.target.get('value')}, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    var cityLat = results[0].geometry.location.lat();
                    var cityLng = results[0].geometry.location.lng();
                    var option = new google.maps.LatLng(cityLat, cityLng);
                    _this.map.setCenter(option);
                    marker.setPosition(option);
                    circle.bindTo('center', marker, 'position');
                    window.appConfig.params.currentPosition.latitude = cityLat;
                    window.appConfig.params.currentPosition.longitude = cityLng;
                }
            });
        },
        getLocation: function() {
            if (navigator.geolocation) {
                return navigator.geolocation.getCurrentPosition(function(position){
                    return {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    }
                });
            }
            return false;
        },

        validateSubForm: function(current, error) {
            var container = this.get('container');
            switch (current) {
                case 'choose-pages':
                    if (container.one('#pages').get('value') === 'Select')
                        error.push({id: 'pages', mess: 'Page is not selected'});
                    break;
                case 'user-account':
                    var fName = container.one('#f-name').get('value');
                    var lName = container.one('#l-name').get('value');
                    var email = container.one('#fb-email').get('value');
                    var pass = container.one('#fb-password').get('value');
                    //var cPass = container.one('#c-password').get('value');
                    if ( fName === '')
                        error.push({id: 'f-name', mess: 'Please enter your first name'});
                    else if (!this.valOnlyChars(fName))
                        error.push({id: 'f-name', mess: 'Please enter a valid first name (only chars)'});

                    if ( lName === '')
                        error.push({id: 'l-name', mess: 'Please enter your last name'});
                    else if (!this.valOnlyChars(lName))
                        error.push({id: 'l-name', mess: 'Please enter a valid last name (only chars)'});

                    if ( email === '')
                        error.push({id: 'fb-email', mess: 'Please enter your email'});
                    else if (!this.valEmail(email))
                        error.push({id: 'fb-email', mess: 'Please enter a valid email'});

                    if (pass === '' )
                        error.push({id: 'fb-password', mess: 'Please enter your password'});
                    //else if (cPass === '' )
                    //    error.push({id: 'c-password', mess: 'Please confirm your password'});
                    //if (pass !== cPass)
                    //    error.push({id: 'c-password', mess: 'your password is not match'});

                    break;
                case 'conpany-detail':
                    var cName = container.one('#conmpany-name').get('value');
                    var category = container.one('#categories').get('value');
                    var phone = container.one('#phone').get('value');

                    if ( cName === '')
                        error.push({id: 'conmpany-name', mess: 'Please enter your company name'});
                    else if (!this.valString(cName))
                        error.push({id: 'f-name', mess: 'Please enter a valid company name'});

                    if (category === 'Select')
                        error.push({id: 'categories', mess: 'Category is not selected'});

                    if ( phone === '')
                        error.push({id: 'phone', mess: 'Please enter your phone'});
                    else if (!this.valPhone(phone))
                        error.push({id: 'phone', mess: 'Please enter a valid phone'});

                    break;
                case '':
                    break;
                default:
                    break;
            }
        },
        valOnlyChars: function(str) {
            if (str.match(/[^a-zA-Zа-яА-Я]*/i)[0] === '') return true;
            return false;
        },
        valString: function(str) {
            if (str.match(/[^\w#'"%&_=+-]*/i)[0] === '') return true;
            return false;
        },
        valEmail: function(str) {
            if (str.match(/^[A-Za-z0-9._-]+[^.]+@[^@]+[A-Za-z_-]+\.[A-Za-z]+$/)) return true;
            return false;
        },
        valPhone: function(str) {
            if (str.match(/[^\d()]*/i)[0] === '') return true;
            return false;
        },
        setPages: function(pages, selection) {
            var options = '';
            pages.forEach(function(page, indx){
                options += '<li data-value="' + indx + '">' + page.name + '</li>';
            });

            Y.one(selection).setHTML(options);

            var dpMenu = Y.one(selection).all('li');
            dpMenu.on('click', function(e) {
                var dp = e.target.ancestor('.dropdown');
                dp.one('.dropdown-toggle span.val').setHTML(e.target.getHTML());
                dp.setData('val', e.target.getData('value'));
                dp.toggleClass('open');
                if (dp.hasClass('none'))
                    dp.removeClass('none');
                dp.fire('c:change');
                e.preventDefault();
                e.stopPropagation();
            });
        },
        setUserAccount: function(profile) {
            if (profile.first_name) Y.one('#f-name').set('value', profile.first_name);
            if (profile.last_name) Y.one('#l-name').set('value', profile.last_name);
            if (profile.email) Y.one('#fb-email').set('value', profile.email);
        },
        setCompanyDetails: function(pages, pageId) {
            var page = pages[pageId];
            var options = '';
            if (page.category_list) {
                page.category_list.forEach(function (category) {
                    options += '<li data-value="' + category.name + '">' + category.name + '</li>';
                });
            } else {
                var category = page.category || 'Uncategories';
                options += '<li data-value="' + category + '">' + category + '</li>';
            }
            Y.one('#categories .dropdown-menu').setHTML(options);

            var dpMenu = Y.one('#categories').all('li');
            dpMenu.on('click', function(e) {
                var dp = e.target.ancestor('.dropdown');
                dp.one('.dropdown-toggle span.val').setHTML(e.target.getHTML());
                dp.setData('val', e.target.getData('value'));
                dp.toggleClass('open');
                if (dp.hasClass('none'))
                    dp.removeClass('none');
                dp.fire('c:change');
                e.preventDefault();
                e.stopPropagation();
            });

            var des = page.description !== '' ? page.description : page.description_html;
            if (page.name) Y.one('#conmpany-name').set('value', page.name);
            if (page.single_line_address) Y.one('#address-company').set('value', page.single_line_address);
            if (page.founded) {
                Y.one('#founding-date').set('value', VMasker.toPattern(page.founded, "9999"));
            } else if (page.start_info && page.start_info.date && page.start_info.date.year) {
                Y.one('#founding-date').set('value', VMasker.toPattern(page.start_info.date.year, "9999"));
            }
            if (page.phone) {
                if (page.phone.valueOf().length == 12) {
                    Y.one('#phone').set('value', VMasker.toPattern(page.phone, "99 (999) 999-9999"));
                    VMasker(document.getElementById('phone')).maskPattern("99 (999) 999-9999");
                } else {
                    VMasker(document.getElementById('phone')).maskPattern("(999) 999-9999");
                    Y.one('#phone').set('value', VMasker.toPattern(page.phone, "(999) 999-9999"));
                }
            } else {
                this.model.getCallingCode();
                //Get calling code
                this.model.once('user:callingcode', Y.bind(function(e) {
                    VMasker(document.getElementById('phone')).maskPattern("99 (999) 999-9999");
                    Y.one('#phone').set('value', VMasker.toPattern(e.code, "99 (999) 999-9999"));
                }, this));
            }
            if (page.website) Y.one('#website').set('value', page.website);
            if (des) Y.one('#description').setHTML(des);
        },
        searchGenres: function(val) {
            var genresList = this.get('container').one('.genres-list');
            var gList = this.genresData.items;
            var gArray = [];
            var pattern = new RegExp(val, 'i');
            var html = '';
            gList.each(function(el){
                gArray.push(el);
            });

            var result = gArray.filter(function(obj){
                if (obj.getHTML().match(pattern)
                    && obj.getHTML().match(pattern)[0] !== '') {
                    return true;
                } else {
                    return false;
                }
            });
            result.forEach(function(el){
                html += el.outerHTML();
            });
            genresList.setHTML(html);
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
        'map-extension',
        'aui-dropdown',
        'aui-timepicker',
        'genres-extension',
        'toolbar-extension',
        'autocomplete'
    ]
});
