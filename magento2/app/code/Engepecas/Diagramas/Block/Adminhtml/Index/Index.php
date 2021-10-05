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

    public function getDiagramas()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection('\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION');
        $table = $connection->getTableName('magento.catalog_product_entity_text');
        $sql = "SELECT * FROM ".$table." where attribute_id = 75;";
        return $connection->fetchAll($sql);
    }

    /*public function getImagem($id = NULL)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection('\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION');

        $sql = "SELECT g.* from catalog_product_entity_media_gallery g
        INNER JOIN catalog_product_entity_media_gallery_value c USING(value_id)
        WHERE c.entity_id LIKE '$id'
        LIMIT 1";

        return $connection->fetchAll($sql);
    }

    public function getIdPeca($url = NULL){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection('\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION');

        $sql = "SELECT entity_id FROM url_rewrite
        WHERE request_path = '$url'";

        return $connection->fetchAll($sql);
    }*/
}
