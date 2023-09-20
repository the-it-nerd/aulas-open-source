define([
    'jquery',
    'Magento_Catalog/js/price-utils',
    'jquery/ui'
], function($, priceUtils){
    'use strict';

    $.widget('theitnerd.relatedButton', {
        options: {
            wrapperSelector: '.product-items',
            baseItemSelector: '.product-item.base',
            itemSelector: '.product-item.related',
            addToCartFormSelector: '#product_addtocart_form',
            baseProductId: null,
            itemPrice: 0
        },
        _create: function(){
            this.initElements();
            this.bindEvents();
            this.updatePrice.bind(this);
            this.updatePrice();
        },

        initElements: function() {
            this.wrapper = this.element.closest(this.options.wrapperSelector);
            this.baseItem = this.wrapper.find(this.options.baseItemSelector);
            this.item = this.wrapper.find(this.options.itemSelector);
            this.productForm = $(this.options.addToCartFormSelector);
            this.baseItemPriceElement = $("#product-price-"+this.options.baseProductId);

            this.options.itemPrice = parseFloat(this.item.find('[data-price-type="finalPrice"]').data('price-amount'));
        },

        bindEvents: function() {
            this.element.on('click', $.proxy(function() {
                let checkbox = this.item.find('.checkbox.related');
                if(checkbox.prop('checked') !== 'checked') {
                    checkbox.click();
                }
                let isValid = this.productForm.validation('isValid');

                if(isValid) {
                    this.productForm.find('.action.primary.tocart').click();
                    window.scrollTo({ top: jQuery('.product-info-main').position().top, behavior: 'smooth' });
                }
            }, this));

            this.baseItemPriceElement.parent().on('DOMSubtreeModified', $.proxy(function() {
                this.updatePrice();
            }, this));
        },

        updatePrice: function() {
            let price = parseFloat(this.baseItemPriceElement.data('price-amount')) + parseFloat(this.options.itemPrice);
            this.element.closest('.related---actions').find('.related---subtotal-value').html(priceUtils.formatPrice(price));
        }

    });

    return $.theitnerd.relatedButton;
});
