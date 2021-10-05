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
}
