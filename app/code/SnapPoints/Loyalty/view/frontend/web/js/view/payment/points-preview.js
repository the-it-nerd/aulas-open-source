// app/code/YourVendor/YourModule/view/frontend/web/js/view/payment/custom-message.js
define([
    'jquery',
    'ko',
    'uiComponent',
    'SnapPoints_Loyalty/js/model/quote',
    'SnapPoints_Loyalty/js/model/program',
    'SnapPoints_Loyalty/js/action/checkout-manager',

], function ($, ko, Component, snapQuoteModel, programModel, checkoutManager) {
    'use strict';

    return Component.extend({
        cart: snapQuoteModel.cart,
        snapModel: snapQuoteModel.snapPointsQuote,
        initialized: ko.observable(false),
        selectedProgram: programModel.selectedProgram,
        selectedProgramObject: ko.observable(false),
        defaults: {
            template: 'SnapPoints_Loyalty/payment/points-preview'
        },

        getLoaderImage: function () {
            return window.snapPointsPrograms.assets.loader;
        },

        getItemDescription: function (sku) {
            let item = this.cart.getItems().filter((item) => item.sku === sku);

            if (item.length > 0) {
                return item[0].name;
            }

            return sku;
        },

        initialize: function () {
            this._super();

            this._bindUpdates();
            this._initQuote();
        },

        _bindUpdates: function () {
            if (programModel.getSelectedProgram()) {
                this.selectedProgramObject(programModel.getSelectedProgram());
            }

            let self = this;
            programModel.selectedProgram.subscribe((value) => {
                self.selectedProgramObject(programModel.getSelectedProgram());

                if (snapQuoteModel.needsHashUpdate()) {
                    self._getQuote();
                }
            });
        },

        _getQuote: async function () {
            const response = await checkoutManager.getQuote();

            snapQuoteModel.updateQuoteHash();

            return response;
        },

        _initQuote: function () {
            if (checkoutManager._getCustomerEmail() && snapQuoteModel.needsHashUpdate()) {
                this._getQuote();
            } else {
                let self = this;
                this.cart.shippingMethod.subscribe(async (newValue) => {

                    if(snapQuoteModel.needsHashUpdate() || !self.snapModel()) {
                        await self._getQuote();
                    }
                    self.initialize(true);
                })
            }
        },

        getMessage: function () {
            return 'Your custom message here';
        }
    });
});
