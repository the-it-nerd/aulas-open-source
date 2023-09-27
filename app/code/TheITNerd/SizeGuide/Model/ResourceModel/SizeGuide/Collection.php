<?php
/**
 * Copyright © MIT All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace TheITNerd\SizeGuide\Model\ResourceModel\SizeGuide;

class Collection extends \Magento\Eav\Model\Entity\Collection\AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \TheITNerd\SizeGuide\Model\SizeGuide::class,
            \TheITNerd\SizeGuide\Model\ResourceModel\SizeGuide::class
        );
    }
}

