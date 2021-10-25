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
        if(isset($_FILES['myPhoto']['name'])){
            $this->salvaImg();
            exit();
        }

        if(isset($_POST['deletar']) && !empty($_POST['deletar'])){

            $this->deletarProd($_POST['id']);
            $resultado = $this->getDiagramas($_POST['entity_id_motor']);
            $resultado = json_encode($resultado);
            echo $resultado;
            exit();
        }

        if(isset($_POST['sku']) && !empty($_POST['sku'])){
            $resultado = $this->getNome_Url($_POST['sku']);
            $motor_enity_id = $_POST['entity_id_motor'];
            $enity_id = $resultado[0]['entity_id'];
            $sku = $resultado[0]['sku'];
            $value = $resultado[0]['value'];
            $request_path = $resultado[0]['request_path'];
            $price = $resultado[0]['price'];
            $left = $_POST['left'];
            $top = $_POST['top'];
            $left_b = $_POST['left_b'];
            $top_b = $_POST['top_b'];
            $mt_img = $_POST['mt_img'];

            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $storeManager = $objectManager->create('\Magento\Store\Model\StoreManagerInterface');
            $baseURL_l = $social_image_url = $storeManager->getStore()->getBaseUrl();
            $caminho = $baseURL_l.'pub/media/catalog/product';
            $caminho_img = $caminho.$this->getImagem($enity_id);/** Recebe a url da imagem */

            $resultado = $this->setDiagrama($motor_enity_id, $sku, $enity_id, $value, $request_path, $price, $left, $top, $left_b, $top_b, $caminho_img, $mt_img);

            $diagrama = $this->getDiagramas($motor_enity_id);
            $retorno = json_encode($diagrama);
            echo $retorno;
            exit();
        }

        if(isset($_POST['entity_id_motor']) && !empty($_POST['entity_id_motor'])){
            $resultado = $this->getDiagramas($_POST['entity_id_motor']);
            $resultado = json_encode($resultado);
            echo $resultado;
            exit();
        }

        if(isset($_POST['teste']) && !empty($_POST['teste'])){
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $storeManager = $objectManager->create('\Magento\Store\Model\StoreManagerInterface');
            $baseURL_l = $social_image_url = $storeManager->getStore()->getBaseUrl();
            $caminho = $baseURL_l.'pub/media/catalog/product';
            $result_peca = $this->getIdPeca($_POST['teste']);/** Recupera o id da peça */
            echo $caminho.$this->getImagem($result_peca[0]['entity_id']);/** Recebe a url da imagem */
            exit();
        }

        if (isset($_POST['id_motor']) && !empty($_POST['id_motor'])){

            $resultado = $this->getDiagramas($_POST['id_motor']);

            $html = $this->getHtml($resultado, $_POST['file_url']);
            $_POST['html'] = $html;

            $this->salve_form();
            exit();
        }
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    public function getHtml($array, $file){
        $popup = '';
        $texto_map = '';
        $lista_produtos = '';
        $titulo_botao = 1;
        $script = '';
        foreach($array as $value){
            setlocale(LC_MONETARY, 'en_US');
            $price = floatval($value['price']);
            $value['price'] = number_format($price,2,",",".");
            $lista_produtos .= '
                    <tr class="'.$value['sku'].'">
                        <td><a class="btn_img" alt="'.$value['value'].'" title="'.$value['value'].'" href="#table" >'.$titulo_botao.'</a></td>
                        <td><img src="'.$value['imagem'].'" style="width: 5em"></td>
                        <td>'.$value['value'].'</td>
                        <td>'.$value['sku'].'</td>
                        <td>R$ '.$value['price'].'</td>
                        <td><a href="'.$value['request_path'].'" class="action primary">Comprar</a></td>
                    </tr>';

            $texto_map .=  '
            <a class="btn_img" id="'.$value['sku'].'_" alt="'.$value['value'].'" title="'.$value['value'].'" href="#imagem" style="left:'.$value['left'].'%; top:'.$value['top'].'%;">'.$titulo_botao.'</a>';

            $popup .= '
            <div data-bind="mageInit: {';
            $popup .= "
                'Magento_Ui/js/modal/modal':{
                    'type': 'popup',
                    'title': '".$value['value']."',
                    'content': '[id=".$value['sku']."]',
                    'trigger': '[alt=".$value['value']."]',
                    'responsive': true,
                    'modalClass': 'modal',
                    'buttons': [{
                        text: jQuery.mage.__('Fechar'),
                        class: 'btn btn-primary'
                    }, {
                        text: jQuery.mage.__('Comprar'),
                        class: 'btn btn-primary',
                        click: function (event){
                               window.open('".$value['request_path']."', '_blank');
                        }
                    }]
                }
            }".
            '">';
            $popup .= "
                <div id='".$value['sku']."' style='width: 100%; display: inline;'>
                    <div style='width: 50%; display: inline;'>
                        <a href='".$value['request_path']."'><img src='".$value['imagem']."' style='width: 100px'></a>
                    </div>
                    <div style='width: 50%; display: inline;'>
                        <h3>".$value['sku']."</h3>
                        <p>R$ ".$value['price']."</p>
                    </div>
                </div>
            </div>";

            $script .= '
                let '.$value['value'].' = document.querySelector(".'.$value['sku'].'");
                let btn_'.$value['sku'].' = document.querySelector("#'.$value['sku'].'_");
                '.$value['value'].'.addEventListener("mouseover", function(e) {
                    '.$value['value'].'.style.backgroundColor = "#FAB600";
                    btn_'.$value['sku'].'.style.fontSize = "2em";
                });
                '.$value['value'].'.addEventListener("mouseout", function(e) {
                    '.$value['value'].'.style.backgroundColor = "#FFF";
                    btn_'.$value['sku'].'.style.fontSize = "1em";
                });
            ';
            $titulo_botao++;
        }
        return '
        <style>
        .btn_img{
            position:absolute;
            text-align: center;
            background:#FAB600;
            width:2em;
            height:2em;
            border-radius: 100%;
            border: 1px #000 solid;
            font-size: 1em;
            font-weight: bold;
            color: #000 !important;
        }
        /*.btn_img:before{
            display:block;
        }*/
        #imagem {
            position: relative;
            display: flex;
            width: 60%;
            margin-left: 20%;
        }

        #tb_prod{
            position: relative;
            display: flex;
            text-align: center;
            width: 100%;
            margin-top: 5%;
        }

        table{
            width: 100%;
        }

        th, td {
            border-bottom: 1px solid #ddd;tr:
            hover {background-color: #FAB600;}
        }

        th {
            background-color: #000;
            color: white;
        }

        #view_img{
            width: 100%;
            height: auto;
        }
        .value{
            display: block !important;
        }
        .modal{
            display: block !important;
            text-align: center;
        }
        .modal-popup .modal-inner-wrap {
            text-align: center;
        }
        </style>
        <div id="imagem">
            <img id="view_img" src="'.$file.'">
        '.$texto_map.'
        </div>
        <div id="tb_prod">
            <table>
                <tr>
                    <th>PÇ</th>
                    <th>IMG</th>
                    <th>Nome</th>
                    <th>SKU</th>
                    <th>Preço</th>
                    <th></th>
                </tr>
                '.$lista_produtos.'
            </table>
        </div>'.
        $popup.'
        <script>'.
        $script.'
        </script>';
    }

    public function salvaImg()
    {
        $img = $_FILES['myPhoto']['name'];
        $img_tmp = $_FILES['myPhoto']['tmp_name'];
        copy($img_tmp,"/var/www/html/magento2/pub/media/img/$img");
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $storeManager = $objectManager->create('\Magento\Store\Model\StoreManagerInterface');
        $baseURL_l = $social_image_url = $storeManager->getStore()->getBaseUrl();
        $caminho = $baseURL_l."pub/media/img/$img";
        echo $caminho;
    }

    public function getNome_Url($sku = NULL){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection('\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION');

        $sql = "SELECT a.entity_id, a.sku, b.value, c.request_path, d.price FROM catalog_product_entity a
        JOIN catalog_product_entity_varchar b USING(entity_id)
        JOIN url_rewrite c USING(entity_id)
        JOIN catalog_product_index_price d USING(entity_id)
        WHERE a.sku = '$sku'
        AND attribute_id = 73
        AND a.entity_id = b.entity_id
        AND c.entity_type = 'product'
        ORDER BY c.entity_type
        LIMIT 1;";

        return $connection->fetchAll($sql);
    }

    /**Busca produtos cadastrados no diagrama */

    public function getDiagramas($id = NULL){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection('\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION');

        $sql = "SELECT * FROM engepecas_diagramas_temp where motor_enity_id = $id";

        return $connection->fetchAll($sql);
    }

    /**Salva Diagrama table = 'engepecas_diagramas_temp' */

    public function setDiagrama($motor_enity_id, $sku, $enity_id, $value, $request_path, $price, $left, $top, $left_b, $top_b, $caminho_img, $mt_img){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection('\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION');
        $sql = "SELECT diagrama_id, COUNT(*) total FROM engepecas_diagramas_temp WHERE motor_enity_id = $motor_enity_id and enity_id = $enity_id";

        $result = $connection->fetchAll($sql);
        if($result[0]['total'] == 0)
        {
            try
            {
                $sql = "INSERT INTO engepecas_diagramas_temp
                (
                    motor_enity_id,
                    sku,
                    enity_id,
                    `value`,
                    request_path,
                    price,
                    `left`,
                    `top`,
                    `left_b`,
                    `top_b`,
                    `imagem`,
                    `mt_img`
                ) VALUES
                (
                    $motor_enity_id,
                    '$sku',
                    $enity_id,
                    '$value',
                    '$request_path',
                    $price,
                    '$left',
                    '$top',
                    '$left_b',
                    '$top_b',
                    '$caminho_img',
                    '$mt_img'
                )";
                return $connection->query($sql);
            } catch (Exception $e)
            {
                $url = $this->getUrl('diagramas/index/index', ['_secure'=> true]);
                header('Location: '.$url);
            }
        } else
        {
            try{
                $sql = "UPDATE engepecas_diagramas_temp SET
                motor_enity_id = $motor_enity_id,
                sku = '$sku',
                enity_id = $enity_id,
                `value` = '$value',
                request_path = '$request_path',
                price = $price,
                `left` = '$left',
                `top` = '$top',
                `left_b` = '$left_b',
                `top_b` = '$top_b',
                `imagem` = '$caminho_img',
                `mt_img` = '$mt_img'
                WHERE diagrama_id = ".$result[0]['diagrama_id'];
                //echo $sql; exit();
                return $connection->query($sql);
            } catch (Exception $e)
            {
                $url = $this->getUrl('diagramas/index/index', ['_secure'=> true]);
                header('Location: '.$url);
            }
        }
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
        $id = $_POST['id_motor'];
        $html = $_POST['html'];
        $table = $connection->getTableName('magento.catalog_product_entity_text');
        $aspa = "\'";
        $html = str_replace("'", $aspa, $html);
        $sql = "SELECT value_id, COUNT(*) total FROM catalog_product_entity_text WHERE entity_id = $id AND attribute_id = 75";
        $result = $connection->fetchAll($sql);
        if($result[0]['total'] == 0)
        {
            try
            {
                $sql = "INSERT INTO ".$table." (attribute_id,store_id,entity_id,value) VALUES (75,0,$id,'$html')";
                return $connection->query($sql);
            } catch (Exception $e)
            {
                echo "<script>alert('Erro ao tentar cadastrar!');</script>";
                $url = $this->getUrl('diagramas/index/index', ['_secure'=> true]);
                header('Location: '.$url);
            }
        } else
        {
            try{
                $sql = "UPDATE ".$table." SET entity_id = $id, value = '$html' WHERE value_id = ".$result[0]['value_id'];
                return $connection->query($sql);
            } catch (Exception $e)
            {
                echo "<script>alert('Erro ao tentar atualizar!');</script>";
                $url = $this->getUrl('diagramas/index/index', ['_secure'=> true]);
                header('Location: '.$url);
            }
        }
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

    public function deletarProd($id){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection('\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION');

        $sql = "DELETE FROM `magento`.`engepecas_diagramas_temp` WHERE  `diagrama_id`=$id;";
        return $connection->query($sql);
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
