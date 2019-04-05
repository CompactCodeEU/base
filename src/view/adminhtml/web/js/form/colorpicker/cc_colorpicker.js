/**
 * Copyright (c) 2019
 * Copyright Holder : CompactCode - CompactCode BvBa - Belgium
 * Copyright : Unless granted permission from CompactCode BvBa.
 * You can not distribute, reuse, edit, resell or sell this.
 */

define([
    'Magento_Ui/js/form/element/abstract',
    'mageUtils',
    'jquery',
    'jquery/colorpicker/js/colorpicker'
], function (Element, utils, $) {
    'use strict';

    return Element.extend({
        defaults: {
            visible: true,
            label: '',
            error: '',
            uid: utils.uniqueid(),
            disabled: false,
            links: {
                value: '${ $.provider }:${ $.dataScope }'
            }
        },

        initialize: function () {
            this._super();
        },

        initColorPickerCallback: function (element) {
            var element = $(element);
            var self = this;
            var color = $(element).val();
            element.css('background-color', color);

            element.ColorPicker({
                color: color,
                onSubmit: function(hsb, hex, rgb, el) {
                    self.value(hex);
                    $(el).ColorPickerHide();
                },
                onBeforeShow: function () {
                    $(this).ColorPickerSetColor(this.value);
                },
                onChange: function(hsb, hex, rgb, el) {
                    self.value('#'+hex);
                    element.css("backgroundColor", "#" + hex).trigger("change");
                }
            }).bind('keyup', function(){
                $(this).ColorPickerSetColor(this.value);
            });
        }
    });
});