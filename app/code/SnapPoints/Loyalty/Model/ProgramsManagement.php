<?php
/**
 * Copyright © SnapPoints Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace SnapPoints\Loyalty\Model;

use SnapPoints\Loyalty\Api\ProgramsManagementInterface;

class ProgramsManagement implements ProgramsManagementInterface
{

    /**
     * {@inheritdoc}
     */
    public function getPrograms($param): string
    {
        return 'hello api GET return the $param ' . $param;
    }
}

