<?php
/**
 * Copyright © SnapPoints Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace SnapPoints\Loyalty\Model;

use Magento\Framework\Model\AbstractModel;
use SnapPoints\Loyalty\Api\Data\LogInterface;

class Log extends AbstractModel implements LogInterface
{

    /**
     * @inheritDoc
     */
    public function _construct()
    {
        $this->_init(ResourceModel\Log::class);
    }

    /**
     * @inheritDoc
     */
    public function getLogId(): ?string
    {
        return $this->getData(self::LOG_ID);
    }

    /**
     * @inheritDoc
     */
    public function setLogId($logId): LogInterface
    {
        return $this->setData(self::LOG_ID, $logId);
    }

    /**
     * @inheritDoc
     */
    public function getLogStack(): ?string
    {
        return $this->getData(self::LOG_STACK);
    }

    /**
     * @inheritDoc
     */
    public function setLogStack($logStack): LogInterface
    {
        return $this->setData(self::LOG_STACK, $logStack);
    }

    /**
     * @inheritDoc
     */
    public function getClass(): ?string
    {
        return $this->getData(self::CLASS_NAME);
    }

    /**
     * @inheritDoc
     */
    public function setClass($class): LogInterface
    {
        return $this->setData(self::CLASS_NAME, $class);
    }

    /**
     * @inheritDoc
     */
    public function getLog(): ?string
    {
        return $this->getData(self::LOG);
    }

    /**
     * @inheritDoc
     */
    public function setLog($log): LogInterface
    {
        return $this->setData(self::LOG, $log);
    }

    /**
     * @inheritDoc
     */
    public function getLogType(): ?string
    {
        return $this->getData(self::LOG_TYPE);
    }

    /**
     * @inheritDoc
     */
    public function setLogType($logType): LogInterface
    {
        return $this->setData(self::LOG_TYPE, $logType);
    }
}

