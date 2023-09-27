<?php
/**
 * Copyright © MIT All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace TheITNerd\SizeGuide\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use TheITNerd\SizeGuide\Setup\SizeGuideSetup;
use TheITNerd\SizeGuide\Setup\SizeGuideSetupFactory;

class DefaultSizeGuideEntity implements DataPatchInterface
{

    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;
    /**
     * @var SizeGuideSetup
     */
    private $sizeGuideSetupFactory;

    /**
     * Constructor
     *
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param SizeGuideSetupFactory $sizeGuideSetupFactory
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        SizeGuideSetupFactory $sizeGuideSetupFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->sizeGuideSetupFactory = $sizeGuideSetupFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();
        /** @var SizeGuideSetup $customerSetup */
        $sizeGuideSetup = $this->sizeGuideSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $sizeGuideSetup->installEntities();
        

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [
        
        ];
    }
}

