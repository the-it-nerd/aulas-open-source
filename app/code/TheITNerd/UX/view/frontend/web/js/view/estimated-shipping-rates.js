define([
    'uiComponent',
    'ko',
    'TheITNerd_UX/js/model/estimated-shipping-methods',
    'escaper',
], function(Component, ko, estimatedShippingMethodsModel, escaper) {
    'use strict';

    return Component.extend({
        model: estimatedShippingMethodsModel,

        initialize: function () {
            this._super();
        },

        isEstimatedShippingRatesVisible: function() {
            return this.model.rates().length > 0;
        },

        /**
         * Prepare the given message to be rendered as HTML
         *
         * @param {String} message
         * @return {String}
         */
        prepareMessageForHtml: function (message) {
            return escaper.escapeHtml(message, this.allowedTags);
        }

    })
})
