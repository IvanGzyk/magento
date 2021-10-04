<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Engepecas\Diagramas\Controller\Adminhtml\Index;

class Index extends \Magento\Backend\App\Action
{

    protected $resultPageFactory;
    public $teste;

    /**
     * Constructor
     *
     * @param \Magento\Backend\App\Action\Context  $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {

        if(isset($_POST['teste']) && !empty($_POST['teste'])){
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $storeManager = $objectManager->create('\Magento\Store\Model\StoreManagerInterface');
            $baseURL_l = $social_image_url = $storeManager->getStore()->getBaseUrl();
            $caminho = $baseURL_l.'pub/media/catalog/product';
            $result_peca = $this->getIdPeca($_POST['teste']);
            echo $caminho.$this->getImagem($result_peca[0]['entity_id']);
            exit();
        }
        if (isset($_POST['html'])){
            $this->salve_form();
        }
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     *
     * Salva form no banco de dados
     *
     */
    public function salve_form(){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection('\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION');
        $id = $_POST['id_prod'];
        $html = $_POST['html'];
        $table = $connection->getTableName('magento.catalog_product_entity_text');
        $aspa = "\'";
        //echo $aspa; exit();
        $html = str_replace("'", $aspa, $html);
        $sql = "INSERT INTO ".$table." (attribute_id,store_id,entity_id,value) VALUES (75,0,$id,'$html')";
        return $connection->query($sql);
    }

    /**
     *
     * Pega url da peca
     *
     */
    public function getIdPeca($url = NULL){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection('\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION');

        $sql = "SELECT entity_id FROM url_rewrite
        WHERE request_path = '$url'";

        return $connection->fetchAll($sql);
    }


    /**
     *
     * Pega url da imgem
     *
     */
    public function getImagem($id = NULL)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection('\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION');

        $sql = "SELECT g.value from catalog_product_entity_media_gallery g
        INNER JOIN catalog_product_entity_media_gallery_value c USING(value_id)
        WHERE c.entity_id LIKE '$id'
        LIMIT 1";

        $returno = $connection->fetchAll($sql);
        return $returno[0]['value'];
    }

    /**
     * Execute view action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */

    public function execute()
    {
        $this->teste = 'teste funcionou';
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Diagramas'));

        return $resultPage;
    }
}
