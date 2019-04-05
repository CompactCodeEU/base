<?php
/**
 * Copyright (c) 2019
 * Copyright Holder : CompactCode - CompactCode BvBa - Belgium
 * Copyright : Unless granted permission from CompactCode BvBa.
 * You can not distribute, reuse, edit, resell or sell this.
 */

namespace CompactCode\Base\Block\Adminhtml\Widget;

use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Data\Form\Element\Factory;

class ColorPickerRenderer extends Template
{
    private $elementFactory;

    /**
     * @param Context $context
     * @param Factory $elementFactory
     * @param array $data
     */
    public function __construct
    (
        Context $context,
        Factory $elementFactory,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->elementFactory = $elementFactory;
    }

    /**
     * Prepare chooser element HTML
     *
     * @param AbstractElement $element Form Element
     * @return AbstractElement
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function prepareElementHtml(AbstractElement $element)
    {
        $input = $this->elementFactory->create(
            "CompactCode\Base\Block\Adminhtml\Widget\ColorPicker",
            ['data' => $element->getData()]
        );
        $input->setId($element->getId());
        $input->setForm($element->getForm());

        if ($element->getRequired()) {
            $input->addClass('required-entry');
        }

        $element->setValue(null);
        $element->setData('after_element_html', $input->getDefaultHtml());
        $element->setData('no_wrap_as_addon', true);
        return $element;
    }
}
