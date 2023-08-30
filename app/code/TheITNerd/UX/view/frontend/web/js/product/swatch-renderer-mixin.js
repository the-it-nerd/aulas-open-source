define([
    'jquery',
    'jquery/ui'
], function ($) {
    'use strict';

    return function (updateBaseImage) {
        $.widget('mage.SwatchRenderer', updateBaseImage, {
            updateBaseImage: function (images, context, isInProductView) {

                var justAnImage = images[0],
                    initialImages = this.options.mediaGalleryInitial,
                    imagesToUpdate,
                    gallery = context.find(this.options.mediaGallerySelector).data('gallery'),
                    isInitial;

                if (isInProductView) {
                    if (_.isUndefined(gallery)) {
                        context.find(this.options.mediaGallerySelector).on('gallery:loaded', function () {
                            this.updateBaseImage(images, context, isInProductView);
                        }.bind(this));

                        return;
                    }

                    imagesToUpdate = images.length ? this._setImageType($.extend(true, [], images)) : [];
                    isInitial = _.isEqual(imagesToUpdate, initialImages);

                    if (this.options.gallerySwitchStrategy === 'prepend' && !isInitial) {
                        imagesToUpdate = imagesToUpdate.concat(initialImages);
                    }

                    imagesToUpdate = this._setImageIndex(imagesToUpdate);

                    gallery.updateData(imagesToUpdate);
                    this._addFotoramaVideoEvents(isInitial);
                } else if (justAnImage && justAnImage.img) {
                    context.find('.product-image-photo').attr('src', justAnImage.img);
                    context.find('.product-image-photo').attr('first-src', justAnImage.img).trigger('mouseleave');

                    if(images.length > 1) {
                        context.find('.product-image-photo').attr('second-src', images[1].img);
                    }

                }
            }
        });

        return $.mage.SwatchRenderer;
    };

});
