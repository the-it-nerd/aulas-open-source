<?php
/**
 * Copyright © MIT All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace TheITNerd\SizeGuide\Setup;

use Magento\Catalog\Model\ResourceModel\Eav\Attribute;
use Magento\Catalog\Model\ResourceModel\Product\Attribute\Collection;
use Magento\Eav\Setup\EavSetup;
use TheITNerd\SizeGuide\Model\ResourceModel\SizeGuide;

class SizeGuideSetup extends EavSetup
{

    public function getDefaultEntities()
    {
        return [
            \TheITNerd\SizeGuide\Model\SizeGuide::ENTITY => [
                'entity_model' => SizeGuide::class,
                'attribute_model' => Attribute::class,
                'table' => 'theitnerd_sizeguide_entity',
                'attributes' => [],
                "entity_attribute_collection" => "TheITNerd\SizeGuide\Model\ResourceModel\Attribute\Collection",
                "additional_attribute_table" => "catalog_eav_attribute",
            ]
        ];
    }
}

