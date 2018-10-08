<?php

namespace Dmatthew\Brand\Controller\Adminhtml\Brand;

use Dmatthew\Brand\Api\BrandRepositoryInterface;
use Dmatthew\Brand\Controller\Adminhtml\Brand;
use Magento\Backend\Model\View\Result\ForwardFactory;

class NewAction extends Brand
{

    protected $resultForwardFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        Brand\Builder $brandBuilder,
        BrandRepositoryInterface $brandRepository,
        \Dmatthew\Brand\Model\BrandFactory $brandFactory,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        ForwardFactory $resultForwardFactory
    ) {
        $this->resultForwardFactory = $resultForwardFactory;

        parent::__construct($context, $brandBuilder, $brandRepository, $brandFactory, $resultJsonFactory, $resultPageFactory);
    }

    /**
     * forward to edit
     *
     * @return \Magento\Backend\Model\View\Result\Forward
     */
    public function execute()
    {
        $resultForward = $this->resultForwardFactory->create();
        $resultForward->forward('edit');

        return $resultForward;
    }
}