YUI.add('form-extension', function (Y) {

    Y.FormExtension = function () {

        this.serializeToJSON = function (form) {
            var url_data = Y.IO.stringify(form),
                result = {}, fields, field;

            fields = url_data.split('&');
            for (var i = 0; i < fields.length; i++) {
                field = fields[i].split('=');
                result[field[0]] = typeof(field[1]) == 'undefined' || field[1] === null ? '' : decodeURIComponent(field[1]);
            }

            return result;
        };

        this.highlightErrors = function (form, message, errors) {
            message += '<ul class="error-list">';
            for (var i = 0; i < errors.length; i++) {
                message += '<li>' + errors[i].message + '</li>';

                form.one('#' + errors[i].field).addClass('error');
                form.one('#' + errors[i].field + '-error').setHTML(errors[i].message);

                form.one('#' + errors[i].field).on('focus', function() {
                    this.removeClass('error');
                    form.one('#' + this.getAttribute('id') + '-error').setHTML('');
                });
            }
            message += '</ul>';
            this.showOverlay(message);
        };

        this.renderDateTimePickers = function () {
            // Calendar widget
            var datepickers = new Y.DatePicker({
                    trigger     : '.datepicker',
                    mask        : '%d.%m.%Y',
                    popover     : {
                        zIndex  : 100
                    }
                }),
                timepickers = new Y.TimePicker({
                    trigger     : '.timepicker',
                    popover     : {
                        zIndex  : 100
                    }
                });
        };

        this.renderVenueAutocomplete = function () {
            var container = this.get('container'),
                autocomplete = new google.maps.places.Autocomplete(document.getElementById('venue'));

            google.maps.event.addListener(autocomplete, 'place_changed', Y.bind(function() {
                var place = autocomplete.getPlace();

                // Fix coords for JSON serialization
                place.latitude = place.geometry.location.lat();
                place.longitude = place.geometry.location.lng();

                // Check coords
                if (!place.latitude || !place.longitude) {
                    this.showOverlay('Please select valid place');
                } else {
                    container.one('#venue_data').set('value', Y.JSON.stringify(place));
                    container.one('#address').set('value', place.formatted_address);
                }
            }, this));
        };

    };

},
'0.1',
{
    requires: [
        'node',
        'io-form'
    ]
});
