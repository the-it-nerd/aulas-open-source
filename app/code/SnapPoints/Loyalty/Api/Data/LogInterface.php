<?php
/**
 * Copyright © SnapPoints Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace SnapPoints\Loyalty\Api\Data;

interface LogInterface
{

    public const CLASS_NAME = 'class_name';
    public const LOG_STACK = 'log_stack';
    public const LOG_ID = 'log_id';
    public const LOG = 'log';
    public const LOG_TYPE = 'log_type';

    /**
     * Get log_id
     * @return string|null
     */
    public function getLogId(): ?string;

    /**
     * Set log_id
     * @param int $logId
     * @return self
     */
    public function setLogId(int $logId): self;

    /**
     * Get log_stack
     * @return string|null
     */
    public function getLogStack(): ?string;

    /**
     * Set log_stack
     * @param string $logStack
     * @return self
     */
    public function setLogStack(string $logStack): self;

    /**
     * Get class
     * @return string|null
     */
    public function getClass(): ?string;

    /**
     * Set class
     * @param string $class
     * @return self
     */
    public function setClass(string $class): self;

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

    /**
     * Get log_type
     * @return string|null
     */
    public function getLogType(): ?string;

    /**
     * Set log_type
     * @param string $logType
     * @return self
     */
    public function setLogType(string $logType): self;
}

