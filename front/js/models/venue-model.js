YUI.add('venue-model', function(Y) {

    'use strict';

    Y.VenueModel = Y.Base.create('venueModel', Y.BaseModel, [], {

        list: function() {
            var data = {},
                callback = Y.bind(function (response) {
                    if (response.result == this.apiStatus.SUCCESS) {
                        this.set('list', response.data);
                        this.fire('venue:list');
                    }
                }, this);

            this.getData('/api/venue/list', data, callback, this, true);
        }

    }, {
        ATTRS: {

            list: {
                value: null
            }

        }
    });
},
'0.1',
{
    requires: [
        'base-model'
    ]
});