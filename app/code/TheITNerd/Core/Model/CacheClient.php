<?php

namespace TheITNerd\Core\Model;

use Magento\Framework\App\CacheInterface;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Store\Model\StoreManagerInterface;

class CacheClient
{

    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * @var CacheInterface
     */
    private CacheInterface $cache;

    /**
     * @var StoreManagerInterface
     */
    private StoreManagerInterface $storeManager;

    /**
     * @param SerializerInterface $serializer
     * @param CacheInterface $cache
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        SerializerInterface   $serializer,
        CacheInterface        $cache,
        StoreManagerInterface $storeManager
    )
    {
        $this->serializer = $serializer;
        $this->cache = $cache;
        $this->storeManager = $storeManager;
    }

    /**
     * @param string $key
     * @param string $scope
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
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
     * @param mixed $data
     * @param array $tags
     * @param int $ttl
     * @param string $scope
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
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
     * @return mixed
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function load(string $key, string $scope = 'global'): mixed
    {
        if($cache = $this->cache->load($this->addScopeToCacheKey($key, $scope))) {
            return $this->serializer->unserialize($cache);
        }

        return null;
    }
}
