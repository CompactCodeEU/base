/*
 * Copyright (c) 2019
 * Copyright Holder : CompactCode - CompactCode BvBa - Belgium
 * Copyright : Unless granted permission from CompactCode BvBa.
 * You can not distribute, reuse, edit, resell or sell this.
 */

define([
        'jquery',
        'zenorocha-clipboard'
    ], function ($, ClipboardJS) {
        $.widget('mage.ccclipboard', {
            options: {
                tooltipclass: 'cc-clipboard-tooltip',
                tooltiptextclass: 'cc-clipboard-tooltip-text',
                tooltipduration: 2000,
                succesmessage : 'Copied!',
                errormessage : 'Failed to copy!'
            },
            _create: function () {
                var element = this.element;
                var self = this;
                var clipBoard = new ClipboardJS($(element)[0]);
                var timer;
                $(element).addClass(this.options.tooltipclass);
                clipBoard.on('success', function (e) {
                    var tooltiptexthtml = '<span class="' + self.options.tooltiptextclass + '">' + self.options.succesmessage + '<span>';
                    $(element).append(tooltiptexthtml);
                    clearTimeout(timer);
                    timer = setTimeout(function () {
                        $(element).find('.' + self.options.tooltiptextclass).remove();
                    }, self.options.tooltipduration);
                    e.clearSelection();
                });
                clipBoard.on('error', function (e) {
                    var tooltiptexthtml = '<span class="' + self.options.tooltiptextclass + '">' + self.options.errormessage + '<span>';
                    $(element).append(tooltiptexthtml);
                    clearTimeout(timer);
                    timer = setTimeout(function () {
                        $(element).find('.' + self.options.tooltiptextclass).remove();
                    }, self.options.tooltipduration);
                });
            }
        });
        return $.mage.ccclipboard;
    }
);