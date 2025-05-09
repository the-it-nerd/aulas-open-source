<?php
/**
 * Copyright © SnapPoints Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace SnapPoints\Loyalty\Console\Command;

use Exception;
use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Store\Model\StoreManagerInterface;
use SnapPoints\Loyalty\Api\PointsSettingRuleRepositoryInterface;
use SnapPoints\Loyalty\Model\SDK\BaseSDKFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Rules extends Command
{

    /**
     * @param BaseSDKFactory $baseSDKFactory
     * @param StoreManagerInterface $storeManager
     * @param PointsSettingRuleRepositoryInterface $pointsSettingRuleRepository
     * @param WriterInterface $configWriter
     * @param string|null $name
     */
    public function __construct(
        protected readonly BaseSDKFactory                       $baseSDKFactory,
        protected readonly StoreManagerInterface                $storeManager,
        protected readonly PointsSettingRuleRepositoryInterface $pointsSettingRuleRepository,
        protected readonly WriterInterface                      $configWriter,
        ?string                                                 $name = null
    )
    {
        parent::__construct($name);
    }

    /**
     * @inheritdoc
     */
    protected function execute(
        InputInterface  $input,
        OutputInterface $output
    ): int
    {

        $output->writeln('<info>Running command for all stores:</info>');
        $baseSdk = $this->baseSDKFactory->create();

        foreach ($this->storeManager->getWebsites() as $website) {
            try {
                $storeId = $website->getDefaultGroup()->getDefaultStoreId();
                $store = $this->storeManager->getStore($storeId);
                $storeName = $store->getName();
                $storeCode = $store->getCode();
                $output->writeln(sprintf('<comment>Store: %s (ID: %s, Code: %s)</comment>', $storeName, $storeId, $storeCode));
                // Set the current store context
                $this->storeManager->setCurrentStore($storeId);

                // Execute your logic with the specific store context
                $output->writeln('<info>Fetching loyalty programs...</info>');

                $sdk = $baseSdk->getPointsRulesSDK();

                foreach ($sdk->getRules() as $rule) {
                    $this->pointsSettingRuleRepository->upsertRule($rule, $website);
                }

                $output->writeln('<info>Rules were updated...</info>');

            } catch (Exception $e) {
                $output->writeln(sprintf('<error>Error for website %s: %s</error>', $storeName, $e->getMessage()));
            }

        }

        return Command::SUCCESS;
    }

    /**
     * @inheritdoc
     */
    protected function configure(): void
    {
        $this->setName("snappoints:import:rules");
        $this->setDescription("Import all rules from SnapPoints");

        parent::configure();
    }
}


;
