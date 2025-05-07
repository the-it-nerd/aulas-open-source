<?php

namespace SnapPoints\Loyalty\Model;

use DateTime;
use Magento\Framework\Model\AbstractModel;
use SnapPoints\Loyalty\Api\Data\TransactionInterface;
use Snappoints\Sdk\DataObjects\Interfaces\Collections\TransactionItemCollectionInterface;

class Transaction extends AbstractModel implements TransactionInterface
{
    /**
     * @inheritDoc
     */
    public function _construct()
    {
        $this->_init(ResourceModel\Transaction::class);
    }

    /**
     * @inheritDoc
     */
    public function getLoyaltyProgramId(): ?string
    {
        return $this->getData(self::LOYALTY_PROGRAM_ID);
    }

    /**
     * @inheritDoc
     */
    public function setLoyaltyProgramId(string $value): TransactionInterface
    {
        return $this->setData(self::LOYALTY_PROGRAM_ID, $value);
    }

    /**
     * @inheritDoc
     */
    public function getProcessingDays(): ?int
    {
        return $this->getData(self::PROCESSING_DAYS);
    }

    /**
     * @inheritDoc
     */
    public function setProcessingDays(int $value): TransactionInterface
    {
        return $this->setData(self::PROCESSING_DAYS, $value);
    }

    /**
     * @inheritDoc
     */
    public function getItems(): ?TransactionItemCollectionInterface
    {
        $items = $this->getData(self::ITEMS);

        if(!is_null($items)) {
            $items = unserialize($items);
        }
        return $items;
    }

    /**
     * @inheritDoc
     */
    public function setItems(TransactionItemCollectionInterface $value): TransactionInterface
    {
        return $this->setData(self::ITEMS, serialize($value));
    }

    /**
     * @inheritDoc
     */
    public function getOrderedAt(): ?DateTime
    {
        return $this->getData(self::ORDERED_AT);
    }

    /**
     * @inheritDoc
     */
    public function setOrderedAt(DateTime $value): TransactionInterface
    {
        return $this->setData(self::ORDERED_AT, $value);
    }

    /**
     * @inheritDoc
     */
    public function getExpectedTotalPoints(): ?int
    {
        return $this->getData(self::EXPECTED_TOTAL_POINTS);
    }

    /**
     * @inheritDoc
     */
    public function setExpectedTotalPoints(int $value): TransactionInterface
    {
        return $this->setData(self::EXPECTED_TOTAL_POINTS, $value);
    }

    /**
     * @inheritDoc
     */
    public function getCustomerId(): ?string
    {
        return $this->getData(self::CUSTOMER_ID);
    }

    /**
     * @inheritDoc
     */
    public function setCustomerId(string $value): TransactionInterface
    {
        return $this->setData(self::CUSTOMER_ID, $value);
    }

    /**
     * @inheritDoc
     */
    public function getKey(): ?string
    {
        return $this->getData(self::KEY);
    }

    /**
     * @inheritDoc
     */
    public function setKey(string $value): TransactionInterface
    {
        return $this->setData(self::KEY, $value);
    }

    /**
     * @inheritDoc
     */
    public function getTransactionId(): ?string
    {
        return $this->getData(self::TRANSACTION_ID);
    }

    /**
     * @inheritDoc
     */
    public function setTransactionId(string $value): TransactionInterface
    {
        return $this->setData(self::TRANSACTION_ID, $value);
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
    public function setQuoteId(string $value): TransactionInterface
    {
        return $this->setData(self::QUOTE_ID, $value);
    }

    /**
     * @inheritDoc
     */
    public function getOrderId(): ?int
    {
        return $this->getData(self::ORDER_ID);
    }

    /**
     * @inheritDoc
     */
    public function setOrderId(int $value): TransactionInterface
    {
        return $this->setData(self::ORDER_ID, $value);
    }
}

