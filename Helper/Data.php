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

namespace Shippit\WebShopAppsMatrixRates\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    const XML_PATH_SETTINGS = 'shippit/addon_webshopappsmatrixrates/';

    protected $scopeConfig;
    protected $moduleList;

    /**
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\Module\ModuleList $moduleList
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->moduleList = $moduleList;
    }

    /**
     * Return store config value for key
     *
     * @param   string $key
     * @return  string
     */
    public function getValue($key, $scope = 'website')
    {
        $path = self::XML_PATH_SETTINGS . $key;

        return $this->scopeConfig->getValue($path, $scope);
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return self::getValue('active');
    }

    public function getModuleVersion()
    {
        $version = $this->moduleList
            ->getOne('Shippit_WebShopAppsMatrixRates')['setup_version'];

        return $version;
    }
}
