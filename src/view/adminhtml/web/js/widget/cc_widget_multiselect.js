/*
 * Copyright (c) 2019
 * Copyright Holder : CompactCode - CompactCode BvBa - Belgium
 * Copyright : Unless granted permission from CompactCode BvBa.
 * You can not distribute, reuse, edit, resell or sell this.
 */

!function ($) {

    "use strict";


    /* MULTISELECT CLASS DEFINITION
     * ====================== */

    var MultiSelect = function (element, options) {
        this.options = options;
        this.$element = $(element);
        this.$container = $('<div/>', {'class': "ms-container"});
        this.$selectableContainer = $('<div/>', {'class': 'ms-selectable'});
        this.$selectionContainer = $('<div/>', {'class': 'ms-selection'});
        this.$selectableUl = $('<ul/>', {'class': "ms-list", 'tabindex': '-1'});
        this.$selectionUl = $('<ul/>', {'class': "ms-list selection", 'tabindex': '-1'});
        this.scrollTo = 0;
        this.elemsSelector = 'li:visible:not(.ms-optgroup-label,.ms-optgroup-container,.' + options.disabledClass + ')';
    };

    MultiSelect.prototype = {
        constructor: MultiSelect,


        init: function () {
            var that = this,
                ms = this.$element;

            if (ms.next('.ms-container').length === 0) {
                ms.css({position: 'absolute', left: '-9999px'});
                ms.attr('id', ms.attr('id') ? ms.attr('id') : Math.ceil(Math.random() * 1000) + 'multiselect');
                this.$container.attr('id', 'ms-' + ms.attr('id'));
                this.$container.addClass(that.options.cssClass);
                ms.find('option').each(function () {
                    that.generateLisFromOption(this);
                });

                this.$selectionUl.find('.ms-optgroup-label').hide();

                if (that.options.selectableHeader) {
                    that.$selectableContainer.append(that.options.selectableHeader);
                }
                that.$selectableContainer.append(that.$selectableUl);
                if (that.options.selectableFooter) {
                    that.$selectableContainer.append(that.options.selectableFooter);
                }

                if (that.options.selectionHeader) {
                    that.$selectionContainer.append(that.options.selectionHeader);
                }
                that.$selectionContainer.append(that.$selectionUl);
                if (that.options.selectionFooter) {
                    that.$selectionContainer.append(that.options.selectionFooter);
                }

                that.$container.append(that.$selectableContainer);
                that.$container.append(that.$selectionContainer);
                ms.after(that.$container);

                that.activeMouse(that.$selectableUl);

                var action = that.options.dblClick ? 'dblclick' : 'click';

                that.$selectableUl.on(action, '.ms-elem-selectable', function () {
                    that.select($(this).data('ms-value'));
                });
                that.$selectionUl.on(action, '.ms-elem-selection', function () {
                    that.deselect($(this).data('ms-value'));
                });
                var indexlistart;
                that.$selectionUl.sortable({
                    start: function (event, ui) {
                        var li = $(ui.item);
                        indexlistart = li.index();
                    },

                    stop: function (event, ui) {
                        $.fn.sortselect();
                    }
                }).disableSelection();

                that.activeMouse(that.$selectionUl);

                ms.on('focus', function () {
                    that.$selectableUl.focus();
                });
            }

            var selectedValues = ms.find('option:selected').map(function () {
                return $(this).val();
            }).get();

            that.select(selectedValues, 'init');

            if (typeof that.options.afterInit === 'function') {
                that.options.afterInit.call(this, this.$container);
            }
        },

        'generateLisFromOption': function (option, index, $container) {
            var that = this,
                ms = that.$element,
                attributes = "",
                $option = $(option);

            for (var cpt = 0; cpt < option.attributes.length; cpt++) {
                var attr = option.attributes[cpt];

                if (attr.name !== 'value' && attr.name !== 'disabled') {
                    attributes += attr.name + '="' + attr.value + '" ';
                }
            }
            var selectableLi = $('<li ' + attributes + '><span>' + that.escapeHTML($option.text()) + '</span></li>'),
                selectedLi = selectableLi.clone(),
                value = $option.val(),
                elementId = that.sanitize(value);

            selectableLi
                .data('ms-value', value)
                .addClass('ms-elem-selectable')
                .attr('id', elementId + '-selectable');

            selectedLi
                .data('ms-value', value)
                .addClass('ms-elem-selection')
                .attr('id', elementId + '-selection')
                .attr('value', value)
                .hide();

            // selectedLi.append('<style> .ms-elem-selection:before{font-family: icons-blank-theme; content:\'\\e609\'; color:black; font-size: 1.7rem;} </style>');

            if ($option.prop('disabled') || ms.prop('disabled')) {
                selectedLi.addClass(that.options.disabledClass);
                selectableLi.addClass(that.options.disabledClass);
            }

            var $optgroup = $option.parent('optgroup');

            if ($optgroup.length > 0) {
                var optgroupLabel = $optgroup.attr('label'),
                    optgroupId = that.sanitize(optgroupLabel),
                    $selectableOptgroup = that.$selectableUl.find('#optgroup-selectable-' + optgroupId),
                    $selectionOptgroup = that.$selectionUl.find('#optgroup-selection-' + optgroupId);

                if ($selectableOptgroup.length === 0) {
                    var optgroupContainerTpl = '<li class="ms-optgroup-container"></li>',
                        optgroupTpl = '<ul class="ms-optgroup"><li class="ms-optgroup-label"><span>' + optgroupLabel + '</span></li></ul>';

                    $selectableOptgroup = $(optgroupContainerTpl);
                    $selectionOptgroup = $(optgroupContainerTpl);
                    $selectableOptgroup.attr('id', 'optgroup-selectable-' + optgroupId);
                    $selectionOptgroup.attr('id', 'optgroup-selection-' + optgroupId);
                    $selectableOptgroup.append($(optgroupTpl));
                    $selectionOptgroup.append($(optgroupTpl));
                    if (that.options.selectableOptgroup) {
                        $selectableOptgroup.find('.ms-optgroup-label').on('click', function () {
                            var values = $optgroup.children(':not(:selected, :disabled)').map(function () {
                                return $(this).val();
                            }).get();
                            that.select(values);
                        });
                        $selectionOptgroup.find('.ms-optgroup-label').on('click', function () {
                            var values = $optgroup.children(':selected:not(:disabled)').map(function () {
                                return $(this).val();
                            }).get();
                            that.deselect(values);
                        });
                    }
                    that.$selectableUl.append($selectableOptgroup);
                    that.$selectionUl.append($selectionOptgroup);
                }
                index = index === undefined ? $selectableOptgroup.find('ul').children().length : index + 1;
                selectableLi.insertAt(index, $selectableOptgroup.children());
                selectedLi.insertAt(index, $selectionOptgroup.children());
            } else {
                index = index === undefined ? that.$selectableUl.children().length : index;

                selectableLi.insertAt(index, that.$selectableUl);
                selectedLi.insertAt(index, that.$selectionUl);
            }
        },

        'escapeHTML': function (text) {
            return $("<div>").text(text).html();
        },

        'activeMouse': function ($list) {
            var that = this;

            this.$container.on('mouseenter', that.elemsSelector, function () {
                $(this).parents('.ms-container').find(that.elemsSelector).removeClass('ms-hover');
                $(this).addClass('ms-hover');
            });

            this.$container.on('mouseleave', that.elemsSelector, function () {
                $(this).parents('.ms-container').find(that.elemsSelector).removeClass('ms-hover');
            });
        },

        'refresh': function () {
            this.destroy();
            this.$element.multiSelect(this.options);
        },

        'destroy': function () {
            $("#ms-" + this.$element.attr("id")).remove();
            this.$element.off('focus');
            this.$element.css('position', '').css('left', '');
            this.$element.removeData('multiselect');
        },

        'select': function (value, method) {
            if (typeof value === 'string') {
                value = [value];
            }


            var that = this,
                ms = this.$element,
                msIds = $.map(value, function (val) {
                    return (that.sanitize(val));
                }),
                selectables = this.$selectableUl.find('#' + msIds.join('-selectable, #') + '-selectable').filter(':not(.' + that.options.disabledClass + ')'),
                selections = this.$selectionUl.find('#' + msIds.join('-selection, #') + '-selection').filter(':not(.' + that.options.disabledClass + ')'),
                options = ms.find('option:not(:disabled)').filter(function () {
                    return ($.inArray(this.value, value) > -1);
                });

            if (method === 'init') {
                selectables = this.$selectableUl.find('#' + msIds.join('-selectable, #') + '-selectable'),
                    selections = this.$selectionUl.find('#' + msIds.join('-selection, #') + '-selection');
            }

            if (this.options.max_items == 0) {
                $.fn.selectFunction(selectables, selections, options, that, method);
            } else {
                if ($(this.$selectionUl).children('li:visible').length < this.options.max_items) {
                    $.fn.selectFunction(selectables, selections, options, that, method);
                }
                else {
                    alert('the maximum of items is ' + this.options.max_items);
                }
            }
        },

        'deselect': function (value) {
            if (typeof value === 'string') {
                value = [value];
            }

            var that = this,
                ms = this.$element,
                msIds = $.map(value, function (val) {
                    return (that.sanitize(val));
                }),
                selectables = this.$selectableUl.find('#' + msIds.join('-selectable, #') + '-selectable'),
                selections = this.$selectionUl.find('#' + msIds.join('-selection, #') + '-selection').filter('.ms-selected').filter(':not(.' + that.options.disabledClass + ')'),
                options = ms.find('option').filter(function () {
                    return ($.inArray(this.value, value) > -1);
                });

            if (selections.length > 0) {
                selectables.removeClass('ms-selected').show();
                selections.removeClass('ms-selected').hide();

                options.prop('selected', false);
                options.insertAfter('.cc-select-multiselect option:last');
                $.fn.sortselect();

                that.$container.find(that.elemsSelector).removeClass('ms-hover');

                var selectableOptgroups = that.$selectableUl.children('.ms-optgroup-container');
                if (selectableOptgroups.length > 0) {
                    selectableOptgroups.each(function () {
                        var selectablesLi = $(this).find('.ms-elem-selectable');
                        if (selectablesLi.filter(':not(.ms-selected)').length > 0) {
                            $(this).find('.ms-optgroup-label').show();
                        }
                    });

                    var selectionOptgroups = that.$selectionUl.children('.ms-optgroup-container');
                    selectionOptgroups.each(function () {
                        var selectionsLi = $(this).find('.ms-elem-selection');
                        if (selectionsLi.filter('.ms-selected').length === 0) {
                            $(this).find('.ms-optgroup-label').hide();
                        }
                    });
                }
                ms.trigger('change');
                if (typeof that.options.afterDeselect === 'function') {
                    that.options.afterDeselect.call(this, value);
                }
            }
        },

        'deselect_all': function () {
            var ms = this.$element,
                values = ms.val();

            ms.find('option').prop('selected', false);
            this.$selectableUl.find('.ms-elem-selectable').removeClass('ms-selected ms-hover').show();
            this.$selectionUl.find('.ms-optgroup-label').hide();
            this.$selectableUl.find('.ms-optgroup-label').show();
            this.$selectionUl.find('.ms-elem-selection').removeClass('ms-selected').hide();
        },

        sanitize: function (value) {
            var hash = 0, i, character;
            if (value.length == 0) return hash;
            var ls = 0;
            for (i = 0, ls = value.length; i < ls; i++) {
                character = value.charCodeAt(i);
                hash = ((hash << 5) - hash) + character;
                hash |= 0; // Convert to 32bit integer
            }
            return hash;
        }
    };

    $.fn.sortselect = function () {
        var multiselect = $('.cc-select-multiselect');
        var values = $('.selection li').map(function () {
            var visible;
            if ($(this).is(':visible')) {
                visible = 1
            } else if ($(this).is(':hidden')) {
                visible = 0
            }
            return $(this).attr('value') + '-' + $(this).text() + '-' + visible;
        }).get();

        multiselect.empty();

        $.each(values, function (i, value) {
            var test = value.split('-');
            var option;
            // 'value: ' + test[0] + ' text ' + test[1]+ ' visible ' + test[2];
            if (test[2] == 1) {
                option = $('<option></option>').attr({'value': test[0], 'selected': true}).text(test[1]);
            } else if (test[2] == 0) {
                option = $('<option></option>').attr({'value': test[0], 'selected': false}).text(test[1]);
            }

            multiselect.append(option);
        });
    };

    /* MULTISELECT PLUGIN DEFINITION
     * ======================= */

    $.fn.multiSelect = function () {
        var option = arguments[0],
            args = arguments;

        return this.each(function () {
            var $this = $(this),
                data = $this.data('multiselect'),
                options = $.extend({}, $.fn.multiSelect.defaults, $this.data(), typeof option === 'object' && option);

            if (!data) {
                $this.data('multiselect', (data = new MultiSelect(this, options)));
            }

            if (typeof option === 'string') {
                data[option](args[1]);
            } else {
                data.init();
            }
        });
    };

    $.fn.multiSelect.defaults = {
        keySelect: [32],
        selectableOptgroup: false,
        disabledClass: 'disabled',
        dblClick: false,
        keepOrder: false,
        cssClass: ''
    };

    $.fn.multiSelect.Constructor = MultiSelect;

    $.fn.insertAt = function (index, $parent) {
        return this.each(function () {
            if (index === 0) {
                $parent.prepend(this);
            } else {
                $parent.children().eq(index - 1).after(this);
            }
        });
    };

    $.fn.selectFunction = function(selectables, selections, options, that, method) {
        if (selectables.length > 0) {
            selectables.addClass('ms-selected').hide();
            selections.addClass('ms-selected').show();

            options.prop('selected', true);
            options.insertAfter('.cc-select-multiselect option:last');
            $.fn.sortselect();

            that.$container.find(that.elemsSelector).removeClass('ms-hover');

            var selectableOptgroups = that.$selectableUl.children('.ms-optgroup-container');
            if (selectableOptgroups.length > 0) {
                selectableOptgroups.each(function () {
                    var selectablesLi = $(this).find('.ms-elem-selectable');
                    if (selectablesLi.length === selectablesLi.filter('.ms-selected').length) {
                        $(this).find('.ms-optgroup-label').hide();
                    }
                });

                var selectionOptgroups = that.$selectionUl.children('.ms-optgroup-container');
                selectionOptgroups.each(function () {
                    var selectionsLi = $(this).find('.ms-elem-selection');
                    if (selectionsLi.filter('.ms-selected').length > 0) {
                        $(this).find('.ms-optgroup-label').show();
                    }
                });
            } else {
                if (that.options.keepOrder && method !== 'init') {
                    var selectionLiLast = that.$selectionUl.find('.ms-selected');
                    if ((selectionLiLast.length > 1) && (selectionLiLast.last().get(0) != selections.get(0))) {
                        selections.insertAfter(selectionLiLast.last());
                    }
                }
            }
        }
    }

}(window.jQuery);
