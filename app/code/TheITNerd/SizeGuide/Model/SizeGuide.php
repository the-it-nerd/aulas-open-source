<?php
/**
 * Copyright © MIT All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace TheITNerd\SizeGuide\Model;

use Magento\Framework\Api\DataObjectHelper;
use TheITNerd\SizeGuide\Api\Data\SizeGuideInterface;
use TheITNerd\SizeGuide\Api\Data\SizeGuideInterfaceFactory;

class SizeGuide extends \Magento\Framework\Model\AbstractModel
{

    const ENTITY = 'theitnerd_sizeguide_entity';
    protected $sizeguideDataFactory;

    protected $dataObjectHelper;

    protected $_eventPrefix = 'theitnerd_sizeguide_entity';

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param SizeGuideInterfaceFactory $sizeguideDataFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param \TheITNerd\SizeGuide\Model\ResourceModel\SizeGuide $resource
     * @param \TheITNerd\SizeGuide\Model\ResourceModel\SizeGuide\Collection $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        SizeGuideInterfaceFactory $sizeguideDataFactory,
        DataObjectHelper $dataObjectHelper,
        \TheITNerd\SizeGuide\Model\ResourceModel\SizeGuide $resource,
        \TheITNerd\SizeGuide\Model\ResourceModel\SizeGuide\Collection $resourceCollection,
        array $data = []
    ) {
        $this->sizeguideDataFactory = $sizeguideDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Retrieve sizeguide model with sizeguide data
     * @return SizeGuideInterface
     */
    public function getDataModel()
    {
        $sizeguideData = $this->getData();

        $sizeguideDataObject = $this->sizeguideDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $sizeguideDataObject,
            $sizeguideData,
            SizeGuideInterface::class
        );

        return $sizeguideDataObject;
    }

    /**
     * Retrieve all attributes
     *
     * @param bool $noDesignAttributes
     * @return \Magento\Eav\Api\Data\AttributeInterface[]
     * @SuppressWarnings(PHPMD.UnusedLocalVariable)
     */
    public function getAttributes($noDesignAttributes = false)
    {
        $result = $this->getResource()->loadAllAttributes($this)->getSortedAttributes();

        if ($noDesignAttributes) {
            foreach ($result as $k => $a) {
                if (in_array($k, $this->_designAttributes)) {
                    unset($result[$k]);
                }
            }
        }

        return $result;
    }
}

