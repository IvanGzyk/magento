<?php

namespace Engepecas\Diagramas\Controller\Adminhtml\Action;

use Magento\Framework\Json\Helper\Data as JsonHelper;

class AddAttachment extends \Magento\Backend\App\Action {

    protected $_mediaDirectory;
    protected $_fileUploaderFactory;
    public $_storeManager;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        JsonHelper $jsonHelper,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        parent::__construct($context);
        $this->jsonHelper = $jsonHelper;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->_mediaDirectory = $filesystem->getDirectoryWrite(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
        $this->_fileUploaderFactory = $fileUploaderFactory;
        $this->_storeManager = $storeManager;
    }


    public function execute(){

        $_postData = $this->getRequest()->getPost();

        $message = "";
        $newFileName = "";
        $error = false;
        $data = array();

        try{
            $target = $this->_mediaDirectory->getAbsolutePath('leads/');

   //attachment is the input file name posted from your form
            $uploader = $this->_fileUploaderFactory->create(['fileId' => 'attachment']);

            //$_fileType = $uploader->getFileExtension();
            $newFileName = uniqid().'.'.$_fileType;

            /** Allowed extension types */
            $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'csv']);
            /** rename file name if already exists */
            $uploader->setAllowRenameFiles(true);

            $result = $uploader->save($target, $newFileName); //Use this if you want to change your file name
   //$result = $uploader->save($target);
            if ($result['file']) {

                $_mediaUrl = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
                $_iconArray = array(
                    'pdf' => $_mediaUrl.'leads/default/icon-pdf.png',
                    'doc' => $_mediaUrl.'leads/default/icon-doc.png',
                    'docx' => $_mediaUrl.'leads/default/icon-docx.png',
                    'xls' => $_mediaUrl.'leads/default/icon-xls.png',
                    'xlsx' => $_mediaUrl.'leads/default/icon-xlsx.png',
                    'csv' => $_mediaUrl.'leads/default/icon-csv.png',
                );

                if(isset($_iconArray[$_fileType])){
                    $_src = $_iconArray[$_fileType];
                }else{
                    $_src = $_mediaUrl.'leads/'.$newFileName;
                }

                $error = false;
                $message = "File has been successfully uploaded";

                $html = '<div class="image item base-image" data-role="image" id="'. uniqid().'">
                            <div class="product-image-wrapper">
                                <img class="product-image" data-role="image-element" src="'.$_src.'" alt="">
                                <div class="actions">
                                    <button type="button" class="action-remove" data-role="delete-button" data-image="'.$newFileName.'" title="Delete image"><span>Delete image</span></button>
                                </div>
                                <div class="image-fade"><span>Hidden</span></div>
                            </div>
                            <div class="item-description">
                                <div class="item-title" data-role="img-title"></div>
                                <div class="item-size">
                                    <a href="'.$_mediaUrl.'leads/'.$newFileName.'" target="_blank"><span data-role="image-dimens">'.$newFileName.'</span></a>
                                </div>
                            </div>
                        </div>';

                $data = array('filename' => $newFileName, 'path' => $_mediaUrl.'leads/'.$newFileName, 'fileType' => $_fileType, 'html' => $html);
            }
        } catch (\Exception $e) {
            $error = true;
            $message = $e->getMessage();
        }

        $resultJson = $this->resultJsonFactory->create();

        return $resultJson->setData([
                    'message' => $message,
                    'data' => $data,
                    'error' => $error
        ]);
    }
}
