<?php
/**
 * Copyright (c) 2019
 * Copyright Holder : CompactCode - CompactCode BvBa - Belgium
 * Copyright : Unless granted permission from CompactCode BvBa.
 * You can not distribute, reuse, edit, resell or sell this.
 */

namespace CompactCode\Base\Block\Adminhtml\Widget\Multiselect;

use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Escaper;
use Magento\Framework\Data\Form\Element\CollectionFactory;
use Magento\Framework\Data\Form\Element\Factory;
use Magento\Framework\ObjectManagerInterface;

class WidgetMultiselect extends AbstractElement
{
    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @param Factory $factoryElement
     * @param CollectionFactory $factoryCollection
     * @param Escaper $escaper
     * @param ObjectManagerInterface $objectManager
     * @param array $data
     */
    public function __construct(
        Factory $factoryElement,
        CollectionFactory $factoryCollection,
        Escaper $escaper,
        ObjectManagerInterface $objectManager,
        $data = []
    )
    {
        parent::__construct($factoryElement, $factoryCollection, $escaper, $data);
        $this->setType('select');
        $this->setExtType('multiple');
        $this->setSize(10);
        $this->objectManager = $objectManager;
    }

    /**
     * Get the name
     *
     * @return string
     */
    public function getName()
    {
        $name = parent::getName();
        if (strpos($name, '[]') === false) {
            $name .= '[]';
        }
        return $name;
    }

    /**
     * Get the element as HTML
     *
     * @return string
     */
    public function getElementHtml()
    {
        $sourceClass = $this->getData('source_model');

        //OBJECT MANAGER IS ONLY USED TO DYNAMICALLY CONSTRUCT SOURCE MODELS!
        if (!isset($sourceClass) || empty($sourceClass)) {
            return '<p>' . __('Source model is undefined') . '</p>';
        }
        $sourceModel = $this->objectManager->create($sourceClass);
        $this->addClass('select multiselect admin__control-multiselect cc-multiselect cc-select-multiselect');
        $html = '';
        if ($this->getCanBeEmpty()) {
            $html .= '
                <input type="hidden" id="' . $this->getHtmlId() . '_hidden" name="' . parent::getName() . '" value="" />
                ';
        }
        if (!empty($this->_data['disabled'])) {
            $html .= '<input type="hidden" name="' . parent::getName() . '_disabled" value="" />';
        }

        $html .= '<div class="deselect-container"><div class="deselect"> Deselect All </div></div>';

        $html .= '<select id="' . $this->getHtmlId() . '" name="' . $this->getName() . '" ' . $this->serialize(
                $this->getHtmlAttributes()
            ) . $this->_getUiId() . ' multiple="multiple">' . "\n";

        $value = $this->getValue();
        if (!is_array($value)) {
            $value = explode(',', $value);
        }

        $values = $sourceModel->toOptionArray();
        if ($values) {
            foreach ($values as $option) {
                if (is_array($option['value'])) {
                    $html .= '<optgroup label="' . $option['label'] . '">' . "\n";
                    foreach ($option['value'] as $groupItem) {
                        $html .= $this->_optionToHtml($groupItem, $value);
                    }
                    $html .= '</optgroup>' . "\n";
                } else {
                    $html .= $this->_optionToHtml($option, $value);
                }
            }
        }

        $html .= '</select>' . "\n";
        $html .= $this->getAfterElementHtml();

        return $html;
    }

    /**
     * Get the HTML attributes
     *
     * @return string[]
     */
    public function getHtmlAttributes()
    {
        return [
            'title',
            'class',
            'style',
            'onclick',
            'onchange',
            'disabled',
            'size',
            'tabindex',
            'data-form-part',
            'data-role',
            'data-action',
            'data-bind'
        ];
    }

    /**
     * Get the default HTML
     *
     * @return string
     */
    public function getDefaultHtml()
    {
        $multiselectoptions = $this->getData('multiselect_options');
        $max_items = $multiselectoptions['max_items'];
        $selectableName = $multiselectoptions['selectable_name'];
        $selectedName = $multiselectoptions['selected_name'];

        $result = '<div class="cc-multiselect" id="' . $this->getHtmlId() . '">';
        $result .= $this->getNoSpan() === true ? '' : '<span class="field-row">' . "\n";
        $result .= $this->getElementHtml();

        if ($this->getSelectAll() && $this->getDeselectAll()) {
            $result .= '<a href="#" onclick="return ' .
                $this->getJsObjectName() .
                '.selectAll()">' .
                $this->getSelectAll() .
                '</a> <span class="separator">&nbsp;|&nbsp;</span>';
            $result .= '<a href="#" onclick="return ' .
                $this->getJsObjectName() .
                '.deselectAll()">' .
                $this->getDeselectAll() .
                '</a>';
        }

        $result .= $this->getNoSpan() === true ? '' : '</span>' . "\n";

        $result .= '<script type="text/javascript">
                        require(["jquery", "cc-widget-multiselect"], function ($) {
                        $(document).ready(function () {
                            var element = $("select#'.$this->getHtmlId().'.cc-multiselect");
                            element.multiSelect({ 
                                keepOrder: true,
                                max_items: '.(isset($max_items) ? "'$max_items'" : "0").',
                                selectableHeader : \'<h4 style="margin:0">' .
                                                   (isset($selectableName) ? "$selectableName" : "Selectable").'</h4>\',
                                selectionHeader : \'<h4 style="margin:0"> ' .
                                                   (isset($selectedName) ? "$selectedName" : "Selected").' </h4>\'
                                
                            });      
                            
                            $(".deselect").on("click", function() {
                                element.multiSelect("deselect_all");
                            })
                        });
                    });

                    </script>';

        $result .= '</div>';
        return $result;
    }

    /**
     * Get the  name of the JS object
     *
     * @return string
     */
    public function getJsObjectName()
    {
        return $this->getHtmlId() . 'ElementControl';
    }

    /**
     * @param array $option
     * @param array $selected
     * @return string
     */
    protected function _optionToHtml($option, $selected)
    {
        $html = '<option value="' . $this->_escape($option['value']) . '"';
        $html .= isset($option['title']) ? 'title="' . $this->_escape($option['title']) . '"' : '';
        $html .= isset($option['style']) ? 'style="' . $option['style'] . '"' : '';
        if (in_array((string)$option['value'], $selected)) {
            $html .= ' selected="selected"';
        }
        $html .= '>' . $this->_escape($option['label']) . '</option>' . "\n";
        return $html;
    }
}
