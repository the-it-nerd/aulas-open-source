// app/code/YourVendor/YourModule/view/frontend/web/js/view/payment/custom-message.js
define([
    'Magento_Customer/js/customer-data',
    'SnapPoints_Loyalty/js/model/rules'
], function (customerData, rulesModel) {
    'use strict';

    const model = {
        selectedProgram: customerData.get('snapPointsSelectedProgram'),
        refreshProgramCache: () =>  customerData.reload(['snapPointsSelectedProgram'], true),
        getSelectedProgram: function() {
          return this.getProgram(this.selectedProgram().programId);
        },
        getProgram: (programID) =>{
            if (programID === 'first_available') {
                return window.snapPointsPrograms.programs[0];
            }

            return window.snapPointsPrograms.programs.filter(program => parseInt(program.programId) === parseInt(programID))[0];
        },

        calculatePointsPerSpend: async (programPointsPerSpend, spend, productId)  => {
            if (!programPointsPerSpend || !window.snapPointsPrograms.maxGiveBackRatio) return 0;

            let productRate = await rulesModel.getRatioRuleByProductId(productId);

            if(productRate === null) {
                productRate = window.snapPointsPrograms.maxGiveBackRatio;
            }

            let rate = (programPointsPerSpend * productRate / 0.01).toFixed(1);
            rate = Number(rate) % 1 === 0 ? parseInt(rate) : rate

            if(spend) {
                return (spend * rate).toFixed(1);
            }

            return rate;
        }
    }

    const initVar = window.localStorage.getItem('snapPointsInit');

    if (!initVar) {
        model.refreshProgramCache();
        window.localStorage.setItem('snapPointsInit', Date.now());
    }

    if(!model.selectedProgram().hasOwnProperty('programId'))
    {
        model.refreshProgramCache();
        window.localStorage.setItem('snapPointsInit', Date.now());
    }

    return model;
});
