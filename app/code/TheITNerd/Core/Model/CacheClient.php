<?php

namespace TheITNerd\Core\Model;

use Magento\Framework\App\CacheInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class CacheClient
 * @package TheITNerd\Core\Model
 */
class CacheClient
{

    /**
     * @param SerializerInterface $serializer
     * @param CacheInterface $cache
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        private SerializerInterface   $serializer,
        private CacheInterface        $cache,
        private StoreManagerInterface $storeManager
    )
    {
    }

    /**
     * @param string $key
     * @param mixed $data
     * @param array $tags
     * @param int $ttl
     * @param string $scope
     * @return bool
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function save(string $key, mixed $data, array $tags = [], int $ttl = 86400, string $scope = 'global'): bool
    {
        return $this->cache->save(
            $this->serializer->serialize($data),
            $this->addScopeToCacheKey($key, $scope),
            $tags,
            $ttl
        );
    }

    /**
     * @param string $key
     * @param string $scope
     * @return string
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    private function addScopeToCacheKey(string $key, string $scope): string
    {
        switch ($scope) {
            case StoreManagerInterface::CONTEXT_STORE:
                return "{$key}_store_{$this->storeManager->getStore()->getId()}";
                break;
            case 'website':
                return "{$key}_website_{$this->storeManager->getWebsite()->getId()}";
                break;
            default:
                return $key;
                break;
        }
    }

    /**
     * @param string $key
     * @param string $scope
     * @return mixed
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function load(string $key, string $scope = 'global'): mixed
    {
        if ($cache = $this->cache->load($this->addScopeToCacheKey($key, $scope))) {
            return $this->serializer->unserialize($cache);
        }

        return null;
    }

    /**
     * @param string $key
     * @param string $scope
     * @return void
     */
    public function remove(string $key, string $scope = 'global'): void
    {
        $cacheKey = $this->addScopeToCacheKey($key, $scope);
        if ($this->cache->load($cacheKey)) {
            $this->cache->remove($cacheKey);
        }
    }
}
