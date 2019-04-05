/**
/*
 * Copyright (c) 2019
 * Copyright Holder : CompactCode - CompactCode BvBa - Belgium
 * Copyright : Unless granted permission from CompactCode BvBa.
 * You can not distribute, reuse, edit, resell or sell this.
 */

define(
    [
        'jquery',
        'jquery-multiselect'
    ],
    function ($, JMultiselect) {
        'use strict';

        $.widget('mage.ccmultiselect', {
            options: {
                'selectableHeader': 'Options',
                'selectionHeader': 'Selected',
                'selectableOptgroup': false,
                'select': ['%document_number2%'],
                'selectall': 'select-all',
                'deselectall': 'deselect-all',
                'multiselectclass' : 'cc-multiselect'
            },

            _create: function () {
                if(this.options.multiselectclass){
                    this.options.selectableHeader = '<h4 style="margin:0">' + this.options.selectableHeader + '</h4>';
                    this.options.selectionHeader = '<h4 style="margin:0">' + this.options.selectionHeader + '</h4>';
                    var element = $(this.element);
                    var multiselect = element.find('.' + this.options.multiselectclass);
                    multiselect.multiSelect(this.options);

                    var selectall = element.find('#' + this.options.selectall);
                    var deselectall = element.find('#' + this.options.deselectall);

                    selectall.on('click', function () {
                        multiselect.multiSelect('select_all');
                    });

                    deselectall.on('click', function () {
                        multiselect.multiSelect('deselect_all');
                    });
                    // $(this.element).multiSelect('select' , this.options.select);
                }
            }
        });
        return $.mage.ccmultiselect;
    }
);