// app/code/YourVendor/YourModule/view/frontend/web/js/view/payment/custom-message.js
define([
    'Magento_Customer/js/customer-data'
], function (customerData) {
    'use strict';

    const model = {
        selectedProgram: customerData.get('snapPointsSelectedProgram'),
        refreshProgramCache: () =>  customerData.reload(['snapPointsSelectedProgram'], true),
        getProgram: (programID) =>{
            if (programID === 'first_available') {
                return window.snapPointsPrograms.programs[0];
            }

            return window.snapPointsPrograms.programs.filter(program => parseInt(program.programId) === parseInt(programID))[0];
        },

        calculatePointsPerSpend: (programPointsPerSpend, spend)  =>{
            //TODO this is not working, should be in a separate action?
            const maxGiveBackRatio = 6;
            if (!programPointsPerSpend || maxGiveBackRatio) return 0;

            const value = (programPointsPerSpend * maxGiveBackRatio / 0.01).toFixed(1);
            return Number(value) % 1 === 0 ? parseInt(value) : value;
        }
    }

    const initVar = window.localStorage.getItem('snapPointsInit');

    if (!initVar) {
        model.refreshProgramCache();
        window.localStorage.setItem('snapPointsInit', Date.now());
    }

    return model;
});
