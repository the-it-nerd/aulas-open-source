<?php
/**
 * Copyright © SnapPoints Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace SnapPoints\Loyalty\Model;

class RatesVersionManagement implements \SnapPoints\Loyalty\Api\RatesVersionManagementInterface
{

    /**
     * {@inheritdoc}
     */
    public function getRatesVersion($param)
    {
        return 'hello api GET return the $param ' . $param;
    }
}

