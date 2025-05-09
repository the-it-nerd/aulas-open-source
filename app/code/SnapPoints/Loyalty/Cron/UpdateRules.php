<?php
/**
 * Copyright © SnapPoints Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace SnapPoints\Loyalty\Cron;

use Exception;
use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;
use SnapPoints\Loyalty\Api\PointsSettingRuleRepositoryInterface;
use SnapPoints\Loyalty\Api\ProgramRepositoryInterface;
use SnapPoints\Loyalty\Model\SDK\BaseSDKFactory;

class UpdateRules
{

    /**
     * @param BaseSDKFactory $baseSDKFactory
     * @param StoreManagerInterface $storeManager
     * @param PointsSettingRuleRepositoryInterface $pointsSettingRuleRepository
     * @param WriterInterface $configWriter
     * @param LoggerInterface $logger
     */
    public function __construct(
        protected readonly BaseSDKFactory                       $baseSDKFactory,
        protected readonly StoreManagerInterface                $storeManager,
        protected readonly PointsSettingRuleRepositoryInterface $pointsSettingRuleRepository,
        protected readonly WriterInterface                      $configWriter,
        private readonly LoggerInterface $logger
    ) {
    }

    /**
     * Execute the cron job to import configurations from SnapPoints API
     *
     * @return void
     * @throws LocalizedException
     */
    public function execute(): void
    {
        $this->logger->info('Running command for all stores:');
        $baseSdk = $this->baseSDKFactory->create();

        foreach ($this->storeManager->getWebsites() as $website) {
            try {
                $storeId = $website->getDefaultGroup()->getDefaultStoreId();
                $store = $this->storeManager->getStore($storeId);
                $storeName = $store->getName();
                $storeCode = $store->getCode();
                $this->logger->info(sprintf('Store: %s (ID: %s, Code: %s)', $storeName, $storeId, $storeCode));
                // Set the current store context
                $this->storeManager->setCurrentStore($storeId);

                // Execute your logic with the specific store context
                $this->logger->info('Fetching loyalty programs...');

                $sdk = $baseSdk->getPointsRulesSDK();

                foreach ($sdk->getRules() as $rule) {
                    $this->pointsSettingRuleRepository->upsertRule($rule, $website);
                }

                $this->logger->info('Rules were updated...');

            } catch (Exception $e) {
                $this->logger->info(sprintf('<error>Error for website %s: %s</error>', $storeName, $e->getMessage()));
            }

        }

    }
}

