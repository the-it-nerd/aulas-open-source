<?php
/**
 * Copyright © MIT All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace TheITNerd\SizeGuide\Model\ResourceModel;



/**
 * Class SizeGuide
 * @package TheITNerd\SizeGuide\Model\ResourceModel
 */
class SizeGuide extends \Magento\Catalog\Model\ResourceModel\AbstractResource
{
    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->setType('theitnerd_sizeguide_entity');
    }


}

