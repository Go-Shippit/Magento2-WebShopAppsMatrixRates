<?php
/**
 * Shippit Pty Ltd
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the terms
 * that is available through the world-wide-web at this URL:
 * http://www.shippit.com/terms
 *
 * @category   Shippit
 * @copyright  Copyright (c) by Shippit Pty Ltd (http://www.shippit.com)
 * @author     Matthew Muscat <matthew@mamis.com.au>
 * @license    http://www.shippit.com/terms
 */

namespace Shippit\WebShopAppsMatrixRates\Observer\System;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class Config implements ObserverInterface
{
    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    protected $messageManager;

    /**
     * @var \Shippit\WebShopAppsMatrixRates\Helper\Data
     */
    protected $helper;

    public function __construct(
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Shippit\WebShopAppsMatrixRates\Helper\Data $helper
    ) {
        $this->helper = $helper;
        $this->messageManager = $messageManager;
    }

    public function execute(Observer $observer)
    {
        if (!$this->helper->isActive()) {
            return;
        }

        $this->messageManager->addWarning(
            __('If you have just updated your WebShopApps Matrix Rates - Don\'t Forget to update your Shippit Shipping Method Mappings')
        );
    }
}
