YUI.add('follow-extension', function (Y) {

    Y.FollowExtension = function () {

        this.initFollowEvents = function() {
            // Init base model
            this.model = this.get('model');

            // Init clicks
            Y.delegate('click', Y.bind(function(e) {
                e.preventDefault();

                var id = e.target.getAttribute('data-id'),
                    type = e.target.getAttribute('data-type');

                this.follow(id, type, e.target);

                return false;
            }, this), 'body', '.follow-item');
        };

        this.follow = function(id, type, target) {
            this.log('Follow ' + type + ' #' + id);

            if (!target.ancestor('span').hasClass('following')) {
                this.model.follow(id, type);
                this.model.once('item:follow', function(e) {
                    this.log('Item followed');

                    if (e.response.result == this.apiStatus.SUCCESS && target.ancestor('span')) {
                        target.ancestor('span')
                            .removeClass('follow bg-blue')
                            .addClass('following bg-orange');

                        target.setHTML('Unfollow');
                    }
                });

                if (window.appConfig.user) {
                    if (window.appConfig.user.role == 1) {
                        window.app.track('Promoter', 'Follow');
                    } else {
                        window.app.track('Artist', 'Follow');
                    }
                } else {
                    window.app.track('User', 'Follow');
                }
            } else {
                this.model.unfollow(id, type);
                this.model.once('item:unfollow', function(e) {
                    this.log('Item unfollowed');

                    if (e.response.result == this.apiStatus.SUCCESS && target.ancestor('span')) {
                        // Update promoter dashboard
                        if (target.ancestor('#trackings')) {
                            target.ancestor('.item').remove();
                        } else {
                            // Simply change follow button
                            target.ancestor('span')
                                .removeClass('following bg-orange')
                                .addClass('follow bg-blue');

                            target.setHTML('Follow');
                        }
                    }
                });
            }
        };

    };
},
'0.1',
{
    requires: [
        'node',
        'log-extension'
    ]
});
