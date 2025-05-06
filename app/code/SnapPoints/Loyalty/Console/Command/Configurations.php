<?php
/**
 * Copyright © SnapPoints Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace SnapPoints\Loyalty\Console\Command;

use Exception;
use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;
use SnapPoints\Loyalty\Api\ProgramRepositoryInterface;
use SnapPoints\Loyalty\Helper\Config;
use SnapPoints\Loyalty\Model\SDK\BaseSDKFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Configurations extends Command
{
    private const FORCE = "force";


    public function __construct(
        protected readonly BaseSDKFactory             $baseSDKFactory,
        protected readonly StoreManagerInterface      $storeManager,
        protected readonly ProgramRepositoryInterface $programRepository,
        protected readonly WriterInterface            $configWriter,
        ?string                                       $name = null
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
        $force = $input->getArgument(self::FORCE);

        $output->writeln('<info>Running command for all stores:</info>');
        $baseSdk = $this->baseSDKFactory->create();
        foreach ($this->storeManager->getStores() as $store) {
            try {
                $storeId = $store->getId();
                $storeName = $store->getName();
                $storeCode = $store->getCode();

                $output->writeln(sprintf('<comment>Store: %s (ID: %s, Code: %s)</comment>', $storeName, $storeId, $storeCode));

                // Set the current store context
                $this->storeManager->setCurrentStore($storeId);

                // Execute your logic with the specific store context
                $output->writeln('<info>Fetching loyalty programs...</info>');
                $programs = $baseSdk->getLoyaltyProgramSDK()->getPrograms();

                if (empty($programs)) {
                    $output->writeln('<error>No loyalty programs found for this store.</error>');
                    continue;
                }

                $output->writeln(sprintf('<info>Found %d program(s)</info>', count($programs)));

                foreach ($programs as $program) {
                    try {
                        $program = $this->programRepository->upsertProgram($program);
                        $output->writeln(sprintf('<info>Successfully saved program %s  </info>', "{$program->getName()} [{$program->getProgramId()}]"));
                    } catch (Exception $e) {
                        //TODO add log here
                        $output->writeln(sprintf('<error>Error while saving loyalty program. \n %s</error>', json_encode($program->toArray())));
                    }
                }

                $ratio = $baseSdk->getMaxGiveBackRatio()->getMaxGiveBackRatio();

                $output->writeln('');
                $output->writeln(sprintf('<info>Updating Max Give Back Ratio to %s</info>', (string)$ratio->getMaxGiveBackRatio()));

                /**
                 * TODO: Change here
                 * 1 - We need to get the value first to confirm its different, this way we can avoid unucessary write to teh database
                 * 2 - we need to purge config cache and fpc if the write was successful
                 *
                 */
                $this->configWriter->save(Config::XML_PATH_MAX_GIVE_BACK_RATIO, (string)$ratio->getMaxGiveBackRatio(), ScopeInterface::SCOPE_WEBSITES, $store->getWebsiteId());

            } catch (Exception $e) {
                $output->writeln(sprintf('<error>Error for store %s: %s</error>', $storeName, $e->getMessage()));
            }

        }

        return Command::SUCCESS;
    }

    /**
     * @inheritdoc
     */
    protected function configure(): void
    {
        $this->setName("snappoints:import:configurations");
        $this->setDescription("Import all configurations from SnapPoints");
        $this->setDefinition([
            new InputArgument(self::FORCE, InputArgument::OPTIONAL, "Force update all data"),
        ]);
        parent::configure();
    }
}

