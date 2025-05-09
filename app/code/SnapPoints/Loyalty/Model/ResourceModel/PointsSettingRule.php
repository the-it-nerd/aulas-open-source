<?php

namespace SnapPoints\Loyalty\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class PointsSettingRule  extends AbstractDb
{

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init('snappoints_loyalty_points_setting_rules', 'entity_id');
    }
}

