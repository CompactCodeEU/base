/*
 * Copyright (c) 2019
 * Copyright Holder : CompactCode - CompactCode BvBa - Belgium
 * Copyright : Unless granted permission from CompactCode BvBa.
 * You can not distribute, reuse, edit, resell or sell this.
 */

var config = {
    paths: {
        'cc-widget-multiselect' : 'CompactCode_Base/js/widget/cc_widget_multiselect',
        'jquery-multiselect' : 'CompactCode_Base/js/form/multiselect/jquery.multi-select',
        'cc-multiselect' : 'CompactCode_Base/js/form/multiselect/ccmultiselect',
        'ccpreview' : 'CompactCode_Base/js/ccpreview',
        'cc-colorpicker' : 'CompactCode_Base/js/form/colorpicker/cc_colorpicker',
    },
    shim: {
        'cc-widget-multiselect' : {
            'deps' : ['jquery', 'jquery/ui']
        },
        'jquery-multiselect' : {
            'deps' : ['jquery']
        },
        'cc-multiselect' : {
            'deps' : ['jquery']
        },
        'ccpreview' : {
            'deps' : ['jquery']
        },
        'cc-colorpicker' : {
            'deps' : ['jquery']
        }
    }
};