<?php

namespace TheITNerd\Core\Api;

/**
 * Interface PostcodeSearchInterface
 * @package TheITNerd\Core\Api
 */
interface PostcodeSearchInterface
{
    /**
     * Search address from a postcode
     * @return array
     */
    public function searchAddress(): array;

    /**
     * Search postcode from an Address
     * @return array
     */
    public function searchPostcode(): array;
}
