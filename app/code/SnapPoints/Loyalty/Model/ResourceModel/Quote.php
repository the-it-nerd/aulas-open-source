<?php
/**
 * Copyright © SnapPoints Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace SnapPoints\Loyalty\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Quote extends AbstractDb
{

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init('snappoints_loyalty_quote', 'entity_id');
    }
}

