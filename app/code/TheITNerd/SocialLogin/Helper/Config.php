<?php

namespace TheITNerd\SocialLogin\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\ObjectManager;
use Magento\Store\Model\ScopeInterface;
use TheITNerd\Core\Api\Adapters\PostcodeClientInterface;

/**
 * Class Config
 * @package TheITNerd\SocialLogin\Helper
 */
class Config extends AbstractHelper
{
    public const SOCIAL_LOGIN_GENERAL_ENABLED_CONFIG_PATH = "social_login/general/enabled";
    public const SOCIAL_LOGIN_GOOGLE_ENABLED_CONFIG_PATH = "social_login/google/enabled";
    public const SOCIAL_LOGIN_GOOGLE_CLIENT_ID_CONFIG_PATH = "social_login/google/client_id";



    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return (bool)$this->scopeConfig->getValue(self::SOCIAL_LOGIN_GENERAL_ENABLED_CONFIG_PATH, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return bool
     */
    public function isGoogleEnabled(): bool
    {
        return (bool)$this->scopeConfig->getValue(self::SOCIAL_LOGIN_GOOGLE_ENABLED_CONFIG_PATH, ScopeInterface::SCOPE_STORE) && $this->isEnabled();
    }

    /**
     * @return string|null
     */
    public function getGoogleClientId(): string|null
    {
        return $this->scopeConfig->getValue(self::SOCIAL_LOGIN_GOOGLE_CLIENT_ID_CONFIG_PATH, ScopeInterface::SCOPE_STORE);
    }

}
