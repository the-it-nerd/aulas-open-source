define([
    'jquery',
    'SnapPoints_Loyalty/js/model/program',
    'SnapPoints_Loyalty/js/action/program-manager',
    'jquery-ui-modules/widget'
], function ($, programModel, programManager) {

    $.widget('SnapPoints.Product', {
        options: {
            logoSelector: '.snappoints--card--program--image-wrapper--image',
            pointsSelector: '.snappoints--card--program--points',
            longTextSelector: '.snappoints-widget--disclaimer--text',

            longTextTemplate: 'Earn {brand} {unit} on this item',
            shortTextTemplate: '{points} {unit}'

        },
        _create: function () {
            this._bind();
            this.generatePointsData(programModel.selectedProgram());
        },

        _bind: function () {
            programModel.selectedProgram.subscribe((value) => {
                this.generatePointsData(value);
            });
        },

        generatePointsData: async function(selectedProgram) {
            const program = programModel.getProgram(selectedProgram.programId);

            let value =  await programModel.calculatePointsPerSpend(program.pointsPerSpend, this.element.data('price'), this.element.data('productId'));

            let html  = this.options.shortTextTemplate.replace('{points}', value)
                .replace('{unit}', program.unit);

            this.element.find(this.options.pointsSelector).html(html);
            this.element.find(this.options.logoSelector).prop('src', program.logo);

            html  = this.options.longTextTemplate.replace('{points}', value)
                .replace('{brand}', program.name)
                .replace('{unit}', program.unit);

            this.element.find(this.options.longTextSelector).html(html);
        },

        refresh: function() {
            return this.generatePointsData(programModel.selectedProgram());
        }

    });

    return $.SnapPoints.Product;
});


