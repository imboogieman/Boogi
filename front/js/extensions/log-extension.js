YUI.add('log-extension', function (Y) {

    Y.LogExtension = function () {

        this.log = function (msg, type) {
            if (window.appConfig.isDebug) {
                if (typeof msg === 'object') {
                    Y.log(msg);
                } else {
                    type = type || 'info';
                    Y.log(msg, type, this.name);
                }
            }
        };

    };

});
