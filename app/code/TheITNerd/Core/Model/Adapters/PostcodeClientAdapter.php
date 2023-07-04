<?php

namespace TheITNerd\Core\Model\Adapters;

use TheITNerd\Core\Helper\Config;
use TheITNerd\Core\Api\Adapters\PostcodeClientInterface;
use TheITNerd\Core\Api\Objects\AddressObjectInterface;

/**
 * Class PostcodeClientAdapter
 * @package TheITNerd\Core\Model\Adapters
 */
class PostcodeClientAdapter implements PostcodeClientInterface
{

    /**
     * @var PostcodeClientInterface
     */
    private PostcodeClientInterface $adapter;

    /**
     * @param Config $config
     */
    public function __construct(
        Config $config
    ) {
        $this->adapter = $config->getAdapter();
    }

    /**
     * @inheritDoc
     */
    public function searchAddress(string $postcode): AddressObjectInterface|null
    {
        return $this->adapter->searchAddress($postcode);
    }

    /**
     * @inheritDoc
     */
    public function searchPostcode(AddressObjectInterface $addressObject): array|null
    {
        return $this->adapter->searchPostcode($addressObject);
    }

    /**
     * @inheritDoc
     */
    public function getLabel(): string
    {
        return 'Main Adapter Model - Do not use as config';
    }
}
