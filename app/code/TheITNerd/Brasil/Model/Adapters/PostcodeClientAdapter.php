<?php

namespace TheITNerd\Brasil\Model\Adapters;

use TheITNerd\Brasil\Helper\Config;
use TheITNerd\Brasil\Api\Adapters\PostcodeClientInterface;
use TheITNerd\Brasil\Api\Objects\AddressObjectInterface;

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
    public function searchPostcode(AddressObjectInterface $addressObject): array
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
