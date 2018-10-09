<?php

namespace Dmatthew\Brand\Model\Brand\Source;

use Dmatthew\Brand\Model\ResourceModel\Brand\CollectionFactory;
use Magento\Framework\DB\Ddl\Table;

class Values extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{

    protected $optionFactory;

    protected $brandsCollectionFactory;

    public function __construct(
        CollectionFactory $brandsCollectionFactory
    ) {
        $this->brandsCollectionFactory = $brandsCollectionFactory;
    }

    public function getAllOptions()
    {

        $brands = $this->brandsCollectionFactory->create()
                                                ->addAttributeToSelect('*');

        $this->_options = array();

        $index = 1;
        foreach ($brands as $brand) {
            $brandOption = array(
                'label' => $brand->getName(),
                'value' => $index
            );
            array_push($this->_options, $brandOption);

            $index++;
        }

        return $this->_options;
    }

    public function getOptionText($value)
    {
        foreach ($this->getAllOptions() as $option) {
            if ($option['value'] == $value) {
                return $option['label'];
            }
        }

        return false;
    }

    public function getFlatColumns()
    {
        $attributeCode = $this->getAttribute()->getAttributeCode();

        return [
            $attributeCode => [
                'unsigned' => false,
                'default'  => null,
                'extra'    => null,
                'type'     => Table::TYPE_INTEGER,
                'nullable' => true,
                'comment'  => 'Custom Attribute Options  ' . $attributeCode . ' column',
            ],
        ];
    }
}