<?php

namespace SnapPoints\Loyalty\Api;

interface QuoteManagementInterface
{
    /**
     * @param string $quoteID
     * @param int $programID
     * @return array
     */
    public function getQuotation(string $quoteID, int $programID): array;
}
