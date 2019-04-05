<?php
/**
 * Copyright (c) 2019
 * Copyright Holder : CompactCode - CompactCode BvBa - Belgium
 * Copyright : Unless granted permission from CompactCode BvBa.
 * You can not distribute, reuse, edit, resell or sell this.
 */

namespace CompactCode\Base\Block\Adminhtml\Widget\Multiselect;

use Magento\Backend\Block\Template;

class WidgetMultiselectRenderer extends Template{

    protected $_elementFactory;
    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Data\Form\Element\Factory $elementFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Data\Form\Element\Factory $elementFactory,
        array $data = []
    ) {
        $this->_elementFactory = $elementFactory;
        parent::__construct($context, $data);
    }
    /**
     * Prepare chooser element HTML
     *
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element Form Element
     * @return \Magento\Framework\Data\Form\Element\AbstractElement
     */
    public function prepareElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $data = array_merge($element->getData(), $this->getData());
        $input = $this->_elementFactory->create("CompactCode\Base\Block\Adminhtml\Widget\Multiselect\WidgetMultiselect", ['data' => $data]);
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