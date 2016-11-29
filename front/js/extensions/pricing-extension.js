YUI.add('pricing-extension', function (Y) {

    Y.PricingExtension = function () {

        this.bindPricingEvents = function () {
            var container = this.get('container');

            container.all('.more').on('click', Y.bind(function () {
                container.all('.more').addClass('hidden');
                container.all('.less').removeClass('hidden');
                container.all('.details').removeClass('hidden');
            }, this));

            container.all('.less').on('click', Y.bind(function () {
                container.all('.more').removeClass('hidden');
                container.all('.less').addClass('hidden');
                container.all('.details').addClass('hidden');
            }, this));

            container.one('#monthly').on('click', Y.bind(function () {
                container.one('#annually').removeClass('active');
                container.one('#monthly').addClass('active');
                container.all('.annually').addClass('hidden');
                container.all('.monthly').removeClass('hidden');
            }, this));

            container.one('#annually').on('click', Y.bind(function () {
                container.one('#annually').addClass('active');
                container.one('#monthly').removeClass('active');
                container.all('.annually').removeClass('hidden');
                container.all('.monthly').addClass('hidden');
            }, this));

            /*
            new Y.TooltipDelegate({
                trigger         : '.bg-tooltip',
                html            : true,
                opacity         : 1,
                formatter       : function(value) {
                    return Y.one('#' + value).getHTML()
                }
            });
            */
        };
    };
},
    '0.1',
{
    requires: [
        'aui-tooltip'
    ]
});
