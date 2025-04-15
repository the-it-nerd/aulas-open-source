<?php
/**
 * Copyright © SnapPoints Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace SnapPoints\Loyalty\Api;

interface ProgramsVersionManagementInterface
{

    /**
     * GET for ProgramsVersion api
     * @param string $param
     * @return string
     */
    public function getProgramsVersion($param);
}

