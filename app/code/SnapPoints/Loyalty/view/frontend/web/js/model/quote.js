// app/code/YourVendor/YourModule/view/frontend/web/js/view/payment/custom-message.js
define([
    'ko',
    'Magento_Checkout/js/model/quote'
], function (ko, quote) {
    'use strict';

    return {
        snapPointsQuote: ko.observable(null),
        cart: quote,
        getQuoteHash: function () {

        },
        updateQuoteHash: function() {

        },
        _generateQuoteHash: function() {

        }


    }
});
