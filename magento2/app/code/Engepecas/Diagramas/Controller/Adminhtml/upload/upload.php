<?php
if(isset($_FILES['myPhoto']['name'])){
    $img = $_FILES['myPhoto']['name'];
    $img_tmp = $_FILES['myPhoto']['tmp_name'];
    echo $img_tmp;
    copy($img_tmp,"/var/www/html/magento2/pub/media/img/$img");
}
