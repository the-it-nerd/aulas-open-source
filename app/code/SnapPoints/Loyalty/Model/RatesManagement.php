<?php
/**
 * Copyright © SnapPoints Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace SnapPoints\Loyalty\Model;

class RatesManagement implements \SnapPoints\Loyalty\Api\RatesManagementInterface
{

    /**
     * {@inheritdoc}
     */
    public function getRates($param)
    {
        return 'hello api GET return the $param ' . $param;
    }
}

