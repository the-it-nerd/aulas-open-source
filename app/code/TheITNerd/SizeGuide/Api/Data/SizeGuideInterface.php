<?php
/**
 * Copyright © MIT All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace TheITNerd\SizeGuide\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

/**
 * Interface SizeGuideInterface
 * Represents the size guide entity.
 * @package TheITNerd\SizeGuide\Api\Data
 */
interface SizeGuideInterface extends ExtensibleDataInterface
{

    public const ENTITY_ID = 'entity_id';
    public const NAME = 'name';
    public const CONFIGURATION = 'configuration';
    public const DESCRIPTION = 'description';
    public const IMAGE = 'image';
    public const STORE_ID = 'store_id';

    /**
     * Get entity_id
     * @return string|null
     */
    public function getEntityId(): string|null;

    /**
     * Set entity_id
     * @param string $entityId
     * @return SizeGuideInterface
     */
    public function setEntityId(string $entityId): self;

    /**
     * @return string|null
     */
    public function getId(): string|null;

    /**
     * @param string $id
     * @return string|null
     */
    public function setId(string $id): self;

    /**
     * @param string $value
     * @return self
     */
    public function setName(string $value): self;

    /**
     * @return string|null
     */
    public function getName(): string|null;

    /**
     * @param string $value
     * @return self
     */
    public function setConfiguration(string $value): self;

    /**
     * @return string|null
     */
    public function getConfiguration(): string|null;

    /**
     * @param string $value
     * @return self
     */
    public function setDescription(string $value): self;

    /**
     * @return string|null
     */
    public function getDescription(): string|null;

    /**
     * @param string $value
     * @return self
     */
    public function setImage(string $value): self;

    /**
     * @return string|null
     */
    public function getImage(): string|null;

    /**
     * @param int $storeId
     * @return self
     */
    public function setStoreId(int $storeId): self;

    /**
     * @return int|null
     */
    public function getStoreId(): int |null;


    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \TheITNerd\SizeGuide\Api\Data\SizeGuideExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     * @param \TheITNerd\SizeGuide\Api\Data\SizeGuideExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \TheITNerd\SizeGuide\Api\Data\SizeGuideExtensionInterface $extensionAttributes
    );
}

