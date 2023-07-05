<?php

namespace TheITNerd\SocialLogin\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Store\Model\ScopeInterface;

/**
 * Class Config
 * @package TheITNerd\SocialLogin\Helper
 */
class Config extends AbstractHelper
{
    public const SOCIAL_LOGIN_GENERAL_ENABLED_CONFIG_PATH = "social_login/general/enabled";
    public const SOCIAL_LOGIN_GOOGLE_ENABLED_CONFIG_PATH = "social_login/google/enabled";
    public const SOCIAL_LOGIN_GOOGLE_CLIENT_ID_CONFIG_PATH = "social_login/google/client_id";
    public const SOCIAL_LOGIN_FACEBOOK_ENABLED_CONFIG_PATH = "social_login/facebook/enabled";
    public const SOCIAL_LOGIN_FACEBOOK_APP_ID_CONFIG_PATH = "social_login/facebook/app_id";
    public const SOCIAL_LOGIN_FACEBOOK_APP_SECRET_CONFIG_PATH = "social_login/facebook/app_secret";

    public function __construct(
        Context                      $context,
        private readonly HttpContext $httpContext
    )
    {
        parent::__construct($context);
    }

    /**
     * @return bool
     */
    public function isGoogleEnabled(): bool
    {
        return $this->scopeConfig->getValue(self::SOCIAL_LOGIN_GOOGLE_ENABLED_CONFIG_PATH, ScopeInterface::SCOPE_STORE) && $this->isEnabled();
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return (bool)$this->scopeConfig->getValue(self::SOCIAL_LOGIN_GENERAL_ENABLED_CONFIG_PATH, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return string|null
     */
    public function getGoogleClientId(): string|null
    {
        return $this->scopeConfig->getValue(self::SOCIAL_LOGIN_GOOGLE_CLIENT_ID_CONFIG_PATH, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return bool
     */
    public function isFacebookEnabled(): bool
    {
        return $this->scopeConfig->getValue(self::SOCIAL_LOGIN_FACEBOOK_ENABLED_CONFIG_PATH, ScopeInterface::SCOPE_STORE) && $this->isEnabled();
    }

    /**
     * @return string|null
     */
    public function getFacebookAppId(): string|null
    {
        return $this->scopeConfig->getValue(self::SOCIAL_LOGIN_FACEBOOK_APP_ID_CONFIG_PATH, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return string|null
     */
    public function getFacebookAppSecret(): string|null
    {
        return $this->scopeConfig->getValue(self::SOCIAL_LOGIN_FACEBOOK_APP_SECRET_CONFIG_PATH, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return string
     */
    public function getFacebookLoginCallback(): string
    {
        return $this->_getUrl('social-login/auth/callback/type/facebook');
    }

    /**
     * @return bool
     */
    public function isLoggedIn(): bool
    {
        return (bool)$this->httpContext->getValue(\Magento\Customer\Model\Context::CONTEXT_AUTH);
    }
}
