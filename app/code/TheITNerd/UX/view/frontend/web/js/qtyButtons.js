define([
    'jquery',
], function($) {
    'use strict';

    $.widget('theitnerd.qtyButtons', {
        options: {

        },

        _create: function() {
            this.parent = this.element.closest('div');

            this.parent.prepend('<span class="btn btn-qty btn-qty-minus">-</span>');
            this.parent.append('<span class="btn btn-qty btn-qty-plus">+</span>');

            let self = this;
            this.parent.on('click', '.btn-qty', function() {
               let isSum = $(this).is('.btn-qty-plus');
               let min = parseInt(self.element.prop('min'));
               let max = parseInt(self.element.prop('max'));
               if(!max > 0) {
                   max = 10000;
               }


               if(isSum && parseInt(self.element.val()) < max) {
                   self.element.val(parseInt(self.element.val())+1);
               } else if (!isSum && parseInt(self.element.val()) > min) {
                   self.element.val(parseInt(self.element.val())-1);
               }

            });
        }


    });

    return $.theitnerd.qtyButtons;
});
