define([
    'jquery',
    'Magento_Customer/js/customer-data',
    'Magento_Ui/js/modal/confirm',
    'mage/translate'
], function($, customerData, confirm) {
    'use strict';

    $.widget('theitnerd.productWishlistIcon', {
        wishlistItem: null,
        postData: null,
        options: {
            formKeyInputSelector: 'input[name="form_key"]',
            removalConfirmationMessage: $.mage.__("Are you sure you would like to remove this item from you wishlist?"),
        },

        _create: function() {
            this.postData = this.element.data('post');
            this.element.removeData('post');
            this.element.removeAttr('data-post');
            this.element.prop('href', 'javascript:void(0)');
            this.populateWishlistItem();
            this.bindClick();

            customerData.get('wishlist').subscribe($.proxy(function(wishlist) {
                this.populateWishlistItem();
            }, this));
        },

        bindClick: function() {
            this.element.on('click', $.proxy(function(e) {
               e.preventDefault();

               let postData = this.postData;

               if(this.wishlistItem && this.wishlistItem.length > 0) {
                   postData = JSON.parse(this.wishlistItem[0].delete_item_params);

                   confirm({
                       content: this.options.removalConfirmationMessage,
                       actions: {
                           /** @inheritdoc */
                           confirm: $.proxy(function () {
                               this.sendRequest(postData);
                           }, this)
                       }
                   })
               } else {
                   this.sendRequest(postData);
               }
            }, this));

        },

        sendRequest: function(postData) {
            postData.data.form_key = $(this.options.formKeyInputSelector).val();

            $.ajax({
                url: postData.action,
                type: 'POST',
                context: this,
                data: postData.data,

                beforeSend: $.proxy(function() {
                    this.element.trigger('processStart');
                }, this),
                /** @param {Object} response */
                success: function (response) {
                },

                /** set empty array if error occurs */
                error: function (response) {
                    this.element.trigger('processStop');
                },

                /** stop loader */
                complete: function () {
                    this.element.trigger('processStop');
                    customerData.reload(['wishlist', 'messages']);
                }
            });

        },

        populateWishlistItem: function() {
            if(
                this.postData.hasOwnProperty('data')
                && this.postData.data.hasOwnProperty('product')
            ) {
                let wishlist = customerData.get('wishlist')();

                this.wishlistItem = this.getWishlistItem(this.postData.data.product, wishlist)
            }

            this.changeActiveFlag();
        },

        changeActiveFlag: function() {
            if(this.wishlistItem && this.wishlistItem.length > 0) {
                this.element.addClass('active');
            } else {
                this.element.removeClass('active');
            }
        },

        getWishlistItem: function(productId, wishlist) {

            if(wishlist.hasOwnProperty('full_list')) {
                return wishlist.full_list.filter((item) => {
                    return item.product_id == productId;
                });
            }

            return null;
        }


    });

    return $.theitnerd.productWishlistIcon;
});
