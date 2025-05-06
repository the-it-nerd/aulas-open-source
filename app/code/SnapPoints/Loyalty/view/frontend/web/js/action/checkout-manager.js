define([
    'jquery',
    'mage/url',
    'SnapPoints_Loyalty/js/model/quote',
    'SnapPoints_Loyalty/js/model/program',
    'mage/cookies'
], function ($, urlBuilder,quoteModel, programModel) {
    'use strict';

    return {

        _getCustomerEmail: function() {
            return quoteModel.cart.email ?? quoteModel.cart.guestEmail
        },
        getQuote: async function () {
            try {
                let url = urlBuilder.build('rest/V1/snappoints-loyalty/quote/');

                quoteModel.snapPointsQuote(false);

                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({"quoteID": window.checkoutConfig.quoteData.entity_id, "programID": programModel.selectedProgram().programId})
                });

                if (!response.ok) {
                    let errorBody = 'Could not read error details.';
                    try {
                        errorBody = await response.text();
                    } catch (readError) {
                        console.warn("Could not read response body for error.", readError);
                    }
                    throw new Error(`HTTP error! status: ${response.status}, Body: ${errorBody}`);
                }
                const data = await response.json();

                let responseObj = data;
                if(data.length > 0 && data.hasOwnProperty(0)) {
                    responseObj = data[0];
                }
                quoteModel.snapPointsQuote(responseObj);

                return responseObj;

            } catch (error) {
                console.error('Fetch request failed (async/await):', error);
                // Handle server-side failure (show message to user ?)
            }

        }
    }
});
