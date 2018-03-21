<?php

namespace Shippit\WebShopAppsMatrixRates\Model\System\Config\Source\Shipping;

use Magento\Store\Model\ScopeInterface;

class Methods extends \Shippit\Shipping\Model\Config\Source\Shipping\Methods
{
    /**
     * @var \Shippit\WebShopAppsMatrixRates\Helper\Data
     */
    protected $helper;

    /**
     * Core store config
     *
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var \Magento\Shipping\Model\Config
     */
    protected $shippingConfig;

    /**
     * @var \Magento\Framework\App\ResourceConnection
     */
    protected $resourceConnection;

    /**
     * @param \Shippit\WebShopAppsMatrixRates\Helper\Data $helper
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Shipping\Model\Config $shippingConfig
     * @param \Magento\Framework\App\ResourceConnection $resourceConnection
     */
    public function __construct(
        \Shippit\WebShopAppsMatrixRates\Helper\Data $helper,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Shipping\Model\Config $shippingConfig,
        \Magento\Framework\App\ResourceConnection $resourceConnection
    ) {
        $this->helper = $helper;
        $this->scopeConfig = $scopeConfig;
        $this->shippingConfig = $shippingConfig;
        $this->resourceConnection = $resourceConnection;
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

        // If the customisation is not active,
        // return the parent optionsArray
        if (!$this->helper->isActive()) {
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
        $title = $this->scopeConfig->getValue(
            'carriers/matrixrate/title',
            'website'
        );

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
        $connection = $this->resourceConnection->getConnection();
        $tableName = $this->resourceConnection->getTableName('webshopapps_matrixrate');

        $query = $connection->select()
            ->from($tableName, array('pk', 'shipping_method'));

        return $connection->fetchAll($query);
    }
}
