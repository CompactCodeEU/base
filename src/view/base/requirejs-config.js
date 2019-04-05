/*
 * Copyright (c) 2019
 * Copyright Holder : CompactCode - CompactCode BvBa - Belgium
 * Copyright : Unless granted permission from CompactCode BvBa.
 * You can not distribute, reuse, edit, resell or sell this.
 */

var config = {
    paths: {
        'cc-dropzone' : 'CompactCode_Base/js/dropzone/dropzone',
        'cc-imageuploader' : 'CompactCode_Base/js/cc-imageuploader',
        'zenorocha-clipboard' : 'CompactCode_Base/js/clipboard/clipboard',
        'cc-clipboard' : 'CompactCode_Base/js/cc-clipboard'
    },
    shim: {
        'cc-dropzone' : {
            'deps' : ['jquery']
        },
        'zenorocha-clipboard' : {
            'exports' : 'ClipboardJS',
            'deps' : ['jquery']
        },
        'cc-imageuploader' : {
            'deps' : ['jquery' , 'cc-dropzone']
        },
        'cc-clipboard' : {
            'deps' : ['jquery' , 'zenorocha-clipboard']
        }
    }
};