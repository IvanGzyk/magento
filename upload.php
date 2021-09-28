<?php
require_once 'conexao/conexao.php';
$db = new Conexao();
/*$query = "SELECT  * FROM `magento`.`catalog_product_entity_text` LIMIT 1000;";
print_r($_POST); exit();
foreach ($db->con->query($query) as $row) {
    echo '<pre>';
    print_r($row);
    echo '</pre>';
}*/
$id = $_POST['id_prod'];
$html = $_POST['html'];
$data = [
    'at_id' => 75,
    'st_id' => 0,
    'tn_id' => $id,
    'html' => $html,
];

$sql = "INSERT INTO magento.catalog_product_entity_text (
        attribute_id, 
        store_id, 
        entity_id, 
    value
    ) VALUES (
        :at_id,
        :st_id,
        :tn_id,
        :html
    )";
    $db->con->prepare($sql)->execute($data);

if(isset($_FILES['myPhoto']['name'])){
    $img = $_FILES['myPhoto']['name'];
    $img_tmp = $_FILES['myPhoto']['tmp_name'];
    echo $img_tmp;
    copy($img_tmp,"/var/www/html/magento2/pub/media/img/$img");
}

if (isset($_POST['html'])){
    print_r($_POST);
    //echo $_POST['html'];
}