/*
 * Copyright (c) 2019
 * Copyright Holder : CompactCode - CompactCode BvBa - Belgium
 * Copyright : Unless granted permission from CompactCode BvBa.
 * You can not distribute, reuse, edit, resell or sell this.
 */

var config = {
    paths: {
        'jquery-multiselect' : 'CompactCode_Base/js/form/multiselect/jquery.multi-select',
        'cc-multiselect' : 'CompactCode_Base/js/form/multiselect/ccmultiselect',
    },
    shim: {
        'jquery-multiselect' : {
            'deps' : ['jquery']
        },
        'cc-multiselect' : {
            'deps' : ['jquery']
        }
    }
};