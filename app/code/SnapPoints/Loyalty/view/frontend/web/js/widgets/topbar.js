define([
    'jquery',
    'SnapPoints_Loyalty/js/action/program-manager',
    'SnapPoints_Loyalty/js/model/program',
    'jquery-ui-modules/widget'
], function ($, programManager, programModel) {

    $.widget('SnapPoints.TopBar', {
        options: {
            placeholderSelector: '.snappoints--bar--announcement--select',
            activeSelector: '.snappoints--bar--announcement--active',
            titleSelector: '.snappoints--bar--announcement--program--title',
            imageSelector: '.snappoints--bar--announcement--program--image',
            textTemplate: 'Earn up to {points} <strong>{brand}</strong> {unit} per 1 {currency} spent'
        },
        _create: function () {
            this._recalculateProgramData(programModel.selectedProgram());
            this._bind();
        },

        _bind: function () {
            this._recalculateProgramData.bind(this);

            programModel.selectedProgram.subscribe((value) => {
                this._recalculateProgramData(value);
            });
        },
        _recalculateProgramData: function (selectedProgram) {
            if (selectedProgram && selectedProgram.hasOwnProperty('programId')) {
                const program = programModel.getProgram(selectedProgram.programId);

                let text = this.options.textTemplate.replace('{brand}', program.name)
                    .replace('{currency}', window.snapPointsPrograms.currency)
                    .replace('{unit}', program.unit)
                    .replace('{points}', programModel.calculatePointsPerSpend(program.pointsPerSpend, 1));


                this.element.find(this.options.titleSelector).html(text);
                this.element.find(this.options.imageSelector).prop('src', program.logo);

                this.element.find(this.options.activeSelector).show();
                this.element.find(this.options.placeholderSelector).hide();
            }
        }
    });

    return $.SnapPoints.TopBar;
});


