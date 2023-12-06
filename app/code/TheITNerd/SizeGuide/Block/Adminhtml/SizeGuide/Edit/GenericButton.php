<?php
/**
 * Copyright © MIT All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace TheITNerd\SizeGuide\Block\Adminhtml\SizeGuide\Edit;

use Magento\Backend\Block\Widget\Context;

/**
 * Class GenericButton
 *
 * The GenericButton class provides common functionality for buttons in the Magento backend.
 * It allows you to get the model ID and generate URLs easily.
 */
abstract class GenericButton
{


    /**
     * @param Context $context
     */
    public function __construct(
        protected readonly Context $context
    )
    {
    }

    /**
     * Return model ID
     *
     * @return string|null
     */
    public function getModelId(): string|null
    {
        return $this->context->getRequest()->getParam('entity_id');
    }

    /**
     * Generate url by route and parameters
     *
     * @param string $route
     * @param array $params
     * @return  string
     */
    public function getUrl(string $route = '', array $params = []): string
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}

