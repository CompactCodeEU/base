/*
 * Copyright (c) 2019
 * Copyright Holder : CompactCode - CompactCode BvBa - Belgium
 * Copyright : Unless granted permission from CompactCode BvBa.
 * You can not distribute, reuse, edit, resell or sell this.
 */

define(
    [
        'jquery'
    ],
    function ($) {
        'use strict';

        $.widget('mage.ccpreview', {
            options: {
                colorinput:''
            },

            _create: function () {
                var element = this.element;

                var preview = element.find(".cc-preview .spinner");
                var select = element.find("select.cc-preview-selector");
                var color_input = $(this.options.colorinput);

                this._changePreview(preview, select, color_input);
            },

            _changePreview: function (preview, select, color_input) {
                var self = this;
                select.on("change", function() {
                    var option_selected = select.find("option:selected");
                    var val = option_selected.val();
                    var childclass = option_selected.attr('data-childclass');
                    var children = option_selected.attr('data-children');

                    var animationHtml = self.generateAnimationHTML(childclass, children);

                    preview.attr("class","spinner " + val);
                    preview.html(animationHtml);
                });

                color_input.on('change', function() {
                    var color = color_input.val() ? color_input.val() : "#000000";
                    preview.css('color', color);
                });
                select.trigger('change');
                color_input.trigger('change');
            },

            generateAnimationHTML: function(childclass, children){
                var html = "";

                for(var i = 1; i <= children; i++) {
                    html += "<div class='" + (childclass + i) + ' ' + childclass + "'></div>";
                }

                return html;
            }
        });
        return $.mage.ccpreview;
    }
);