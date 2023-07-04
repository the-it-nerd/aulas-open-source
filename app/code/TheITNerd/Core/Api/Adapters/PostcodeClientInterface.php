<?php

namespace TheITNerd\Core\Api\Adapters;

use TheITNerd\Core\Api\Objects\AddressObjectInterface;

/**
 * Interface PostcodeClientInterface
 * @package TheITNerd\Core\Api\Adapters
 */
interface PostcodeClientInterface
{

    /**
     * @return string
     */
    public function getLabel(): string;

    /**
     * @param string $postcode
     * @return AddressObjectInterface|null
     */
    public function searchAddress(string $postcode): AddressObjectInterface|null;

    /**
     * @param AddressObjectInterface $addressObject
     * @return array|null
     */
    public function searchPostcode(AddressObjectInterface $addressObject): array|null;
}
