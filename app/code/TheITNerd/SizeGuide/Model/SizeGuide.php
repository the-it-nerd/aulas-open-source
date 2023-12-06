<?php
/**
 * Copyright © MIT All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace TheITNerd\SizeGuide\Model;

use Magento\Eav\Api\Data\AttributeInterface;
use Magento\Framework\Api\AttributeValueFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\ExtensionAttributesFactory;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Store\Model\StoreManagerInterface;
use TheITNerd\EAV\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use TheITNerd\SizeGuide\Api\Data\SizeGuideInterface;
use TheITNerd\SizeGuide\Api\Data\SizeGuideInterfaceFactory;
use TheITNerd\SizeGuide\Model\ResourceModel\SizeGuide\Collection;

/**
 * Class SizeGuide
 * @package TheITNerd\SizeGuide\Model
 */
class SizeGuide extends AbstractModel
{

    public const ENTITY = 'theitnerd_sizeguide_entity';

    protected $_eventPrefix = 'theitnerd_sizeguide_entity';

    /**
     * @param Context $context
     * @param Registry $registry
     * @param ExtensionAttributesFactory $extensionFactory
     * @param AttributeValueFactory $customAttributeFactory
     * @param StoreManagerInterface $storeManager
     * @param SizeGuideInterfaceFactory $sizeguideDataFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param ResourceModel\SizeGuide $resource
     * @param array $entityTypes
     * @param AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(
        Context                                      $context,
        Registry                                     $registry,
        ExtensionAttributesFactory                   $extensionFactory,
        AttributeValueFactory                        $customAttributeFactory,
        StoreManagerInterface                        $storeManager,
        protected readonly SizeGuideInterfaceFactory $sizeguideDataFactory,
        protected readonly DataObjectHelper          $dataObjectHelper,
        ResourceModel\SizeGuide                      $resource,
        array                                        $entityTypes = [],
        AbstractDb                                   $resourceCollection = null,
        array                                        $data = []
    )
    {
        parent::__construct($context, $registry, $extensionFactory, $customAttributeFactory, $storeManager, $entityTypes, $resource, $resourceCollection, $data);
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
     * @return AttributeInterface[]
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

