<?php
/**
 * Copyright © SnapPoints Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace SnapPoints\Loyalty\Model\ResourceModel\QueueLog;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use SnapPoints\Loyalty\Model\ResourceModel\QueueLog;

class Collection extends AbstractCollection
{

    /**
     * @inheritDoc
     */
    protected $_idFieldName = 'queue_log_id';

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(
            \SnapPoints\Loyalty\Model\QueueLog::class,
            QueueLog::class
        );
    }
}

