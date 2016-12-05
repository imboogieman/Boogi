YUI.add('overlay-extension', function (Y) {

    Y.OverlayExtension = function () {

        this.showOverlay = function (content, is_message) {
            if (content) {
                Y.one('#overlay .content').setHTML(content);
                Y.one('#overlay').removeClass('hidden');

                Y.one('#overlay').on('click', Y.bind(function() {
                    this.hideOverlay();
                }, this));

                if (!is_message) {
                    setTimeout(Y.bind(function () {
                        this.hideOverlay();
                    }, this), 5000);
                } else {
                    Y.one('#overlay').addClass('message');
                }
            }
        };

        this.showLoginOverlay = function (content, data) {
            if (content) {
                // Extract the template string and compile it into a reusable function.
                var container = Y.one('#overlay .content'),
                    source   = Y.one('#t-user-login-button').getHTML(),
                    template = Y.Handlebars.compile(source),
                    html;

                // Render the template to HTML using the specified data
                // And append the rendered template to the page.
                html = template({
                    fbLoginUrl  : window.appConfig.params.fbLoginUrl
                });
                // Render the template to HTML using the specified data
                // And append the rendered template to the page.
                container.setHTML('<h4>' + content + '</h4>' + html);

                Y.one('#overlay').removeClass('hidden');
                //Y.one('#overlay .content').addClass('red').setHTML(content);
                //Y.one('#overlay .login').removeClass('hidden');
                //Y.one('#overlay').removeClass('hidden');
                //
                //Y.one('#overlay .close-button').on('click', Y.bind(function() {
                //    this.hideOverlay();
                //}, this));
                //
                //Y.one('#overlay #login-overlay').on('click', Y.bind(function() {
                //    this.hideOverlay();
                //
                //    var model = new Y.UserModel;
                //
                //    model.login({
                //        email       : Y.one('#overlay #email-overlay').get('value'),
                //        password    : Y.one('#overlay #password-overlay').get('value')
                //    });
                //
                //    model.once('user:login', Y.bind(function() {
                //        var model = new Y.BaseModel,
                //            view = new Y.ToolbarExtension;
                //
                //        view.renderToolbar();
                //        model.getData(data.url, data.data, data.callback, data.context, data.showLoader);
                //    }, this));
                //}, this));

                if (!Y.one('#overlay .mask.trigger-click')) {
                    Y.all('#overlay .mask, #overlay .close-button').on('click', Y.bind(function () {
                        Y.all('#overlay .mask').addClass('trigger-click');
                        this.hideOverlay();
                    }, this));
                }
            }
        };

        this.hideOverlay = function () {
            Y.one('#overlay .content').removeClass('red').setHTML('');
            Y.one('#overlay .login').addClass('hidden');
            Y.one('#overlay').addClass('hidden').removeClass('message');
        }
    };
},
'0.1',
{
    requires: [
        'node'
    ]
});
