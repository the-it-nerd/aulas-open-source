<?php
/**
 * Copyright © MIT All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace TheITNerd\SizeGuide\Model\Data;

use Magento\Framework\Api\AbstractExtensibleObject;
use TheITNerd\SizeGuide\Api\Data\SizeGuideExtensionInterface;
use TheITNerd\SizeGuide\Api\Data\SizeGuideInterface;

/**
 * Class SizeGuide
 * @package TheITNerd\SizeGuide\Model\Data
 */
class SizeGuide extends AbstractExtensibleObject implements SizeGuideInterface
{

    /**
     * Get entity_id
     * @return string|null
     */
    public function getEntityId(): string|null
    {
        return $this->_get(self::ENTITY_ID);
    }

    /**
     * Set entity_id
     * @param string $entityId
     * @return SizeGuideInterface
     */
    public function setEntityId(string $entityId): SizeGuideInterface
    {
        return $this->setData(self::ENTITY_ID, $entityId);
    }

    /**
     * Get entity_id
     * @return string|null
     */
    public function getId(): string|null
    {
        return $this->_get(self::ENTITY_ID);
    }

    /**
     * Set entity_id
     * @param string $entityId
     * @return SizeGuideInterface
     */
    public function setId(string $entityId): SizeGuideInterface
    {
        return $this->setData(self::ENTITY_ID, $entityId);
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return SizeGuideExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object.
     * @param SizeGuideExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        SizeGuideExtensionInterface $extensionAttributes
    ): SizeGuideInterface
    {
        return $this->_setExtensionAttributes($extensionAttributes);
    }

    /**
     * @inheritDoc
     */
    public function setName(string $value): SizeGuideInterface
    {
        return $this->setData(self::NAME, $value);
    }

    /**
     * @inheritDoc
     */
    public function getName(): string|null
    {
        return $this->_get(self::NAME);
    }

    public function getData()
    {
        return $this->_data;
    }

    /**
     * @inheritDoc
     */
    public function setConfiguration(string $value): SizeGuideInterface
    {
        return $this->setData(self::CONFIGURATION, $value);
    }

    /**
     * @inheritDoc
     */
    public function getConfiguration(): string|null
    {
        return $this->_get(self::CONFIGURATION);
    }

    /**
     * @inheritDoc
     */
    public function setDescription(string $value): SizeGuideInterface
    {
        return $this->setData(self::DESCRIPTION, $value);
    }

    /**
     * @inheritDoc
     */
    public function getDescription(): string|null
    {
        return $this->_get(self::DESCRIPTION);
    }

    /**
     * @inheritDoc
     */
    public function setImage(string $value): SizeGuideInterface
    {
        return $this->setData(self::IMAGE, $value);
    }

    /**
     * @inheritDoc
     */
    public function getImage(): string|null
    {
        return $this->_get(self::IMAGE);
    }

    /**
     * @inheritDoc
     */
    public function setStoreId(int $storeId): SizeGuideInterface
    {
        return $this->setData(self::STORE_ID, $storeId);
    }

    /**
     * @inheritDoc
     */
    public function getStoreId(): int|null
    {
        return $this->_get(self::STORE_ID);
    }
}

