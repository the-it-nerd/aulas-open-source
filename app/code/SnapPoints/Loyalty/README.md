# Mage2 Module SnapPoints Loyalty

    ``snappoints/module-loyalty``

 - [Main Functionalities](#markdown-header-main-functionalities)
 - [Installation](#markdown-header-installation)
 - [Configuration](#markdown-header-configuration)
 - [Specifications](#markdown-header-specifications)
 - [Attributes](#markdown-header-attributes)


## Main Functionalities
SnapPoints Loyalty program integration for your Magento Store

## Installation
\* = in production please use the `--keep-generated` option

### Type 1: Zip file

 - Unzip the zip file in `app/code/SnapPoints`
 - Enable the module by running `php bin/magento module:enable SnapPoints_Loyalty`
 - Apply database updates by running `php bin/magento setup:upgrade`\*
 - Flush the cache by running `php bin/magento cache:flush`

### Type 2: Composer

 - Make the module available in a composer repository for example:
    - private repository `repo.magento.com`
    - public repository `packagist.org`
    - public github repository as vcs
 - Add the composer repository to the configuration by running `composer config repositories.repo.magento.com composer https://repo.magento.com/`
 - Install the module composer by running `composer require snappoints/module-loyalty`
 - enable the module by running `php bin/magento module:enable SnapPoints_Loyalty`
 - apply database updates by running `php bin/magento setup:upgrade`\*
 - Flush the cache by running `php bin/magento cache:flush`


## Configuration

 - Enabled (general/general/enabled)


## Specifications

 - API Endpoint
	- GET - SnapPoints\Loyalty\Api\RatesManagementInterface > SnapPoints\Loyalty\Model\RatesManagement

 - API Endpoint
	- GET - SnapPoints\Loyalty\Api\RatesVersionManagementInterface > SnapPoints\Loyalty\Model\RatesVersionManagement

 - API Endpoint
	- GET - SnapPoints\Loyalty\Api\ProgramsManagementInterface > SnapPoints\Loyalty\Model\ProgramsManagement

 - API Endpoint
	- GET - SnapPoints\Loyalty\Api\ProgramsVersionManagementInterface > SnapPoints\Loyalty\Model\ProgramsVersionManagement

 - Block
	- Html\LibraryConfig > html/libraryconfig.phtml

 - Cache
	- SnapPoints - snappoints_cache_tag > SnapPoints\Loyalty\Model\Cache\SnapPoints

 - Console Command
	- import

 - Console Command
	- rates

 - Console Command
	- configurations

 - Crongroup
	- snappoints

 - Cronjob
	- snappoints_loyalty_updaterates

 - Cronjob
	- snappoints_loyalty_errorsretry

 - Helper
	- SnapPoints\Loyalty\Helper\Config

 - Model
	- program

 - Model
	- rates

 - Model
	- log

 - Model
	- queue_log

 - ViewModel
	- SnapPoints\Loyalty\ViewModel\Programs


## Attributes

 - Product - Snappoints Config (snappoints_config)

