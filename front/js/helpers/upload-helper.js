YUI.add('upload-helper', function (Y) {

    'use strict';

    Y.UploadHelper = Y.Base.create('uploadHelper', Y.BaseHelper, [], {

        config: {
            select_trigger  : '#image',
            cancel_target   : '#file_id',
            cancel_image    : '#file_image',
            cancel_trigger  : '#file_cancel'
        },

        initUploader: function (options) {
            // Update defaults
            for (var option in options) {
                if (this.config.hasOwnProperty(option)) {
                    this.config[option] = options[option];
                }
            }

            // More visual clearance
            var container = this.config.hasOwnProperty('container') ? this.config.container: this.get('container');

            // Create uploader
            var uploader = new Y.Uploader({
                width               : '120px',
                height              : '30px',
                selectButtonLabel   : 'Select',
                fileFieldName       : 'File[image]',
                fileFilters         : [{ description: "Images", extensions: "*.jpg;*.png;*.gif" }]
            }).render(
                container.one(this.config.select_trigger)
            );

            // Bind upload events
            uploader.on('fileselect', Y.bind(function() {
                uploader.uploadAll('/api/site/upload');
                this.showLoader();
            }, this));

            uploader.on('uploadcomplete', Y.bind(function(e) {
                this.hideLoader();

                var response = Y.JSON.parse(e.data);
                if (response.result == this.apiStatus.SUCCESS) {
                    container.one(this.config.cancel_target).set('value', response.file_id);
                    container.one(this.config.cancel_image).set('src', response.file_name);
                    container.one(this.config.cancel_trigger).removeClass('hidden');
                } else {
                    this.showOverlay(response.message);
                }
            }, this));

            uploader.on('uploaderror', Y.bind(function(e) {
                this.hideLoader();
                this.showOverlay(e.statusText);
            }, this));

            // Cancel action
            Y.delegate('click', Y.bind(function() {
                container.one(this.config.cancel_target).set('value', '');
                container.one(this.config.cancel_image).set('src',
                    container.one(this.config.cancel_image).getData('original')
                );
                container.one(this.config.cancel_trigger).addClass('hidden');
            }, this), container, this.config.cancel_trigger);
        }
    });
},
'0.7.1',
{
    requires: [
        'node',
        'base-helper',
        'overlay-extension'
    ]
});