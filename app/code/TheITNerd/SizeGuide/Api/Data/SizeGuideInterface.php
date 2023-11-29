<?php
/**
 * Copyright © MIT All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace TheITNerd\SizeGuide\Api\Data;

interface SizeGuideInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{

    public const ENTITY_ID = 'entity_id';
    public const NAME = 'name';
    public const CONFIGURATION = 'configuration';
    public const DESCRIPTION = 'description';
    public const IMAGE = 'image';

    /**
     * Get entity_id
     * @return string|null
     */
    public function getEntityId();

    /**
     * Set entity_id
     * @param string $entityId
     * @return \TheITNerd\SizeGuide\Api\Data\SizeGuideInterface
     */
    public function setEntityId($entityId);

    /**
     * @param string $value
     * @return self
     */
    public function setName(string $value): self;

    /**
     * @return string|null
     */
    public function getName(): string | null;

    /**
     * @param string $value
     * @return self
     */
    public function setConfiguration(string $value): self;

    /**
     * @return string|null
     */
    public function getConfiguration(): string | null;

    /**
     * @param string $value
     * @return self
     */
    public function setDescription(string $value): self;

    /**
     * @return string|null
     */
    public function getDescription(): string | null;

    /**
     * @param string $value
     * @return self
     */
    public function setImage(string $value): self;

    /**
     * @return string|null
     */
    public function getImage(): string | null;


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

