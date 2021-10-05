<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Engepecas\Diagramas\Block\Adminhtml\Index;


class Index extends \Magento\Backend\Block\Template
{

    protected $request;
    /**
     * Constructor
     *
     * @param \Magento\Backend\Block\Template\Context  $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Backend\Block\Template\Context $context,
        array $data = []
    ) {
        $this->request = $request;
        parent::__construct($context, $data);
    }

    /**
     *
     *Recupera html de geração dos diagramas
     *
     **/
    public function getDiagramas()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection('\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION');
        $table = $connection->getTableName('magento.catalog_product_entity_text');
        $sql = "SELECT * FROM ".$table." where attribute_id = 75;";
        return $connection->fetchAll($sql);
    }

    /**
     *
     *tras id e nome dos produtos que pertencem a categoria diagramas
     *
     **/
    public function getIdMotorDiagrama(){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection('\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION');

        $sql = "SELECT entity_id FROM catalog_category_entity_varchar WHERE VALUE = 'diagramas' LIMIT 1";
        $resultado = $connection->fetchAll($sql);
        $cat_id = $resultado[0]['entity_id'];
        return $this->getProdutoId($cat_id);
    }

    /**
     *
     *Tras os ids e categorias de produtos da categoria atraves do is da categoria
     *
     **/
    public function getProdutoId($id = NULL){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection('\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION');

        $sql = "SELECT entity_id, VALUE FROM catalog_product_entity_text WHERE entity_id IN (
            SELECT product_id FROM catalog_category_product WHERE category_id = $id
        ) AND attribute_id = 85;";
        $resultado = $connection->fetchAll($sql);
        return $resultado;
    }
}
