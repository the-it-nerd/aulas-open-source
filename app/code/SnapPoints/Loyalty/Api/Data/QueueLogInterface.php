<?php
/**
 * Copyright © SnapPoints Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace SnapPoints\Loyalty\Api\Data;

interface QueueLogInterface
{

    public const QUEUE_LOG_ID = 'queue_log_id';
    public const QUEUE = 'queue';
    public const STATUS = 'status';
    public const LOG = 'log';
    public const OBJECTS = 'objects';

    /**
     * Get queue_log_id
     * @return int|null
     */
    public function getQueueLogId(): ?int;

    /**
     * Set queue_log_id
     * @param int $queueLogId
     * @return self
     */
    public function setQueueLogId(int $queueLogId): self;

    /**
     * Get queue
     * @return string|null
     */
    public function getQueue(): ?string;

    /**
     * Set queue
     * @param string $queue
     * @return self
     */
    public function setQueue(string $queue): self;

    /**
     * Get objects
     * @return string|null
     */
    public function getObjects(): ?string;

    /**
     * Set objects
     * @param string $objects
     * @return self
     */
    public function setObjects(string $objects): self;

    /**
     * Get status
     * @return string|null
     */
    public function getStatus(): ?string;

    /**
     * Set status
     * @param string $status
     * @return self
     */
    public function setStatus(string $status): self;

    /**
     * Get log
     * @return string|null
     */
    public function getLog(): ?string;

    /**
     * Set log
     * @param string $log
     * @return self
     */
    public function setLog(string $log): self;
}

