<?php

namespace SnapPoints\Loyalty\Api\Data;

use DateTime;
use Snappoints\Sdk\DataObjects\Interfaces\Collections\TransactionItemCollectionInterface;

interface TransactionInterface
{

    public const string LOYALTY_PROGRAM_ID = "loyalty_program_id";
    public const string PROCESSING_DAYS = "processing_days";
    public const string ITEMS = "items";
    public const string ORDERED_AT = "ordered_at";
    public const string EXPECTED_TOTAL_POINTS = "expected_total_points";
    public const string CUSTOMER_ID = "customer_id";
    public const string KEY = "key";
    public const string TRANSACTION_ID = 'transaction_id';
    public const string QUOTE_ID = 'quote_id';
    public const string ORDER_ID = 'order_id';


    /**
     * @return string|null
     */
    public function getLoyaltyProgramId(): ?string;

    /**
     * @param string $value
     * @return self
     */
    public function setLoyaltyProgramId(string $value): self;

    /**
     * @return int|null
     */
    public function getProcessingDays(): ?int;

    /**
     * @param int $value
     * @return self
     */
    public function setProcessingDays(int $value): self;

    /**
     * @return TransactionItemCollectionInterface|null
     */
    public function getItems(): ?TransactionItemCollectionInterface;

    /**
     * @param TransactionItemCollectionInterface $value
     * @return self
     */
    public function setItems(TransactionItemCollectionInterface $value): self;

    /**
     * @return DateTime|null
     */
    public function getOrderedAt(): ?DateTime;

    /**
     * @param DateTime $value
     * @return self
     */
    public function setOrderedAt(DateTime $value): self;

    /**
     * @return int|null
     */
    public function getExpectedTotalPoints(): ?int;

    /**
     * @param int $value
     * @return self
     */
    public function setExpectedTotalPoints(int $value): self;

    /**
     * @return string|null
     */
    public function getCustomerId(): ?string;

    /**
     * @param string $value
     * @return self
     */
    public function setCustomerId(string $value): self;

    /**
     * @return string|null
     */
    public function getKey(): ?string;

    /**
     * @param string $value
     * @return self
     */
    public function setKey(string $value): self;

    /**
     * @return string|null
     */
    public function getTransactionId(): ?string;

    /**
     * @param string $value
     * @return self
     */
    public function setTransactionId(string $value): self;

    /**
     * @return string|null
     */
    public function getQuoteId(): ?string;

    /**
     * @param string $value
     * @return self
     */
    public function setQuoteId(string $value): self;

    /**
     * @return int|null
     */
    public function getOrderId(): ?int;

    /**
     * @param int $value
     * @return self
     */
    public function setOrderId(int $value): self;

}
