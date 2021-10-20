# Mage2 Module Engepecas Pedidos

    ``engepecas/module-pedidos``

 - [Main Functionalities](#markdown-header-main-functionalities)
 - [Installation](#markdown-header-installation)
 - [Configuration](#markdown-header-configuration)
 - [Specifications](#markdown-header-specifications)
 - [Attributes](#markdown-header-attributes)


## Main Functionalities
teste de criacao

## Installation
\* = in production please use the `--keep-generated` option

### Type 1: Zip file

 - Unzip the zip file in `app/code/Engepecas`
 - Enable the module by running `php bin/magento module:enable Engepecas_Pedidos`
 - Apply database updates by running `php bin/magento setup:upgrade`\*
 - Flush the cache by running `php bin/magento cache:flush`

### Type 2: Composer

 - Make the module available in a composer repository for example:
    - private repository `repo.magento.com`
    - public repository `packagist.org`
    - public github repository as vcs
 - Add the composer repository to the configuration by running `composer config repositories.repo.magento.com composer https://repo.magento.com/`
 - Install the module composer by running `composer require engepecas/module-pedidos`
 - enable the module by running `php bin/magento module:enable Engepecas_Pedidos`
 - apply database updates by running `php bin/magento setup:upgrade`\*
 - Flush the cache by running `php bin/magento cache:flush`


## Configuration




## Specifications

 - API Endpoint
	- GET - Engepecas\Pedidos\Api\Update_pedidosManagementInterface > Engepecas\Pedidos\Model\Update_pedidosManagement

 - API Endpoint
	- GET - Engepecas\Pedidos\Api\Get_pedidosManagementInterface > Engepecas\Pedidos\Model\Get_pedidosManagement

 - API Endpoint
	- GET - Engepecas\Pedidos\Api\Insert_pedidosManagementInterface > Engepecas\Pedidos\Model\Insert_pedidosManagement


## Attributes



