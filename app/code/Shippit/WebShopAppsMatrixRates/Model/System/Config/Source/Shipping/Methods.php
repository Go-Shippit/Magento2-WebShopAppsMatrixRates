<?php

namespace Shippit\WebShopAppsMatrixRates\Model\System\Config\Source\Shipping;

use Magento\Store\Model\ScopeInterface;

class Methods extends \Shippit\Shipping\Model\Config\Source\Shipping\Methods
{
    /**
     * @var \Shippit\WebShopAppsMatrixRates\Helper\Data
     */
    protected $_helper;

    /**
     * Core store config
     *
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * @var \Magento\Shipping\Model\Config
     */
    protected $_shippingConfig;

    /**
     * @param \Shippit\WebShopAppsMatrixRates\Helper\Data $helper
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Shipping\Model\Config $shippingConfig
     */
    public function __construct(
        \Shippit\WebShopAppsMatrixRates\Helper\Data $helper,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Shipping\Model\Config $shippingConfig
    ) {
        $this->_helper = $helper;
        $this->_scopeConfig = $scopeConfig;
        $this->_shippingConfig = $shippingConfig;
    }

    /**
     * Return array of carriers.
     *
     * @param bool $isActiveOnlyFlag
     * @return array
     */
    public function toOptionArray($showPlaceholder = false, $excludeShippit = false)
    {
        $optionsArray = parent::toOptionArray($showPlaceholder, $excludeShippit);

        // If the webshopappsmodule is installed,
        // fetch the available methods from their tables
        if (!$this->_helper->isActive()
            || !$this->_helper->isWebshopappsMatrixrateActive()) {
            return $optionsArray;
        }

        $matrixRateOptions = $this->getWsaMatrixRateOptions();
        $optionsArray['matrixrate']['value'] = $matrixRateOptions;

        return $optionsArray;
    }

    protected function getWsaMatrixRateOptions()
    {
        $optionsArray = [];

        $matrixRateRates = $this->getWsaMatrixRateRates();

        // Get the matrix rate name
        $title = $this->_scopeConfig->getValue('carriers/matrixrate/title', 'website');

        foreach ($matrixRateRates as $matrixRateRate) {
            $optionsArray[] = array(
                'label' => sprintf(
                    '[matrixrate_%s] %s',
                    $matrixRateRate['pk'],
                    $matrixRateRate['shipping_method']
                ),
                'value' => sprintf(
                    'matrixrate_matrixrate_%s',
                    $matrixRateRate['pk']
                )
            );
        }

        return $optionsArray;
    }

    protected function getWsaMatrixRateRates()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();

        $query = 'SELECT `pk`, `shipping_method` FROM `webshopapps_matrixrate`';

        return $connection->fetchAll($query);
    }
}
