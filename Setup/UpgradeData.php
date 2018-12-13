<?php

namespace Dmatthew\Brand\Setup;

use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;
use Dmatthew\Brand\Setup\BrandSetupFactory;

class UpgradeData implements UpgradeDataInterface
{

    protected $eavSetupFactory;

    protected $brandSetupFactory;

    /**
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(
        EavSetupFactory $eavSetupFactory,
        BrandSetupFactory $brandSetupFactory
    )
    {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->brandSetupFactory = $brandSetupFactory;
    }

    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        /** @var EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
        $brandSetup = $this->brandSetupFactory->create(['setup' => $setup]);

        if (version_compare($context->getVersion(), '1.0.1', '<=')) {
            $eavSetup->addAttribute(
                \Magento\Catalog\Model\Product::ENTITY, 'brand', [
                    'type'                    => 'varchar',
                    'backend'                 => 'Magento\Eav\Model\Entity\Attribute\Backend\ArrayBackend',
                    'frontend'                => '',
                    'label'                   => 'Brand',
                    'input'                   => 'select',
                    'group'                   => 'General',
                    'class'                   => 'brand',
                    'source'                  => 'Dmatthew\Brand\Model\Brand\Source\Values',
                    'global'                  => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                    'visible'                 => true,
                    'required'                => false,
                    'user_defined'            => true,
                    'default'                 => '1',
                    'searchable'              => false,
                    'filterable'              => false,
                    'comparable'              => false,
                    'visible_on_front'        => false,
                    'used_in_product_listing' => true,
                    'unique'                  => false
                ]
            );

            if (version_compare($context->getVersion(), '1.2.0', '<=')) {
                $brandSetup->addAttribute(
                    \Dmatthew\Brand\Model\Brand::ENTITY,
                    'brand_image',
                    [
                        'type' => 'varchar',
                        'label' => 'Custom Image',
                        'input' => 'image',
                        'backend' => 'Dmatthew\Brand\Model\Brand\Attribute\Backend\Image',
                        'required' => false,
                        'sort_order' => 9,
                        'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                        'group' => 'General Information',
                    ]
                );
            }
        }

        $setup->endSetup();
    }
}