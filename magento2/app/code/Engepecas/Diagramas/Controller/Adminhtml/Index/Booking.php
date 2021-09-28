<?php

namespace Engepecas\Diagramas\Controller\Adminhtml\Index;

use Magento\Framework\Controller\ResultFactory;

class Booking extends \Magento\Framework\App\Action\Action
{
    /**
     * Booking action
     *
     * @return void
     */


    public function getPost()
    {
        return $this->request->getPostValue();
    }

    public function getFiles()
    {
        return $this->request->getFilestValue();
    }

    public function execute()
    {
        // 1. POST request : Get booking data
        $post = (array) $this->getRequest()->getPost();

        if (!empty($post)) {

            // Display the succes form validation message
            $this->messageManager->addSuccessMessage('Booking done !');

            // Redirect to your form page (or anywhere you want...)
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            $resultRedirect->setUrl('/diagramas/index/booking');

            return $resultRedirect;
        }
        // 2. GET request : Render the booking page
        $this->_view->loadLayout();
        $this->_view->renderLayout();
    }
}
