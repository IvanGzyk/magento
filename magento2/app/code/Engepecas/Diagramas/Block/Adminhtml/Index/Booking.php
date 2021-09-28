<?php

namespace Engepecas\Diagramas\Block\Adminhtml\Index;

class Booking extends \Magento\Backend\Block\Template
{
    /**
     * Construct
     *
     * @param \Magento\Backend\Block\Template\Context  $context
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        array $data = []
    )
    {
        parent::__construct($context, $data);
       }

    /**
     * Get form action URL for POST booking request
     *
     * @return string
     */
    public function getFormAction()
    {
            // companymodule is given in routes.xml
            // controller_name is folder name inside controller folder
            // action is php file name inside above controller_name folder

        //$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        //$storeManager = $objectManager->create('\Magento\Store\Model\StoreManagerInterface');
        //$baseURL_l = $social_image_url = $storeManager->getStore()->getBaseUrl();

        //return $baseURL_l."diagramas/index/index";
        // here controller_name is index, action is booking
    }
}
