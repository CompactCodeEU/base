<?php
/**
 * Copyright (c) 2019
 * Copyright Holder : CompactCode - CompactCode BvBa - Belgium
 * Copyright : Unless granted permission from CompactCode BvBa.
 * You can not distribute, reuse, edit, resell or sell this.
 */

namespace CompactCode\Base\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class IsActive
 */
class StoreViews implements OptionSourceInterface
{
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * StoreViews constructor.
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(StoreManagerInterface $storeManager)
    {
        $this->storeManager = $storeManager;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $stores = $this->storeManager->getStores(false);
        $options = [];
        foreach ($stores as $store) {
            $options[] = [
                'label' => $store->getName(),
                'value' => $store->getId(),
            ];
        }
        return $options;
    }
}
