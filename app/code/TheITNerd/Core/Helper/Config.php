<?php

namespace TheITNerd\Core\Helper;

use InvalidArgumentException;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\ObjectManager;
use Magento\Store\Model\ScopeInterface;
use TheITNerd\Core\Api\Adapters\PostcodeClientInterface;

/**
 * Class Config
 * @package TheITNerd\Core\Helper
 */
class Config extends AbstractHelper
{
    public const ADDRESS_SEARCH_API_ENABLED_CONFIG_PATH = "address_search/api/enabled";
    public const ADDRESS_SEARCH_API_ADAPTER_CONFIG_PATH = "address_search/api/adapter";

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return (bool)$this->scopeConfig->getValue(self::ADDRESS_SEARCH_API_ENABLED_CONFIG_PATH, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return PostcodeClientInterface|null
     */
    public function getAdapter(): PostcodeClientInterface | null
    {
        $className = $this->scopeConfig->getValue(self::ADDRESS_SEARCH_API_ADAPTER_CONFIG_PATH, ScopeInterface::SCOPE_STORE);

        if (!$className) {
            throw new InvalidArgumentException(__("Postcode Adapter not set"));
        }

        $adapter = ObjectManager::getInstance()->get($className);

        if(!$adapter instanceof PostcodeClientInterface) {
            throw new InvalidArgumentException(__("Postcode Adapter must implement TheITNerd\Core\Api\Adapters\PostcodeClientInterface"));
        }

        return $adapter;
    }

}
