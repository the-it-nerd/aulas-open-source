define([
    'jquery',
    'jquery/ui'
], function($){
    'use strict';

    $.widget('theitnerd.secondImage', {
        options: {},
        _create: function(){
            this.element.on('mouseenter', function(){
                $(this).attr('src', $(this).attr('second-src'));
                $(this).attr('data-srcset', $(this).attr('second-src'));
                $(this).attr('srcset', $(this).attr('second-src'));
            });

            this.element.on('mouseleave', function(){
                $(this).attr('src', $(this).attr('first-src'));
                $(this).attr('data-srcset', $(this).attr('first-src'));
                $(this).attr('srcset', $(this).attr('first-src'));
            });
        }
    });

    return $.theitnerd.secondImage;
});
