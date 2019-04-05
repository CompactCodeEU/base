<?php
/**
 * Copyright (c) 2019
 * Copyright Holder : CompactCode - CompactCode BvBa - Belgium
 * Copyright : Unless granted permission from CompactCode BvBa.
 * You can not distribute, reuse, edit, resell or sell this.
 */

namespace CompactCode\Base\Block;

use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

class Color extends Field
{
    //    store niet gedaan (value)
    /**
     * @param Context $context
     * @param array                                   $data
     */
    public function __construct(
        Context $context, array $data = []
    )
    {
        parent::__construct($context, $data);
    }
    /**
    @param  \Magento\Framework\Data\Form\Element\AbstractElement $element
    Input  : add color picker in admin configuration fields
    Output : return string script
     */
    protected function _getElementHtml(AbstractElement $element)
    {
        $html = $element->getElementHtml();
        $value = $element->getData('value');

        $html .= '<script type="text/javascript">
                require(["jquery","jquery/colorpicker/js/colorpicker"], function ($) {
                    $(document).ready(function () {
                        var $el = $("#'.$element->getHtmlId().'");
                        $el.css("backgroundColor", "'.$value.'");

                        // Attach the color picker
                        $el.ColorPicker({
                            color: "'.$value.'",
                            onChange: function (hsb, hex, rgb) {
                                $el.css("backgroundColor", "#" + hex).val("#" + hex).trigger( "change" );
                            }
                        });
                    });
                });
                </script>';

        return $html;
    }
}
