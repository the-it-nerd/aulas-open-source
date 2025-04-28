// app/code/YourVendor/YourModule/view/frontend/web/js/view/payment/custom-message.js
define([
    'jquery',
    'mage/url',
    'SnapPoints_Loyalty/js/model/program',
    'mage/cookies'
], function ($, urlBuilder,programModel) {
    'use strict';

    return {
        selectProgram: async function (programID) {
            try {
                let url = urlBuilder.build('snappoints/program/select');

                const formData = new URLSearchParams();
                formData.append('program_id', programID);
                formData.append('form_key', $.mage.cookies.get('form_key'));

                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
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

                // TODO: Hide loading indicator

                const data = await response.json();

                programModel.refreshProgramCache();

                console.log(data);

                if (data.success) {
                    return data;
                } else {
                    console.error('Failed to select program (async/await):', data.message || 'Unknown server error');
                    // Handle server-side failure (show message to user ?)
                }

            } catch (error) {
                // TODO: Hide loading indicator
                console.error('Fetch request failed (async/await):', error);
                // Handle server-side failure (show message to user ?)
            }

        }
    }
});
