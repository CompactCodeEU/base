<?php
/**
 * Copyright (c) 2019
 * Copyright Holder : CompactCode - CompactCode BvBa - Belgium
 * Copyright : Unless granted permission from CompactCode BvBa.
 * You can not distribute, reuse, edit, resell or sell this.
 */

namespace CompactCode\Base\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;
use CompactCode\Base\Model\Config\Source\Animations;
use Magento\Framework\App\Helper\Context;

class Data extends AbstractHelper
{
    /**
     * @var Animations
     */
    protected $animations;

    /**
     * Data constructor.
     * @param Context $context
     * @param Animations $animations
     */
    public function __construct(
        Context $context,
        Animations $animations
    )
    {
        parent::__construct($context);
        $this->animations = $animations;
    }

    protected function getConfig($config_path, $scope = ScopeInterface::SCOPE_STORE, $scopeid = null)
    {
        return $this->scopeConfig->getValue(
            $config_path,
            $scope,
            $scopeid
        );
    }

    protected function getPath($section = null, $group = null, $field = null)
    {
        if (!isset($section, $group, $field)) {
            return null;
        }

        $path = $section . '/' . $group . '/' . $field;
        return $path;
    }
}