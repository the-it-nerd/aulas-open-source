<?php
/**
 * Copyright © SnapPoints Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace SnapPoints\Loyalty\Model;

use Magento\Framework\Model\AbstractModel;
use SnapPoints\Loyalty\Api\Data\RatesInterface;

class Rates extends AbstractModel implements RatesInterface
{

    /**
     * @inheritDoc
     */
    public function _construct()
    {
        $this->_init(\SnapPoints\Loyalty\Model\ResourceModel\Rates::class);
    }

    /**
     * @inheritDoc
     */
    public function getRatesId()
    {
        return $this->getData(self::RATES_ID);
    }

    /**
     * @inheritDoc
     */
    public function setRatesId($ratesId)
    {
        return $this->setData(self::RATES_ID, $ratesId);
    }

    /**
     * @inheritDoc
     */
    public function getProgramId()
    {
        return $this->getData(self::PROGRAM_ID);
    }

    /**
     * @inheritDoc
     */
    public function setProgramId($programId)
    {
        return $this->setData(self::PROGRAM_ID, $programId);
    }

    /**
     * @inheritDoc
     */
    public function getConfiguration()
    {
        return $this->getData(self::CONFIGURATION);
    }

    /**
     * @inheritDoc
     */
    public function setConfiguration($configuration)
    {
        return $this->setData(self::CONFIGURATION, $configuration);
    }

    /**
     * @inheritDoc
     */
    public function getProductId()
    {
        return $this->getData(self::PRODUCT_ID);
    }

    /**
     * @inheritDoc
     */
    public function setProductId($productId)
    {
        return $this->setData(self::PRODUCT_ID, $productId);
    }
}

