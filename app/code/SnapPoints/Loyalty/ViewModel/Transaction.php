<?php
/**
 * Copyright © SnapPoints Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace SnapPoints\Loyalty\ViewModel;

use Magento\Framework\DataObject;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\NotFoundException;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use SnapPoints\Loyalty\Api\Data\ProgramInterface;
use SnapPoints\Loyalty\Api\Data\TransactionInterface;
use SnapPoints\Loyalty\Api\TransactionRepositoryInterface;
use SnapPoints\Loyalty\Api\ProgramRepositoryInterface;

class Transaction extends DataObject implements ArgumentInterface
{

    /**
     * @param TransactionRepositoryInterface $transactionRepository
     * @param ProgramRepositoryInterface $programRepository
     */
    public function __construct(
        protected readonly TransactionRepositoryInterface $transactionRepository,
        protected readonly ProgramRepositoryInterface $programRepository,

    )
    {
        parent::__construct();
    }

    /**
     * @param \Magento\Sales\Model\Order $order
     * @return ?\SnapPoints\Loyalty\Api\Data\TransactionInterface
     */
    public function getFromMagentoOrder(\Magento\Sales\Model\Order $order): ?\SnapPoints\Loyalty\Api\Data\TransactionInterface
    {
        try {
            return $this->transactionRepository->getByMagentoOrderId((int)$order->getId());
        } catch (NotFoundException $e) {
            return null;
        }
    }

    /**
     * Retrieves the program associated with a given transaction.
     *
     * @param TransactionInterface $transaction The transaction object containing loyalty program ID.
     * @return ?ProgramInterface The program data, or null if not found.
     * @throws NoSuchEntityException
     */
    public function getProgramFromTransaction(\SnapPoints\Loyalty\Api\Data\TransactionInterface $transaction): ?\SnapPoints\Loyalty\Api\Data\ProgramInterface
    {
        try {
            return $this->programRepository->getByExternalId($transaction->getLoyaltyProgramId());
        } catch (NotFoundException $e) {
            return null;
        }
    }

    /**
     * @param string $sku
     * @param \Magento\Sales\Model\Order $order
     * @return string
     */
    public function getProductNameFromTransactionItemSKU(string $sku, \Magento\Sales\Model\Order $order): string
    {
        $text = $sku;
        foreach ($order->getItems() as $item) {
            if($item->getSku() === $sku) {
                return $item->getName();
            }
        }
        return $text;
    }

}

