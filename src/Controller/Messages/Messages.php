<?php
/**
 * Copyright (c) 2019
 * Copyright Holder : CompactCode - CompactCode BvBa - Belgium
 * Copyright : Unless granted permission from CompactCode BvBa.
 * You can not distribute, reuse, edit, resell or sell this.
 */

namespace CompactCode\Base\Controller\Messages;

use Magento\Framework\App\Action\Action;

class Messages extends Action
{
    public function execute()
    {
        $messages = $this->getRequest()->getParam('messages');
        if (isset($messages) && is_array($messages)) {
            if (key_exists('errors', $messages)) {
                $this->addErrorMessage($messages);
            }
            if (key_exists('success', $messages)) {
                $this->addSuccesMessage($messages);
            }
            if (key_exists('notice', $messages)) {
                $this->addNoticeMessage($messages);
            }
        }
    }

    /**
     * @param string $messages | $messages[]
     */
    public function addErrorMessage($messages)
    {
        if (is_string($messages)) {
            $this->messageManager->addErrorMessage(__($messages));
        }
        if (is_array($messages)) {
            foreach ($messages as $message) {
                if (is_string($message)) {
                    $this->messageManager->addErrorMessage(__($message));
                }
            }
        }
    }

    /**
     * @param string $messages | $messages[]
     */
    public function addSuccesMessage($messages)
    {
        if (is_string($messages)) {
            $this->messageManager->addSuccessMessage(__($messages));
        }
        if (is_array($messages)) {
            foreach ($messages as $message) {
                if (is_string($message)) {
                    $this->messageManager->addSuccessMessage(__($message));
                }
            }
        }
    }

    /**
     * @param string $messages | $messages[]
     */
    public function addNoticeMessage($messages)
    {
        if (is_string($messages)) {
            $this->messageManager->addNoticeMessage(__($messages));
        }
        if (is_array($messages)) {
            foreach ($messages as $message) {
                if (is_string($message)) {
                    $this->messageManager->addNoticeMessage(__($message));
                }
            }
        }
    }
}