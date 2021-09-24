<?php
require_once 'conexao/conexao.php';
$db = new Conexao();
$query = "SELECT  * FROM `magento`.`catalog_product_entity_text` LIMIT 1000;";
foreach ($db->con->query($query) as $row) {
    echo '<pre>';
    print_r($row);
    echo '</pre>';
}

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