<?php
/**
 * Copyright © SnapPoints Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace SnapPoints\Loyalty\Model;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\AbstractModel;
use Magento\Quote\Api\Data\CartInterface;
use SnapPoints\Loyalty\Api\Data\QuoteInterface;
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
        $this->_init(ResourceModel\Quote::class);
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
    public function setQuoteId(string $value): QuoteInterface
    {
        return $this->setData(self::QUOTE_ID, $value);
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
    public function getItems(): ?TransactionItemCollectionInterface
    {
        $items = $this->getData(self::ITEMS);

        if ($items) {
            return unserialize($items);
        }
        return $items;
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
    public function getTotalPoints(): ?int
    {
        $points = $this->getData(self::TOTAL_POINTS);
        if(!is_null($points)) {
            $points = (int)$points;
        }

        return $points;
    }

    /**
     * Retrieves a hash from the Magento Quote based on its ID.
     *
     * @param CartInterface $cart The Magento quote object.
     * @return string The generated hash.
     * @throws LocalizedException
     */
    public function generateHashFromMagentoQuote(CartInterface $cart, int $programId): string
    {
        if(is_null($this->getQuoteId())) {
            $this->setQuoteId($cart->getId());
        }

        if ($cart->getId() !== $this->getQuoteId()) {
            throw new LocalizedException(__('The Platform and SnapPoints Object quote ids dos not match'));
        }

        $hash = [$programId, $this->getId(), $this->getQuoteId()];

        foreach ($cart->getAllItems() as $item) {
            $hash[] = "{$item->getItemId()}-{$item->getQty()}-{$item->getUpdatedAt()}";
        }

        return base64_encode(implode('_', $hash));
    }

    /**
     * @param CartInterface $cart
     * @return self
     * @throws LocalizedException
     */
    public function generateHash(CartInterface $cart, int $programID):self
    {
        return $this->setHash($this->generateHashFromMagentoQuote($cart, $programID));
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
    public function getHash(): ?string
    {
        return $this->getData(self::HASH);
    }

    /**
     * @inheritDoc
     */
    public function setHash(string $value): QuoteInterface
    {
        return $this->setData(self::HASH, $value);
    }

    /**
     * @inheritDoc
     */
    public function getProgramId(): ?string
    {
        return $this->getData(self::PROGRAM_ID);
    }

    /**
     * @inheritDoc
     */
    public function setProgramId(string $value): QuoteInterface
    {
        return $this->setData(self::PROGRAM_ID, $value);
    }
}

