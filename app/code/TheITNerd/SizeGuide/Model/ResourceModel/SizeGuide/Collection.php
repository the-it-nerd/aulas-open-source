<?php
/**
 * Copyright © MIT All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace TheITNerd\SizeGuide\Model\ResourceModel\SizeGuide;

use Magento\Catalog\Model\ResourceModel\Collection\AbstractCollection;
use TheITNerd\SizeGuide\Model\ResourceModel\SizeGuide as SizeGuideResourceModel;
use TheITNerd\SizeGuide\Model\SizeGuide as SizeGuideModel;


/**
 * Class Collection
 * @package TheITNerd\SizeGuide\Model\ResourceModel\SizeGuide
 */
class Collection extends AbstractCollection
{
    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            SizeGuideModel::class,
            SizeGuideResourceModel::class
        );
    }
}

