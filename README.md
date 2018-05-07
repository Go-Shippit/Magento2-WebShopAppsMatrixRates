# Shippit Magento 2 Module Addon — WebShopApps MatrixRates Support

This module addon adds functionality to the Shippit Magento 2 module, enabling the WebShopApps MatrixRates shipping methods to be presented as options in the Shippit Method Mapping configuration.

## Installation (Composer)
1. Add this extension to your repository 

```
composer config repositories.shippit/magento2-addon-webshopapps-matrixrates vcs https://github.com/Go-Shippit/Magento2-WebShopAppsMatrixRates.git
```

2. Update your composer.json

```
composer require "shippit/magento2-addon-webshopapps-matrixrates:^1.0.0"
```

3. Enable the module and clear static content.

```
php bin/magento module:enable Shippit_WebShopAppsMatrixRates --clear-static-content
php bin/magento setup:upgrade
```

## Installation (Manually)
1. Pull the code.
2. Copy the code in ./app/code/Shippit/WebShopAppsMatrixRates/.
3. Enable the module and clear static content.

```
php bin/magento module:enable Shippit_WebShopAppsMatrixRates --clear-static-content
php bin/magento setup:upgrade
```

## Features
- Adds the ability to use the Shippit Shipping Method Mapping to the Shipping Methods created by the WebShopApps MatrixRates module
