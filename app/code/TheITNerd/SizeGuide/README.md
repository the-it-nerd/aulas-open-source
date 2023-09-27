# Mage2 Module TheITNerd SizeGuide

    ``theitnerd/module-sizeguide``

 - [Main Functionalities](#markdown-header-main-functionalities)
 - [Installation](#markdown-header-installation)
 - [Configuration](#markdown-header-configuration)
 - [Specifications](#markdown-header-specifications)
 - [Attributes](#markdown-header-attributes)


## Main Functionalities
Products size guide module

## Installation
\* = in production please use the `--keep-generated` option

### Type 1: Zip file

 - Unzip the zip file in `app/code/TheITNerd`
 - Enable the module by running `php bin/magento module:enable TheITNerd_SizeGuide`
 - Apply database updates by running `php bin/magento setup:upgrade`\*
 - Flush the cache by running `php bin/magento cache:flush`

### Type 2: Composer

 - Make the module available in a composer repository for example:
    - private repository `repo.magento.com`
    - public repository `packagist.org`
    - public github repository as vcs
 - Add the composer repository to the configuration by running `composer config repositories.repo.magento.com composer https://repo.magento.com/`
 - Install the module composer by running `composer require theitnerd/module-sizeguide`
 - enable the module by running `php bin/magento module:enable TheITNerd_SizeGuide`
 - apply database updates by running `php bin/magento setup:upgrade`\*
 - Flush the cache by running `php bin/magento cache:flush`


## Configuration




## Specifications

 - Eav Entity
	- SizeGuide

 - Helper
	- TheITNerd\SizeGuide\Helper\Config


## Attributes

 - Product - Size Guide (size_guide)

