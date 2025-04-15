<?php
/**
 * Copyright © SnapPoints Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace SnapPoints\Loyalty\Api\Data;

interface RatesInterface
{

    public const PRODUCT_ID = 'product_id';
    public const CONFIGURATION = 'configuration';
    public const RATES_ID = 'rates_id';
    public const PROGRAM_ID = 'program_id';

    /**
     * Get rates_id
     * @return int|null
     */
    public function getRatesId(): ?int;

    /**
     * Set rates_id
     * @param int $ratesId
     * @return self
     */
    public function setRatesId(int $ratesId);

    /**
     * Get program_id
     * @return int|null
     */
    public function getProgramId(): ?int;

    /**
     * Set program_id
     * @param int $programId
     * @return self
     */
    public function setProgramId(int $programId);

    /**
     * Get configuration
     * @return string|null
     */
    public function getConfiguration(): ?string;

    /**
     * Set configuration
     * @param string $configuration
     * @return self
     */
    public function setConfiguration(string $configuration): self;

    /**
     * Get product_id
     * @return int|null
     */
    public function getProductId(): ?int;

    /**
     * Set product_id
     * @param int $productId
     * @return self
     */
    public function setProductId(int $productId): self;
}

