<?php

namespace TheITNerd\EAV\Model;


use Magento\Catalog\Api\Data\CategoryInterface;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Model\Category;
use Magento\Catalog\Model\Product;
use Magento\Framework\Api\AttributeValueFactory;
use Magento\Framework\Api\ExtensionAttributesFactory;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class AbstractModel
 * @package TheITNerd\EAV\Model
 */
class AbstractModel extends \Magento\Catalog\Model\AbstractModel
{
    public function __construct(
        Context                    $context,
        Registry                   $registry,
        ExtensionAttributesFactory $extensionFactory,
        AttributeValueFactory      $customAttributeFactory,
        StoreManagerInterface      $storeManager,
        protected array            $entityTypes = [],
        AbstractResource           $resource = null,
        AbstractDb                 $resourceCollection = null,
        array                      $data = []
    )
    {
        parent::__construct($context, $registry, $extensionFactory, $customAttributeFactory, $storeManager, $resource, $resourceCollection, $data);
    }

    /**
     * {$inheritDoc}
     */
    public function getAttributeDefaultValue($attributeCode)
    {
        if ($this->_defaultValues === null) {
            $entityType = $this->entityTypes[$this->getResource()->getEntityType()->getEntityTypeCode()];
            $this->_defaultValues = $this->getAttributeScopeOverriddenValue()->getDefaultValues($entityType, $this);
        }

        return array_key_exists($attributeCode, $this->_defaultValues) ? $this->_defaultValues[$attributeCode] : false;
    }

    /**
     * {$inheritDoc}
     */
    public function getExistsStoreValueFlag($attributeCode)
    {
        if ($this->_storeValuesFlags === null) {
            $entityType = $this->entityTypes[$this->getResource()->getEntityType()->getEntityTypeCode()];
            return $this->getAttributeScopeOverriddenValue()->containsValue(
                $entityType,
                $this,
                $attributeCode,
                $this->getStore()->getId()
            );
        }

        return array_key_exists($attributeCode, $this->_storeValuesFlags);
    }

}
