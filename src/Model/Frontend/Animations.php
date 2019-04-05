<?php
/**
 * Copyright (c) 2019
 * Copyright Holder : CompactCode - CompactCode BvBa - Belgium
 * Copyright : Unless granted permission from CompactCode BvBa.
 * You can not distribute, reuse, edit, resell or sell this.
 */

namespace CompactCode\Base\Model\Frontend;
use CompactCode\Base\Model\Config\Source\Animations as SourceAnimations;
use Magento\Backend\Block\Template\Context;

class Animations extends \Magento\Config\Block\System\Config\Form\Field
{
    //    store niet gedaan (value)
    /**
     * @var SourceAnimations
     */
    private $sourceanimations;

    /**
     * @param Context $context
     * @param SourceAnimations $sourceanimations
     * @param array $data
     */
    public function __construct(
        Context $context,
        SourceAnimations $sourceanimations,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->sourceanimations = $sourceanimations;
    }
    /**
    @param  \Magento\Framework\Data\Form\Element\AbstractElement $element
    Output : return string script
     */
    protected function _getElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element, $class = 'input#live_update_cart_settings_loader_color')
    {
        $html = '';
        $values = $element->getData('values');
        $html .= '<div id="cc-loading-container" data-mage-init=\'{ "ccpreview" : { "colorinput" :"' . $class . '"}}\'>';
        $html .= '<div class="cc-preview"><div class="spinner"></div></div>';
        $html .= '<select class="cc-preview-selector" id="' . $element->getData('html_id') .'" name="' . $element->getData('name') . '" ' . ($element->getData('inherit') ? "class=\"disabled\" disabled" : "") .'>';

        foreach ($values as $value){
            $html .= '<option ' . ($value['value'] == $element->getData('value') ? "selected=\"selected\"" : "")  . " " .  'data-childclass="' . $value['data-childclass'] . '" data-children="' . $value['data-children'] . '" value="' . $value['value'] . '">' . $value['label'] .'</option>';
        }
        $html .= '</select>';
        $html .= '</div>';


        return $html;
    }
}