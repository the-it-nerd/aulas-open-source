<?php

namespace TheITNerd\Brasil\Api\Adapters;

use TheITNerd\Brasil\Api\Objects\AddressObjectInterface;
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
     * @return array
     */
    public function searchPostcode(AddressObjectInterface $addressObject): array;
}
