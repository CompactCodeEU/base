<?php
/**
 * Copyright (c) 2019
 * Copyright Holder : CompactCode - CompactCode BvBa - Belgium
 * Copyright : Unless granted permission from CompactCode BvBa.
 * You can not distribute, reuse, edit, resell or sell this.
 */

namespace CompactCode\Base\Model\Config\Source;


use Magento\Framework\Option\ArrayInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Google\Cloud\Translate\TranslateClient;

class StoreLanguages implements ArrayInterface
{
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;
    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * StoreLanguages constructor.
     * @param StoreManagerInterface $storeManager
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(StoreManagerInterface $storeManager, ScopeConfigInterface $scopeConfig)
    {

        $this->storeManager = $storeManager;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Return array of options as value-label pairs
     *
     * @return array Format: array(array('value' => '<value>', 'label' => '<label>'), ...)
     */
    public function toOptionArray()
    {
        $connection = new TranslateClient(array('key' => 'AIzaSyC3zSJMaaWFSWWVullKOKhMRB_Um_0ouCQ'));
        $response = $connection->localizedLanguages();

        $languages = array_map(function ($language) {
            return $language;
        }, $response);

        $options = [];
        foreach ($languages as $language) {
            $options[] = [
                'label' => $language['name'],
                'value' => $language['code']
            ];
        }
        return $options;
    }
}