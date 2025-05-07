<?php

namespace SnapPoints\Loyalty\Api\Data;

use Snappoints\Sdk\DataObjects\Entities\Transaction;
use Snappoints\Sdk\DataObjects\Interfaces\Collections\TransactionItemCollectionInterface;
use Snappoints\Sdk\DataObjects\Interfaces\Objects\TransactionQuotationInterface;

interface QuoteInterface
{
    public const ITEMS  = 'items';
    public const ENTITY_ID  = 'entity_id';
    public const QUOTE_ID  = 'quote_id';
    public const EXTERNAL_QUOTE_ID  = 'external_quote_id';
    public const TOTAL_POINTS  = 'total_points';
    public const HASH  = 'hash';


    /**
     * @return TransactionItemCollectionInterface|null
     */
    public function getItems():?TransactionItemCollectionInterface;

    /**
     * @param TransactionItemCollectionInterface $value
     * @return self
     */
    public function setItems(TransactionItemCollectionInterface $value):self;

    /**
     * @return string|null
     */
    public function getQuoteId():?string;

    /**
     * @param string $value
     * @return self
     */
    public function setQuoteId(string $value):self;

    /**
     * @return int|null
     */
    public function getTotalPoints():?int;

    /**
     * @param int $value
     * @return self
     */
    public function setTotalPoints(int $value):self;


    /**
     * @return string|null
     */
    public function getExternalQuoteId():? string;

    /**
     * @param string $value
     * @return self
     */
    public function setExternalQuoteId(string $value): self;


    /**
     * @return TransactionQuotationInterface|null
     */
    public function toDataObject(): ?TransactionQuotationInterface;

    /**
     * @return string|null
     */
    public function getHash():?string;

    /**
     * @param string $value
     * @return self
     */
    public function setHash(string $value):self;

}




