<?php
/**
 * Copyright (c) 2019
 * Copyright Holder : CompactCode - CompactCode BvBa - Belgium
 * Copyright : Unless granted permission from CompactCode BvBa.
 * You can not distribute, reuse, edit, resell or sell this.
 */

namespace CompactCode\Base\Block\Adminhtml\Widget;

use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Data\Form\Element\CollectionFactory;
use Magento\Framework\Data\Form\Element\Factory;
use Magento\Framework\Escaper;

class ColorPicker extends AbstractElement
{

    /**
     * TemplateButtons constructor.
     * @param Factory $factoryElement
     * @param CollectionFactory $factoryCollection
     * @param Escaper $escaper
     * @param array $data
     */
    public function __construct
    (
        Factory $factoryElement,
        CollectionFactory $factoryCollection,
        Escaper $escaper,
        array $data = []
    )
    {
        parent::__construct($factoryElement, $factoryCollection, $escaper, $data);
        $this->setType('text');
    }

    public function getElementHtml()
    {
        $html = '<input name="' . $this->getName() .
                '" id="' . $this->getHtmlId() .
                '" value="' . $this->getValue() .
                '" />';

        return $html;
    }

    public function getDefaultHtml()
    {
        $value = $this->getData('value');
        $result = $this->getElementHtml();
        $result .= '<script type="text/javascript">
                require(["jquery","jquery/colorpicker/js/colorpicker"], function ($) {
                    $(document).ready(function () {
                        var $el = $("#' . $this->getHtmlId() . '");
                        $el.css("backgroundColor", "' . $value . '");

                        // Attach the color picker
                        $el.ColorPicker({
                            color: "' . $value . '",
                            onChange: function (hsb, hex, rgb) {
                                $el.css("backgroundColor", "#" + hex).val("#" + hex).trigger( "change" );
                            }
                        });
                    });
                });
                </script>';
        return $result;
    }
}
