define([
    'jquery',
    'SnapPoints_Loyalty/js/action/program-manager',
    'SnapPoints_Loyalty/js/model/program',
    'Magento_Ui/js/modal/modal',
    'jquery-ui-modules/widget',
    'mage/translate'
], function ($, programManager, programModel, mageModal) {

    $.widget('SnapPoints.howItWorksModal', {
        modal: null,
        options: {
            logoSelector: '.snappoints-program-details-modal--content--text--logo img',
            textSelector: '.snappoints-program-details-modal--content--text--content',
        },
        _create: function () {
            this._setupModal()
                ._selectProgram(programModel.selectedProgram())
                ._bind();
        },

        _setupModal: function () {
            this.modal = mageModal({
                type: 'popup',
                responsive: true,
                innerScroll: true,
                modalClass: 'snappoints-program-details-modal',
                trigger: "[data-trigger=how-it-work-snappoints]",
                title: "",
                buttons: []
            }, this.element);

            return this;
        },

        _bind: function () {
            this._selectProgram.bind(this);

            programModel.selectedProgram.subscribe((value) => {
                this._selectProgram(value);
            });
            return this;
        },

        _selectProgram: function (selectedProgram) {
            if(selectedProgram.hasOwnProperty('programId')) {
                let programData = window.snapPointsPrograms.programs.filter((program) => program.programId === selectedProgram.programId);
                if(programData.length > 0) {
                    programData = programData[0];

                    this.element.find(this.options.logoSelector).prop('src', programData.logo);
                    this.element.find(this.options.textSelector).html(this._getDescription(programData));
                }
            }

            return this;
        },

        _getDescription: function (selectedProgram) {
            let text = '';

            if(selectedProgram.hasOwnProperty('description')) {
                text = selectedProgram.description.replace('{store_name}', window.snapPointsPrograms.store.name)
                    .replaceAll('{currency}', window.snapPointsPrograms.currency)
                    .replaceAll('{program_name}', selectedProgram.name)
                    .replaceAll('{unit}', selectedProgram.unit)
                    .replaceAll('{point_per_currency}', programModel.calculatePointsPerSpend(selectedProgram.pointsPerSpend, 1));
            }

            return text;
        }
    });

    return $.SnapPoints.howItWorksModal;
});


