<?php
/**
 * Copyright © SnapPoints Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace SnapPoints\Loyalty\Cron;

use Psr\Log\LoggerInterface;

class UpdateRates
{

    /**
     * Constructor
     *
     * @param LoggerInterface $logger
     */
    public function __construct(private LoggerInterface $logger)
    {

    }

    /**
     * Execute the cron
     *
     * @return void
     */
    public function execute(): void
    {
        $this->logger->info("Cronjob Update Rates is executed.");
    }
}

