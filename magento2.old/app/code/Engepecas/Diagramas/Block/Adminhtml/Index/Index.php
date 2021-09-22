<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Engepecas\Diagramas\Block\Adminhtml\Index;


class Index extends \Magento\Backend\Block\Template
{

    protected $request;
    /**
     * Constructor
     *
     * @param \Magento\Backend\Block\Template\Context  $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Backend\Block\Template\Context $context,
        array $data = []
    ) {
        $this->request = $request;
        parent::__construct($context, $data);
    }

    public function getPost()
    {
        return $this->request->getPostValue();
    }

    public function getFiles()
    {
        return $this->request->getFilestValue();
    }

    /**
     * @return string
     */
    public function index()
    {
        //Your block code
        //return __('Hello Developer! This how to get the storename: %1 and this is the way to build a url: %2', $this->_storeManager->getStore()->getName(), $this->getUrl('contacts'));
    }
}
