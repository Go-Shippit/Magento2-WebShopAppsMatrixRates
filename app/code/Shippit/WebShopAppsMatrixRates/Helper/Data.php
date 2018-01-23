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

use \Magento\Framework\App\Config\ScopeConfigInterface;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    const XML_PATH_SETTINGS = 'shippit/addon_webshopappsmatrixrates/active';
    const XML_PATH_MATRIXRATE = 'carriers/matrixrate/active';

    /**
     * @var \Magento\Framework\Module\Manager
     */
    protected $_moduleManager;

    protected $_scopeConfig;
    protected $_moduleList;

    /**
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\Module\ModuleList $moduleList,
        \Magento\Framework\Module\Manager $moduleManager
    ) {
        $this->_scopeConfig = $scopeConfig;
        $this->_moduleList = $moduleList;
        $this->_moduleManager = $moduleManager;
    }

    /**
     * Return store config value for key
     *
     * @param   string $key
     * @return  string
     */
    public function getValue($path, $scope = 'website')
    {
        return $this->_scopeConfig->getValue($path, $scope);
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return self::getValue(self::XML_PATH_SETTINGS);
    }

    public function getModuleVersion()
    {
        $version = $this->_moduleList
            ->getOne('WebShopApps_MatrixRate')['setup_version'];

        return $version;
    }

    public function isWebshopappsMatrixrateActive()
    {
        return self::getValue(self::XML_PATH_MATRIXRATE);
    }
}
