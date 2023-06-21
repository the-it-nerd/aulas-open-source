<?php

namespace TheITNerd\SocialLogin\Api;

use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\App\Request\Http;

/**
 * Interface OauthInterface
 * @package TheITNerd\SocialLogin\Api
 */
interface OauthInterface
{
    /**
     * @param Http $request
     * @return CustomerInterface|null
     */
    public function getCustomerData(Http $request): null|CustomerInterface;

}
