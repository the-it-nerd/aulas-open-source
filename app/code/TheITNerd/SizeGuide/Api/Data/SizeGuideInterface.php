<?php
/**
 * Copyright © MIT All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace TheITNerd\SizeGuide\Api\Data;

interface SizeGuideInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{

    const ENTITY_ID = 'entity_id';
    const TITLE = 'title';

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

