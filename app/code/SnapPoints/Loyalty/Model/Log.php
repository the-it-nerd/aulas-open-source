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
        $this->_init(\SnapPoints\Loyalty\Model\ResourceModel\Log::class);
    }

    /**
     * @inheritDoc
     */
    public function getLogId()
    {
        return $this->getData(self::LOG_ID);
    }

    /**
     * @inheritDoc
     */
    public function setLogId($logId)
    {
        return $this->setData(self::LOG_ID, $logId);
    }

    /**
     * @inheritDoc
     */
    public function getLogStack()
    {
        return $this->getData(self::LOG_STACK);
    }

    /**
     * @inheritDoc
     */
    public function setLogStack($logStack)
    {
        return $this->setData(self::LOG_STACK, $logStack);
    }

    /**
     * @inheritDoc
     */
    public function getClass()
    {
        return $this->getData(self::CLASS);
    }

    /**
     * @inheritDoc
     */
    public function setClass($class)
    {
        return $this->setData(self::CLASS, $class);
    }

    /**
     * @inheritDoc
     */
    public function getLog()
    {
        return $this->getData(self::LOG);
    }

    /**
     * @inheritDoc
     */
    public function setLog($log)
    {
        return $this->setData(self::LOG, $log);
    }

    /**
     * @inheritDoc
     */
    public function getLogType()
    {
        return $this->getData(self::LOG_TYPE);
    }

    /**
     * @inheritDoc
     */
    public function setLogType($logType)
    {
        return $this->setData(self::LOG_TYPE, $logType);
    }
}

