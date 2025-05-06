<?php
/**
 * Copyright © SnapPoints Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace SnapPoints\Loyalty\Model;

use Magento\Framework\Model\AbstractModel;
use SnapPoints\Loyalty\Api\Data\QuoteInterface;
use Snappoints\Sdk\DataObjects\Entities\Transaction;
use Snappoints\Sdk\DataObjects\Entities\TransactionQuotation;
use Snappoints\Sdk\DataObjects\Interfaces\Collections\TransactionItemCollectionInterface;
use Snappoints\Sdk\DataObjects\Interfaces\Objects\TransactionQuotationInterface;

class Quote extends AbstractModel implements QuoteInterface
{

    /**
     * @inheritDoc
     */
    public function _construct()
    {
        $this->_init(ResourceModel\Rates::class);
    }

    /**
     * @inheritDoc
     */
    public function getItems(): ?TransactionItemCollectionInterface
    {
        $items = $this->getData(self::ITEMS);

        if($items) {
            return unserialize($items);
        }
        return $items;
    }

    /**
     * @inheritDoc
     */
    public function setItems(TransactionItemCollectionInterface $value): QuoteInterface
    {
        return $this->setData(self::ITEMS, serialize($value));
    }

    /**
     * @inheritDoc
     */
    public function getQuoteId(): ?string
    {
        return $this->getData(self::QUOTE_ID);
    }

    /**
     * @inheritDoc
     */
    public function setQuoteId(string $value): QuoteInterface
    {
        return $this->setData(self::QUOTE_ID, $value);
    }

    /**
     * @inheritDoc
     */
    public function getTotalPoints(): ?int
    {
        return $this->getData(self::TOTAL_POINTS);
    }

    /**
     * @inheritDoc
     */
    public function setTotalPoints(int $value): QuoteInterface
    {
        return $this->setData(self::TOTAL_POINTS, $value);
    }

    /**
     * @inheritDoc
     */
    public function getExternalQuoteId(): ?string
    {
        return $this->getData(self::EXTERNAL_QUOTE_ID);
    }

    /**
     * @inheritDoc
     */
    public function setExternalQuoteId(string $value): QuoteInterface
    {
        return $this->setData(self::EXTERNAL_QUOTE_ID, $value);
    }

    /**
     * @inheritDoc
     */
    public function toDataObject(): ?TransactionQuotationInterface
    {
        return new TransactionQuotation()
            ->setItems($this->getItems())
            ->setQuoteId($this->getExternalQuoteId())
            ->setTotalPoints($this->getTotalPoints());
    }
}

