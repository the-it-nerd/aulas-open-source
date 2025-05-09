<?php

namespace SnapPoints\Loyalty\Model;

use DateTime;
use Magento\Framework\Model\AbstractModel;
use SnapPoints\Loyalty\Api\Data\PointsSettingRuleInterface;

class PointsSettingRule extends AbstractModel implements PointsSettingRuleInterface
{

    /**
     * @inheritDoc
     */
    public function _construct()
    {
        $this->_init(ResourceModel\PointsSettingRule::class);
    }

    /**
     * @inheritDoc
     */
    public function getExternalId(): ?string
    {
        return $this->getData(self::EXTERNAL_ID);
    }

    /**
     * @inheritDoc
     */
    public function setExternalId(string $value): PointsSettingRuleInterface
    {
        return $this->setData(self::EXTERNAL_ID, $value);
    }

    /**
     * @inheritDoc
     */
    public function getName(): ?string
    {
        return $this->getData(self::NAME);
    }

    /**
     * @inheritDoc
     */
    public function setName(string $value): PointsSettingRuleInterface
    {
        return $this->setData(self::NAME, $value);
    }

    /**
     * @inheritDoc
     */
    public function getGiveBackRatio(): ?float
    {
        return $this->getData(self::GIVE_BACK_RATIO);
    }

    /**
     * @inheritDoc
     */
    public function setGiveBackRatio(float $value): PointsSettingRuleInterface
    {
        return $this->setData(self::GIVE_BACK_RATIO, $value);
    }

    /**
     * @inheritDoc
     */
    public function getFromDate(): ?DateTime
    {
        $value = $this->getData(self::FROM_DATE);
        if ($value) {
            $value = new DateTime($value);
        }
        return $value;
    }

    /**
     * @inheritDoc
     */
    public function setFromDate(DateTime $value): PointsSettingRuleInterface
    {
        return $this->setData(self::FROM_DATE, $value);
    }

    /**
     * @inheritDoc
     */
    public function getProcessingDays(): ?int
    {
        return $this->getData(self::PROCESSING_DAYS);
    }

    /**
     * @inheritDoc
     */
    public function setProcessingDays(int $value): PointsSettingRuleInterface
    {
        return $this->setData(self::PROCESSING_DAYS, $value);
    }

    /**
     * @inheritDoc
     */
    public function getInclude(): ?array
    {
        $value = $this->getData(self::INCLUDE);
        if (!is_null($value)) {
            $value = json_decode($value, true);
        }
        return $value;
    }

    /**
     * @inheritDoc
     */
    public function setInclude(array $value): PointsSettingRuleInterface
    {
        return $this->setData(self::INCLUDE, json_encode($value));
    }

    /**
     * @inheritDoc
     */
    public function getExclude(): ?array
    {
        $value = $this->getData(self::EXCLUDE);
        if (!is_null($value)) {
            $value = json_decode($value, true);
        }
        return $value;
    }

    /**
     * @inheritDoc
     */
    public function setExclude(array $value): PointsSettingRuleInterface
    {
        return $this->setData(self::EXCLUDE, json_encode($value));
    }

    /**
     * @inheritDoc
     */
    public function getApplicableTo(): ?string
    {
        return $this->getData(self::APPLICABLE_TO);
    }

    /**
     * @inheritDoc
     */
    public function setApplicableTo(string $value): PointsSettingRuleInterface
    {
        return $this->setData(self::APPLICABLE_TO, $value);
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
    public function setStatus(string $value): PointsSettingRuleInterface
    {
        return $this->setData(self::STATUS, $value);
    }

    /**
     * @inheritDoc
     */
    public function getVersion(): ?int
    {
        return $this->getData(self::VERSION);
    }

    /**
     * @inheritDoc
     */
    public function setVersion(int $value): PointsSettingRuleInterface
    {
        return $this->setData(self::VERSION, $value);
    }

    /**
     * @inheritDoc
     */
    public function getCreatedAt(): ?DateTime
    {
        $value = $this->getData(self::CREATED_AT);
        if ($value) {
            $value = new DateTime($value);
        }
        return $value;
    }

    /**
     * @inheritDoc
     */
    public function setCreatedAt(DateTime $value): PointsSettingRuleInterface
    {
        return $this->setData(self::CREATED_AT, $value);
    }

    /**
     * @inheritDoc
     */
    public function getUpdatedAt(): ?DateTime
    {
        $value = $this->getData(self::UPDATED_AT);
        if ($value) {
            $value = new DateTime($value);
        }
        return $value;
    }

    /**
     * @inheritDoc
     */
    public function setUpdatedAt(DateTime $value): PointsSettingRuleInterface
    {
        return $this->setData(self::UPDATED_AT, $value);
    }

    /**
     * @inheritDoc
     */
    public function setWebsiteId(int $value): PointsSettingRuleInterface
    {
        return $this->setData(self::WEBSITE_ID, $value);
    }

    /**
     * @inheritDoc
     */
    public function getWebsiteId(): ?int
    {
        return $this->getData(self::WEBSITE_ID);
    }
}
