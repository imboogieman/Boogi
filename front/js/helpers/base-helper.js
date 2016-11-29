YUI.add('base-helper', function (Y) {

    'use strict';

    Y.BaseHelper = Y.Base.create('baseApp', Y.Base, [], {

        // @TODO: Implement helpers
        init: function (options) {
            for (var option in options) {
                if (this.options.hasOwnProperty(option)) {
                    this.options[option] = options[option];
                }
            }
        }
    });

},
'0.7.1',
{
    requires: []
});