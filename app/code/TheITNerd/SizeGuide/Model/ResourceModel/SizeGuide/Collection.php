<?php
/**
 * Copyright © MIT All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace TheITNerd\SizeGuide\Model\ResourceModel\SizeGuide;

use Magento\Eav\Model\Config;
use Magento\Eav\Model\Entity\Collection\AbstractCollection;
use Magento\Eav\Model\EntityFactory;
use Magento\Eav\Model\ResourceModel\Helper;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Select;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Validator\UniversalFactory;
use Magento\Store\Api\Data\StoreInterface;
use Magento\Store\Model\Store;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;
use TheITNerd\SizeGuide\Model\ResourceModel\SizeGuide as SizeGuideResourceModel;
use TheITNerd\SizeGuide\Model\SizeGuide as SizeGuideModel;


/**
 * Class Collection
 * @package TheITNerd\SizeGuide\Model\ResourceModel\SizeGuide
 */
class Collection extends \Magento\Catalog\Model\ResourceModel\Collection\AbstractCollection
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

