<?php
/**
 * Copyright © SnapPoints Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace SnapPoints\Loyalty\Model\ResourceModel\Rates;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use SnapPoints\Loyalty\Model\ResourceModel\Rates;

class Collection extends AbstractCollection
{

    /**
     * @inheritDoc
     */
    protected $_idFieldName = 'rates_id';

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(
            \SnapPoints\Loyalty\Model\Rates::class,
            Rates::class
        );
    }
}

