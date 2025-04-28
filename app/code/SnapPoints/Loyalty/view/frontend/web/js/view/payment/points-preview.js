// app/code/YourVendor/YourModule/view/frontend/web/js/view/payment/custom-message.js
define([
    'jquery',
    'ko',
    'uiComponent'
], function ($, ko, Component) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'SnapPoints_Loyalty/payment/points-preview'
        },

        getMessage: function() {
            return 'Your custom message here';
        }
    });
});
