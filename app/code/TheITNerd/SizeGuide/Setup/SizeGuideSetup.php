<?php
/**
 * Copyright © MIT All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace TheITNerd\SizeGuide\Setup;

use Magento\Eav\Setup\EavSetup;

class SizeGuideSetup extends EavSetup
{

    public function getDefaultEntities()
    {
        return [
             \TheITNerd\SizeGuide\Model\SizeGuide::ENTITY => [
                'entity_model' => \TheITNerd\SizeGuide\Model\ResourceModel\SizeGuide::class,
                'table' => 'theitnerd_sizeguide_entity',
                'attributes' => []
            ]
        ];
    }
}

