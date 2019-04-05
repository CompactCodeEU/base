<?php
/**
 * Copyright (c) 2019
 * Copyright Holder : CompactCode - CompactCode BvBa - Belgium
 * Copyright : Unless granted permission from CompactCode BvBa.
 * You can not distribute, reuse, edit, resell or sell this.
 */

namespace CompactCode\Base\Model\Config\Backend;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Config\Model\Config\Backend\File\RequestData\RequestDataInterface;
use Magento\Config\Model\Config\Backend\Image;
use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\App\Request\Http;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Filesystem;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
use Magento\MediaStorage\Model\File\UploaderFactory;

class ImageUpload extends Image
{
    /**
     * The tail part of directory path for uploading
     */

    const UPLOAD_DIR = 'compactcode/images';
    protected $uploadDirExtend = '';
    /**
     * Upload max file size in kilobytes
     *
     * @var int
     */
    protected $_maxFileSize = 2048;

    /**
     * @var Http
     */
    private $http;

    /**
     * Return path to directory for upload file
     *
     * @param Context $context
     * @param Registry $registry
     * @param ScopeConfigInterface $config
     * @param TypeListInterface $cacheTypeList
     * @param UploaderFactory $uploaderFactory
     * @param RequestDataInterface $requestData
     * @param Filesystem $filesystem
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param Http $http
     * @param array $data
     */

    public function __construct(
        Context $context,
        Registry $registry,
        ScopeConfigInterface $config,
        TypeListInterface $cacheTypeList,
        UploaderFactory $uploaderFactory,
        RequestDataInterface $requestData,
        Filesystem $filesystem,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        Http $http,
        array $data = []
    )
    {
        parent::__construct($context, $registry, $config, $cacheTypeList, $uploaderFactory, $requestData, $filesystem, $resource, $resourceCollection, $data);
        $this->http = $http;
    }

    /**
     * Return path to directory for upload file
     *
     * @return string
     */
    protected function _getUploadDir()
    {
        return $this->_mediaDirectory->getAbsolutePath($this->_appendScopeInfo(self::UPLOAD_DIR . $this->uploadDirExtend));
    }

    /**
     * Makes a decision about whether to add info about the scope
     *
     * @return boolean
     */
    protected function _addWhetherScopeInfo()
    {
        return true;
    }

    /**
     * Save uploaded file before saving config value
     *
     * Save changes and delete file if "delete" option passed
     *
     * @return $this
     */
    public function beforeSave()
    {
        $value = $this->getValue();
        $files = $this->http->getFiles();

        if (isset($value)) {
            $deleteFlag = is_array($value) && !empty($value['delete']);
            if (isset($files['groups'])) {
                $fileTmpName = $files['groups'][$this->getGroupId()]['fields'][$this->getField()]['value'];
                if ($this->getOldValue() && ($fileTmpName || $deleteFlag)) {
                    $this->_mediaDirectory->delete(self::UPLOAD_DIR . '/' . $this->getOldValue());
                }
            }
        }
        return parent::beforeSave();
    }

    protected function _getAllowedExtensions()
    {
        return ['jpg', 'jpeg', 'png', 'svg'];
    }
}