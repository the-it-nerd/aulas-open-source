<?php
/**
 * Copyright © SnapPoints Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace SnapPoints\Loyalty\Model;

class ProgramsVersionManagement implements \SnapPoints\Loyalty\Api\ProgramsVersionManagementInterface
{

    /**
     * {@inheritdoc}
     */
    public function getProgramsVersion($param)
    {
        return 'hello api GET return the $param ' . $param;
    }
}

