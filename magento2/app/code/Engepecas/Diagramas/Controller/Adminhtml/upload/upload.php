<?php
namespace Engepecas\Diagramas\Controller\Adminhtml\Upload;

class Upload extends \Magento\Backend\App\Action
{
    public function __construct()
    {
        if(isset($_POST['html'])){
            print_r($_POST);
            exit();
        }
    }

    public function execute()
    {

    }
}

