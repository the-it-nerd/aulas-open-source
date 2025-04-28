<?php
/**
 * Copyright © SnapPoints Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace SnapPoints\Loyalty\Cron;

use Exception;
use Magento\Framework\Exception\LocalizedException;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;
use SnapPoints\Loyalty\Api\ProgramRepositoryInterface;
use SnapPoints\Loyalty\Model\SDK\BaseSDKFactory;

class ImportConfigurations
{
    /**
     * @param BaseSDKFactory $baseSDKFactory
     * @param StoreManagerInterface $storeManager
     * @param ProgramRepositoryInterface $programRepository
     * @param LoggerInterface $logger
     */
    public function __construct(
        private readonly BaseSDKFactory $baseSDKFactory,
        private readonly StoreManagerInterface $storeManager,
        private readonly ProgramRepositoryInterface $programRepository,
        private readonly LoggerInterface $logger
    ) {
    }

    /**
     * Execute the cron job to import configurations from SnapPoints API
     *
     * @return void
     */
    public function execute(): void
    {
        $this->logger->info('Starting scheduled import of SnapPoints configurations');

        foreach ($this->storeManager->getStores() as $store) {
            try {
                $storeId = $store->getId();
                $storeName = $store->getName();
                $storeCode = $store->getCode();

                $this->logger->info(
                    sprintf('Processing store: %s (ID: %s, Code: %s)', $storeName, $storeId, $storeCode)
                );

                // Set the current store context
                $this->storeManager->setCurrentStore($storeId);

                $baseSdk = $this->baseSDKFactory->create();

                // Fetch loyalty programs
                $this->logger->info('Fetching loyalty programs...');
                $programs = $baseSdk->getLoyaltyProgramSDK()->getPrograms();

                if (empty($programs)) {
                    $this->logger->warning('No loyalty programs found for this store.');
                    continue;
                }

                $this->logger->info(sprintf('Found %d program(s)', count($programs)));

                foreach ($programs as $program) {
                    try {
                        $this->programRepository->upsertProgram($program);
                        $this->logger->info(
                            sprintf(
                                'Successfully saved program %s [%s]',
                                $program->getName(),
                                $program->getId()
                            )
                        );
                    } catch (Exception $e) {
                        $this->logger->error(
                            sprintf(
                                'Error while saving loyalty program: %s. Error: %s',
                                $program->getId(),
                                $e->getMessage()
                            ),
                            ['exception' => $e]
                        );
                    }
                }
            } catch (Exception $e) {
                $this->logger->error(
                    sprintf('Error for store %s: %s', $storeName, $e->getMessage()),
                    ['exception' => $e]
                );
            }
        }

        $this->logger->info('Completed scheduled import of SnapPoints configurations');
    }
}
