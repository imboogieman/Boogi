YUI.add('loader-extension', function (Y) {

    Y.LoaderExtension = function () {

        // Show loader
        this.showLoader = function () {
            Y.one('#loader').removeClass('hidden');
        };

        // Hide loader
        this.hideLoader = function () {
            Y.one('#loader').addClass('hidden');
        };
    };
},
'0.1',
{
    requires: [
    ]
});
