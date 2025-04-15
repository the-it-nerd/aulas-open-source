<?php
/**
 * Copyright © SnapPoints Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace SnapPoints\Loyalty\Api;

interface RatesVersionManagementInterface
{

    /**
     * GET for RatesVersion api
     * @param string $param
     * @return string
     */
    public function getRatesVersion(string $param): string;
}

