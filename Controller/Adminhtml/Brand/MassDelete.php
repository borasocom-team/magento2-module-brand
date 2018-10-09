<?php

namespace Dmatthew\Brand\Controller\Adminhtml\Brand;

use Dmatthew\Brand\Api\BrandRepositoryInterface;
use Dmatthew\Brand\Controller\Adminhtml\Brand;

class MassDelete extends Brand
{

    /**
     * Mass Action Filter
     *
     * @var \Magento\Ui\Component\MassAction\Filter
     */
    protected $filter;

    /**
     * @var \Dmatthew\Brand\Model\ResourceModel\Brand\CollectionFactory
     */
    protected $collectionFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        Brand\Builder $brandBuilder,
        BrandRepositoryInterface $brandRepository,
        \Dmatthew\Brand\Model\BrandFactory $brandFactory,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Ui\Component\MassAction\Filter $filter,
        \Dmatthew\Brand\Model\ResourceModel\Brand\CollectionFactory $collectionFactory
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;

        parent::__construct($context, $brandBuilder, $brandRepository, $brandFactory, $resultJsonFactory, $resultPageFactory);
    }

    /**
     * execute action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());

        $delete = 0;
        /** @var \Dmatthew\Brand\Model\Brand $brand */
        foreach ($collection as $brand) {
            $brand->delete();
            $delete++;
        }
        $this->messageManager->addSuccess(__('A total of %1 record(s) have been deleted.', $delete));
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);

        return $resultRedirect->setPath('*/*/');
    }
}