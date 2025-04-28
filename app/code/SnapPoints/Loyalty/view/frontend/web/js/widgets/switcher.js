define([
    'jquery',
    'SnapPoints_Loyalty/js/action/program-manager',
    'SnapPoints_Loyalty/js/model/program',
    'Magento_Ui/js/modal/modal',
    'jquery-ui-modules/widget',
    'mage/translate'
], function ($, programManager, programModel, mageModal) {

    $.widget('SnapPoints.Switcher', {
        modal: null,
        options: {
            itemSelector: '.snappoints--switcher--content--item',
            itemTextSelector: '.snappoints--switcher--content--item--points',
            textTemplate: 'up to {points} {unit}/{currency}',
            title: $.mage.__('Change Program'),
            actionText : $.mage.__('Change Program'),
        },
        _create: function () {
            this._setupModal()
                ._setupItems()
                ._selectProgram(programModel.selectedProgram())
                ._bind();
        },

        _setupModal: function () {
            this.modal = mageModal({
                type: 'popup',
                responsive: true,
                innerScroll: false,
                modalClass: 'snappoints--switcher__modal',
                trigger: "[data-trigger=change-snappoints]",
                title: this.options.title,
                buttons: [{
                    text: this.options.actionText,
                    class: 'action primary',
                    click:  () => {
                        this._configSelection();
                    }
                }]
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

        _setupItems: function() {
            this.element.find(this.options.itemSelector).each((idx, el) => {
                const program = programModel.getProgram($(el).data('snappoints-program'));
                $(el).find(this.options.itemTextSelector).html(this._getPointsText(program))
            })

            this.element.on('click', this.options.itemSelector, (event) => {
                const clickedItem = $(event.currentTarget);

                this.element.find(this.options.itemSelector).removeClass('active');
                clickedItem.addClass('active');
            });
            return this;
        },

        _getPointsText: function(program) {
            return this.options.textTemplate.replace('{currency}', window.snapPointsPrograms.currency)
                .replace('{unit}', program.unit)
                .replace('{points}', programModel.calculatePointsPerSpend(program.pointsPerSpend, 1));
        },
        _selectProgram: function (selectedProgram) {
            if (selectedProgram) {
                this.element.find('[data-snappoints-program="'+ selectedProgram.programId +'"]').trigger('click');
            }
            return this;
        },

        _configSelection: function() {
            let programId = this.element.find(this.options.itemSelector+'.active').data('snappoints-program');

            if(programId !== undefined && parseInt(programModel.selectedProgram().programId) !== parseInt(programId)) {
                programManager.selectProgram(programId);
            }

            this.modal.closeModal();
        }
    });

    return $.SnapPoints.Switcher;
});


