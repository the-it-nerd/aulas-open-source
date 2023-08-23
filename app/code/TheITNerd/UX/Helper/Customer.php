<?php

namespace TheITNerd\UX\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Http\Context as HttpContext;

/**
 * Class Config
 * @package TheITNerd\UX\Helper
 */
class Customer extends AbstractHelper
{

    /**
     * @param HttpContext $httpsContext
     * @param Context $context
     */
    public function __construct(
        private readonly HttpContext $httpsContext,
        Context                      $context
    )
    {
        parent::__construct($context);
    }

    /**
     * @return bool
     */
    public function isLoggedIn(): bool
    {
        return $this->httpsContext->getValue(\Magento\Customer\Model\Context::CONTEXT_AUTH);
    }
}
