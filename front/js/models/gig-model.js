YUI.add('gig-model', function(Y) {

    'use strict';

    Y.GigModel = Y.Base.create('gigModel', Y.BaseModel, [], {

        list: function(params) {
            var data = params ? params : {},
                callback = Y.bind(function (response) {
                    if (response.result == this.apiStatus.SUCCESS) {
                        this.set('list', response.data);
                        this.set('params', response.params);
                        this.fire('gig:list');
                    }
                }, this);

            this.getData('/api/gig/list', data, callback, this, true);
        },

        find: function(params) {
            var data = params ? params : {},
                callback = Y.bind(function (response) {
                    if (response.result == this.apiStatus.SUCCESS) {
                        this.fire('gig:show', { data: response.data });
                    }
                    if (response.result == this.apiStatus.NO_RECORDS) {
                        this.fire('gig:not-found');
                    }
                }, this);

            this.getData('/api/gig/find', data, callback, this, true);
        },

        getForBookingForm: function(params) {
            var data = params ? params : {},
                callback = Y.bind(function (response) {
                    if (response.result == this.apiStatus.SUCCESS) {
                        this.set('bookingFormData', response.data);
                        this.fire('gig:bookingForm');
                    }
                }, this);

            this.getData('/api/gig/form', data, callback, this, false);
        },

        bookingDetails: function(data) {
            var callback = Y.bind(function (response) {
                    if (response.result == this.apiStatus.SUCCESS) {
                        this.set('bookingDetails', response.data);
                        this.fire('gig:bookingDetails');
                    }
                }, this);

            this.getData('/api/promoter/bookingdetails', data, callback, this, false);
        }

    }, {
        ATTRS: {

            list: {
                value: null
            },

            bookingFormData: {
                value: null
            },

            params: {
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