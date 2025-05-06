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
        lastSelectedProgram: ko.observable(false),
        selectedProgramObject: ko.observable(false),
        defaults: {
            template: 'SnapPoints_Loyalty/payment/points-preview'
        },

        getLoaderImage: function() {
            return window.snapPointsPrograms.assets.loader;
        },

        getItemDescription: function(sku) {
            let item = this.cart.getItems().filter((item) => item.sku === sku);

            if(item.length > 0) {
                return item[0].name;
            }

            return sku;
        },

        initialize: function() {

            let self = this;
            this._super();

            if(programModel.getSelectedProgram()) {
                this.selectedProgramObject(programModel.getSelectedProgram());
                this.lastSelectedProgram(this.selectedProgramObject().programId);
            }

            programModel.selectedProgram.subscribe((value) => {
                console.log(value);
                self.selectedProgramObject(programModel.getSelectedProgram());

                if(self.lastSelectedProgram().programId !== value.programId) {
                    self.lastSelectedProgram(value.programId);
                    self._getQuote();
                }
            });

            this._initQuote();
        },

        _getQuote: async function() {
            return await checkoutManager.getQuote();
        },

        _initQuote: function() {
            if(checkoutManager._getCustomerEmail()) {
                this._getQuote();
            } else {
                let self = this;
                this.cart.shippingMethod.subscribe(async (newValue) =>  {
                    await self._getQuote();
                    self.initialize(true);
                })
            }
        },

        getMessage: function() {
            return 'Your custom message here';
        }
    });
});
