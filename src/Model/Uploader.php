<?php
/**
 * Copyright (c) 2019
 * Copyright Holder : CompactCode - CompactCode BvBa - Belgium
 * Copyright : Unless granted permission from CompactCode BvBa.
 * You can not distribute, reuse, edit, resell or sell this.
 */

namespace CompactCode\Base\Model;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Filesystem;
use Magento\Framework\UrlInterface;
use Magento\MediaStorage\Helper\File\Storage\Database;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Store\Model\StoreManagerInterface;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use Psr\Log\LoggerInterface;

class Uploader
{
    /**
     * Core file storage database
     *
     * @var \Magento\MediaStorage\Helper\File\Storage\Database
     */
    protected $coreFileStorageDatabase;
    /**
     * Media directory object (writable).
     *
     * @var \Magento\Framework\Filesystem\Directory\WriteInterface
     */
    protected $mediaDirectory;
    /**
     * Uploader factory
     *
     * @var \Magento\MediaStorage\Model\File\UploaderFactory
     */
    protected $uploaderFactory;
    /**
     * Store manager
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;
    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;
    /**
     * Allowed extensions
     *
     * @var string
     */
    protected $allowedExtensions;

    /**
     * @param Database $coreFileStorageDatabase
     * @param Filesystem $filesystem
     * @param UploaderFactory $uploaderFactory
     * @param StoreManagerInterface $storeManager
     * @param LoggerInterface $logger
     * @param array $allowedExtensions
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    public function __construct(
        Database $coreFileStorageDatabase,
        Filesystem $filesystem,
        UploaderFactory $uploaderFactory,
        StoreManagerInterface $storeManager,
        LoggerInterface $logger,
        $allowedExtensions = []
    ) {
        $this->coreFileStorageDatabase  = $coreFileStorageDatabase;
        $this->mediaDirectory           = $filesystem->getDirectoryWrite(DirectoryList::MEDIA);
        $this->uploaderFactory          = $uploaderFactory;
        $this->storeManager             = $storeManager;
        $this->logger                   = $logger;
        $this->allowedExtensions        = $allowedExtensions;
    }

    /**
     * Set allowed extensions
     *
     * @param string[] $allowedExtensions
     *
     * @return void
     */
    public function setAllowedExtensions($allowedExtensions)
    {
        $this->allowedExtensions = $allowedExtensions;
    }
    /**
     * Retrieve base path
     *
     * @return string[]
     */
    public function getAllowedExtensions()
    {
        return $this->allowedExtensions;
    }
    /**
     * Retrieve path
     *
     * @param string $path
     * @param string $name
     *
     * @return string
     */
    public function getFilePath($path, $name)
    {
        return rtrim($path, '/') . '/' . ltrim($name, '/');
    }

    public function getBaseUrl()
    {
        return $this->storeManager
            ->getStore()
            ->getBaseUrl(
                UrlInterface::URL_TYPE_MEDIA
            );
    }
    /**
     * Checking file for save and save it to tmp dir
     *
     * @param string $fileId
     * @return string[]
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function saveFile($fileId, $basepath)
    {
        $uploader = $this->uploaderFactory->create(['fileId' => $fileId]);
        $uploader->setAllowedExtensions($this->getAllowedExtensions());
        $uploader->setAllowRenameFiles(true);
        $uploader->setFilesDispersion(true);
        $result = $uploader->save($this->mediaDirectory->getAbsolutePath($basepath));
        if (!$result) {
            throw new LocalizedException(
                __('File can not be saved to the destination folder.')
            );
        }
        /**
         * Workaround for prototype 1.7 methods "isJSON", "evalJSON" on Windows OS
         */
        $result['path'] = $this->getFilePath($basepath, $result['file']);
        $result['url'] =  $this->getBaseUrl() . $this->getFilePath($basepath, $result['file']);
        if (isset($result['file'])) {
            try {
                $relativePath = rtrim($basepath, '/') . '/' . ltrim($result['file'], '/');
                $this->coreFileStorageDatabase->saveFile($relativePath);
            } catch (\Exception $e) {
                $this->logger->critical($e);
                throw new LocalizedException(
                    __('Something went wrong while saving the file(s).')
                );
            }
        }
        return $result;
    }
}