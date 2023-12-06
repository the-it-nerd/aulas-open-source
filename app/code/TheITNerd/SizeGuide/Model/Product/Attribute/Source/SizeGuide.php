<?php
/**
 * Copyright © MIT All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace TheITNerd\SizeGuide\Model\Product\Attribute\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use Magento\Framework\Exception\LocalizedException;
use TheITNerd\SizeGuide\Model\ResourceModel\SizeGuide\CollectionFactory;

/**
 * Class SizeGuide
 * @package TheITNerd\SizeGuide\Model\Product\Attribute\Source
 */
class SizeGuide extends AbstractSource
{

    /**
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        private readonly CollectionFactory $collectionFactory
    )
    {
    }

    /**
     * @return array|array[]|null
     * @throws LocalizedException
     */
    public function getAllOptions()
    {
        $this->_options = [
            ["label" => __("--- None ---"), "value" => ""]
        ];

        $collection = $this->collectionFactory->create()
            ->addAttributeToSelect('*');

        foreach ($collection as $item) {
            $this->_options[] = ["label" => "{$item->getName()} ({$item->getId()})", "value" => $item->getId()];
        }

        return $this->_options;
    }
}

