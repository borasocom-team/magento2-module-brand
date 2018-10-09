<?php

namespace Dmatthew\Brand\Controller\Adminhtml\Brand;

use Dmatthew\Brand\Api\BrandRepositoryInterface;
use Dmatthew\Brand\Controller\Adminhtml\Brand;

class Save extends Brand{

    protected $backendSession;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        Brand\Builder $brandBuilder,
        BrandRepositoryInterface $brandRepository,
        \Dmatthew\Brand\Model\BrandFactory $brandFactory,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->_backendSession = $context->getSession();

        parent::__construct($context, $brandBuilder, $brandRepository, $brandFactory, $resultJsonFactory, $resultPageFactory);
    }

    /**
     * run the action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $data = $this->getRequest()->getPost('brand');
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            $brand = $this->brandBuilder->build($this->getRequest());

            foreach ($data as $name => $datum){
                $brand->setData($name, $datum);
            }

            $this->_eventManager->dispatch(
                'dmatthew_brand_brand_prepare_save',
                [
                    'brand' => $brand,
                    'request' => $this->getRequest()
                ]
            );
            try {
                $brand->save();

                if ($this->getRequest()->getParam('back')) {
                    $resultRedirect->setPath(
                        'brand/*/edit',
                        [
                            'brand_id' => $brand->getId(),
                            '_current' => true
                        ]
                    );
                    return $resultRedirect;
                }
                $resultRedirect->setPath('brand/*/');
                return $resultRedirect;
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the brand.'));
            }
            $resultRedirect->setPath(
                'brand/*/edit',
                [
                    'brand_id' => $brand->getId(),
                    '_current' => true
                ]
            );
            return $resultRedirect;
        }
        $resultRedirect->setPath('brand/*/');
        return $resultRedirect;
    }

    /**
     * filter values
     *
     * @param array $data
     * @return array
     */
    protected function _filterData($data)
    {

        return $data;
    }

}