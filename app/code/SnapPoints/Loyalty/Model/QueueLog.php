<?php
/**
 * Copyright © SnapPoints Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace SnapPoints\Loyalty\Model;

use Magento\Framework\Model\AbstractModel;
use SnapPoints\Loyalty\Api\Data\QueueLogInterface;

class QueueLog extends AbstractModel implements QueueLogInterface
{

    /**
     * @inheritDoc
     */
    public function _construct()
    {
        $this->_init(ResourceModel\QueueLog::class);
    }

    /**
     * @inheritDoc
     */
    public function getQueueLogId(): ?int
    {
        return $this->getData(self::QUEUE_LOG_ID);
    }

    /**
     * @inheritDoc
     */
    public function setQueueLogId($queueLogId): QueueLogInterface
    {
        return $this->setData(self::QUEUE_LOG_ID, $queueLogId);
    }

    /**
     * @inheritDoc
     */
    public function getQueue(): ?string
    {
        return $this->getData(self::QUEUE);
    }

    /**
     * @inheritDoc
     */
    public function setQueue($queue): QueueLogInterface
    {
        return $this->setData(self::QUEUE, $queue);
    }

    /**
     * @inheritDoc
     */
    public function getObjects(): ?string
    {
        return $this->getData(self::OBJECTS);
    }

    /**
     * @inheritDoc
     */
    public function setObjects($objects): QueueLogInterface
    {
        return $this->setData(self::OBJECTS, $objects);
    }

    /**
     * @inheritDoc
     */
    public function getStatus(): ?string
    {
        return $this->getData(self::STATUS);
    }

    /**
     * @inheritDoc
     */
    public function setStatus($status): QueueLogInterface
    {
        return $this->setData(self::STATUS, $status);
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
    public function setLog($log): QueueLogInterface
    {
        return $this->setData(self::LOG, $log);
    }
}

