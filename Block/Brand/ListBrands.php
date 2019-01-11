<?php

namespace Dmatthew\Brand\Block\Brand;

use Dmatthew\Brand\Model\ResourceModel\Brand\CollectionFactory;
use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Block\Product\ListProduct;

class ListBrands extends ListProduct
{

    protected $brandsCollectionFactory;

    protected $productCollectionFactory;

    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Framework\Data\Helper\PostHelper $postDataHelper,
        \Magento\Catalog\Model\Layer\Resolver $layerResolver,
        CategoryRepositoryInterface $categoryRepository,
        \Magento\Framework\Url\Helper\Data $urlHelper,
        CollectionFactory $brandsCollectionFactory,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        array $data = []
    ) {
        $this->brandsCollectionFactory  = $brandsCollectionFactory;
        $this->productCollectionFactory = $productCollectionFactory;

        parent::__construct($context, $postDataHelper, $layerResolver, $categoryRepository, $urlHelper, $data);
    }

    protected function _getProductCollection()
    {
        if ($this->_productCollection === null) {

            $this->_productCollection = $this->productCollectionFactory->create()
                                                                       ->addAttributeToSelect('*');
        }

        return $this->_productCollection;
    }
}