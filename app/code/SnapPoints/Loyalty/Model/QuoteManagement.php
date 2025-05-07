<?php

namespace SnapPoints\Loyalty\Model;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Quote\Model\MaskedQuoteIdToQuoteIdInterface;
use SnapPoints\Loyalty\Api\Data\QuoteInterfaceFactory;
use SnapPoints\Loyalty\Api\QuoteManagementInterface;
use SnapPoints\Loyalty\Api\QuoteRepositoryInterface;
use SnapPoints\Loyalty\Model\SDK\Quote;

class QuoteManagement implements QuoteManagementInterface
{

    public function __construct(
        protected readonly CartRepositoryInterface         $cartRepository,
        protected readonly MaskedQuoteIdToQuoteIdInterface $maskedQuoteIdToQuoteId,
        protected readonly Quote                           $quoteSDK,
        protected readonly QuoteRepositoryInterface        $quoteRepository,
        protected readonly QuoteInterfaceFactory           $quoteFactory
    )
    {
    }

    /**
     * @inheritDoc
     */
    public function getQuotation(string $quoteID, int $programID): array
    {
        if (!preg_match("/^[0-9]+$/", $quoteID)) {
            $quoteID = $this->maskedQuoteIdToQuoteId->execute($quoteID);
        }

        try {
            $newQuote = $this->quoteRepository->getByMagentoQuoteId($quoteID);
        } catch (NoSuchEntityException $e) {
            $newQuote = $this->quoteFactory->create();
        }

        $newQuote->setProgramId($programID);
        $quote = $this->cartRepository->get($quoteID);

        if(!$newQuote->getHash() || $newQuote->getHash() !== $newQuote->generateHashFromMagentoQuote($quote, $programID)) {
            $newQuote->generateHash($quote, $programID);
            $externalQuote = $this->quoteSDK->syncQuote($quote, $programID);

            $newQuote->setQuoteId((int)$quoteID)
                ->setTotalPoints($externalQuote->getTotalPoints())
                ->setExternalQuoteId($externalQuote->getQuoteId())
                ->setItems($externalQuote->getItems())
                ->setProgramId($programID);

            $newQuote = $this->quoteRepository->save($newQuote);
        }

        return [$newQuote->toDataObject()->toArray()];
    }


}
