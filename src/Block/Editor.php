<?php
/**
 * Copyright (c) 2019
 * Copyright Holder : CompactCode - CompactCode BvBa - Belgium
 * Copyright : Unless granted permission from CompactCode BvBa.
 * You can not distribute, reuse, edit, resell or sell this.
 */

namespace CompactCode\Base\Block;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Registry;
use Magento\Backend\Block\Template\Context;
use Magento\Cms\Model\Wysiwyg\Config as WysiwygConfig;
use Magento\Framework\Data\Form\Element\AbstractElement;

class Editor extends Field
{
    //    store niet gedaan (value)
    /**
     * @var  WysiwygConfig
     */
    private $wysiwygConfig;

    /**
     * @param Context       $context
     * @param WysiwygConfig $wysiwygConfig
     * @param array         $data
     */
    public function __construct
    (
        Context $context,
        WysiwygConfig $wysiwygConfig,
        array $data = []
    )
    {
        $this->wysiwygConfig = $wysiwygConfig;
        parent::__construct($context, $data);
    }

    public function _getElementHtml(AbstractElement $element)
    {
        // set wysiwyg for element
        $element->setWysiwyg(true);
        // set configuration values
        $element->setConfig($this->wysiwygConfig->getConfig([
            'enabled' => true,
            'hidden' => false,
            'add_directives' => true,
            'use_container' => true,
            'add_variables' => false,
            'add_widgets' => false,
            'height' => '200px',
        ]));

        return parent::_getElementHtml($element);
    }
}
