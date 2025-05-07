<?php

namespace SnapPoints\Loyalty\Observer;

use Exception;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Psr\Log\LoggerInterface;
use SnapPoints\Loyalty\Api\Data\TransactionInterfaceFactory;
use SnapPoints\Loyalty\Api\ProgramRepositoryInterface;
use SnapPoints\Loyalty\Api\QuoteRepositoryInterface;
use SnapPoints\Loyalty\Api\TransactionRepositoryInterface;
use SnapPoints\Loyalty\Model\SDK\Customer;
use SnapPoints\Loyalty\Model\SDK\Quote;

class OrderPlaceAfter implements ObserverInterface
{

    public function __construct(
        protected readonly QuoteRepositoryInterface       $quoteRepository,
        protected readonly ProgramRepositoryInterface     $programRepository,
        protected readonly Quote                          $quoteSDK,
        protected readonly Customer                       $customerSDK,
        protected readonly TransactionRepositoryInterface $transactionRepository,
        protected readonly TransactionInterfaceFactory    $transactionFactory,
        protected readonly LoggerInterface                $logger
    )
    {
    }

    public function execute(Observer $observer)
    {
        //TODO: move this rule to a queue
        try {
            $order = $observer->getEvent()->getOrder();

            try {
                $this->transactionRepository->getByMagentoOrderId($order->getId());
            } catch (NoSuchEntityException $e) {
                $customer = $this->customerSDK->getCustomerByOrder($order);
                $quote = $this->quoteRepository->getByMagentoQuoteId($order->getQuoteId());
                $program = $this->programRepository->get($quote->getProgramId());
                $quoteObject = $quote->toDataObject()
                    ->setLoyaltyProgramId($program->getExternalId());

                $transaction = $this->quoteSDK->getQuoteSDK()->placeTransaction($quoteObject, $customer);

                $magentoTransaction = $this->transactionFactory->create()
                    ->setItems($transaction->getItems())
                    ->setOrderedAt($transaction->getOrderedAt() ?? new \DateTime('now'))
                    ->setQuoteId($quote->getQuoteId())
                    ->setTransactionId($transaction->getTransactionId())
                    ->setLoyaltyProgramId($transaction->getLoyaltyProgramId() ?? $program->getExternalId())
                    ->setCustomerId($transaction->getCustomerId() ?? $customer->getId())
                    ->setOrderId($order->getId());

                $this->transactionRepository->save($magentoTransaction);
            }
        } catch (Exception $e) {
            $this->logger->info($e->getMessage());
        }
    }
}
