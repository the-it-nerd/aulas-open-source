// app/code/YourVendor/YourModule/view/frontend/web/js/view/payment/custom-message.js
define([
    'ko',
    'Magento_Checkout/js/model/quote',
    'SnapPoints_Loyalty/js/model/program'
], function (ko, quoteModel, programModel) {
    'use strict';

    return {
        snapPointsQuote: ko.observable(null),
        cart: quoteModel,
        getQuoteHash: function () {
            return window.localStorage.getItem('quoteHash');
        },
        updateQuoteHash: function() {
            window.localStorage.setItem('quoteHash', this.generateQuoteHash());
            return this;
        },
        needsHashUpdate: function(){
          return this.getQuoteHash() !== this.generateQuoteHash();
        },
        generateQuoteHash: function() {
            let program = '';
            if(programModel.selectedProgram()) {
                program = programModel.selectedProgram().programId;
            }
            let parts = [program, quoteModel.getQuoteId()];

            quoteModel.getItems().forEach((item) => {
                parts.push(`${item.item_id}-${item.qty}-${item.updated_at}`);
            })

            return btoa(parts.join('_'));
        }


    }
});
