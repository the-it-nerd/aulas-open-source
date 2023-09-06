define([
    'jquery',
    'TheITNerd_UX/js/model/estimated-shipping-methods',
    'jquery/ui',
    'loader'
], function($, estimatedShippingMethodsModel){
    'use strict';

    $.widget('theitnerd.estimateShippingMethodsForm', {
        options: {
            addToCartFormSelector: '#product_addtocart_form'
        },
        _create: function(){
            this.initConfig();
            this.bindSubmit();
        },

        validateForms: function() {
            let isValidPostcode = this.element.validation('isValid');
            let isValidProductForm = this.productForm.validation('isValid');

            return isValidPostcode && isValidProductForm;
        },

        getFormsData: function() {
            let data = new FormData();

            this.productForm.serializeArray().concat(this.element.serializeArray()).forEach((item) => {
                data.append(item.name, item.value);
            });

            return data;
        },

        bindSubmit: function() {
            let self = this;
            this.element.on('submit', function(e){
                e.preventDefault();

                if(self.validateForms()){
                    $.ajax({
                        url: self.element.attr('action'),
                        processData: false,
                        contentType: false,
                        data: self.getFormsData(),
                        type: self.element.attr('method'),
                        beforeSend: function() {
                            self.wrapper.loader('show');
                        },
                        success: function(data) {
                            estimatedShippingMethodsModel.messages([]);
                            estimatedShippingMethodsModel.rates(data);
                        },
                        error: function (data) {
                            estimatedShippingMethodsModel.messages([{
                                type: 'error',
                                text: data.responseJSON.message
                            }]);
                        },
                        complete: function() {
                            self.wrapper.loader('hide');
                        }
                    });
                }

                return false;
            });
        },

        initConfig: function () {
            this.productForm = $(this.options.addToCartFormSelector);
            this.wrapper = this.element.parent();
            this.wrapper.loader();
        }
    });

    return $.theitnerd.estimateShippingMethodsForm;
});
