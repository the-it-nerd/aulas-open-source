<?php

namespace TheITNerd\UX\Api;

/**
 * Interface PDPEstimateShippingMethodsInterface
 * @package TheITNerd\UX\Api
 */
interface PDPEstimateShippingMethodsInterface
{
    /**
     * @return array
     */
    public function estimateShippingMethods(): array;
}
