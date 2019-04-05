<?php
/**
 * Copyright (c) 2019
 * Copyright Holder : CompactCode - CompactCode BvBa - Belgium
 * Copyright : Unless granted permission from CompactCode BvBa.
 * You can not distribute, reuse, edit, resell or sell this.
 */

namespace CompactCode\Base\Block\Form\Field;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;

class DynamicRows extends AbstractFieldArray
{
    protected function _prepareToRender()
    {
        $this->addColumn('link', ['label' => __('Link'), 'class' => 'required-entry']);
        $this->addColumn('linktext', ['label' => __('Link text'), 'class' => 'required-entry']);
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add link');
    }
}