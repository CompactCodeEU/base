/*
 * Copyright (c) 2019
 * Copyright Holder : CompactCode - CompactCode BvBa - Belgium
 * Copyright : Unless granted permission from CompactCode BvBa.
 * You can not distribute, reuse, edit, resell or sell this.
 */

define([
        'jquery',
        'cc-dropzone'
    ], function ($) {
        $.widget('mage.ccimageuploader', {
            options: {
                name: 'type',
                limit: 1,
                acceptedfiles: 'image/*,.png,.svg',
                class: 'dropzone'
            },

            _create: function () {
                var jqueryelem = $(this.element);
                var options = this.options;
                jqueryelem.addClass(this.options.class);
                jqueryelem.dropzone({
                    paramName: this.options.name,
                    url: 'test/test',
                    addRemoveLinks: true,
                    maxFiles: this.options.limit,
                    acceptedFiles: this.options.acceptedfiles,

                    init: function () {
                        options['dropzone'] = this;
                        this.on('removedfile', function() {
                            this.options.maxFiles += 1;
                        })
                    }

                });
                window[this.options.name] = this;
            },

            loadImages: function (images) {
                const DropZone = this.options.dropzone;
                DropZone.removeAllFiles(true);
                DropZone.options.maxFiles = this.options.limit;
                $.each(images, function (key, image) {
                    DropZone.files.push(image);
                    DropZone.emit('addedfile', image);
                    DropZone.createThumbnailFromUrl(
                        image,
                        DropZone.options.thumbnailWidth,
                        DropZone.options.thumbnailHeight,
                        DropZone.options.thumbnailMethod,
                        true,
                        function(thumbnail) {
                            DropZone.emit('thumbnail', image, thumbnail)
                        }, 'anonymous');

                    DropZone.emit("complete", image);
                    DropZone.options.maxFiles -= 1;
                });
            }
        });
        return $.mage.ccimageuploader;
    }
);