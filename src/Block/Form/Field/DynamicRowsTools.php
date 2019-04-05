<?php
/**
 * Copyright (c) 2019
 * Copyright Holder : CompactCode - CompactCode BvBa - Belgium
 * Copyright : Unless granted permission from CompactCode BvBa.
 * You can not distribute, reuse, edit, resell or sell this.
 */

namespace CompactCode\Base\Block\Form\Field;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;

class DynamicRowsTools extends AbstractFieldArray
{
    protected function _prepareToRender()
    {
        $this->addColumn('name', ['label' => __('Name'), 'class' => 'required-entry']);
        $this->addColumn('frontend-model', ['label' => __('Front-End Model')]);
        $this->addColumn('backend-model', ['label' => __('Back-End Model')]);
        $this->addColumn('source-model', ['label' => __('Source Model')]);
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add tool');
    }
}
