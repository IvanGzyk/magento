<?php
namespace Engepecas\Diagramas\Controller\Adminhtml\Upload;

class Upload extends \Magento\Backend\App\Action
{
    public function __construct()
    {
        if(isset($_FILES['myPhoto']['name'])){
            $this->salva();
        }
    }

    public function salva(){$img = $_FILES['myPhoto']['name'];
        $img_tmp = $_FILES['myPhoto']['tmp_name'];
        copy($img_tmp,"/var/www/html/magento2/pub/media/img/$img");
        ?>
        <script>
        alert('Imagem salva com sucesso!');
        </script>
        <?php
    }

    public function execute()
    {
        return null;
    }
}
