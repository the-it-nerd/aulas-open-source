<?php
/**
 * Copyright © SnapPoints Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace SnapPoints\Loyalty\Model;

class ProgramsManagement implements \SnapPoints\Loyalty\Api\ProgramsManagementInterface
{

    /**
     * {@inheritdoc}
     */
    public function getPrograms($param)
    {
        return 'hello api GET return the $param ' . $param;
    }
}

