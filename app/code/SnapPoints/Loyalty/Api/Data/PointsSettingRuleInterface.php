<?php

namespace SnapPoints\Loyalty\Api\Data;

interface PointsSettingRuleInterface
{
    public const ENTITY_ID = 'entity_id';
    public const EXTERNAL_ID = 'external_id';
    public const NAME = 'name';
    public const GIVE_BACK_RATIO = 'give_back_ratio';
    public const FROM_DATE = 'from_date';
    public const PROCESSING_DAYS = 'processing_days';
    public const INCLUDE = 'include';
    public const EXCLUDE = 'exclude';
    public const APPLICABLE_TO = 'applicable_to';
    public const WEBSITE_ID = 'website_id';
    public const STATUS = 'status';
    public const VERSION = 'version';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';



    /**
     * @return string|null
     */
    public function getExternalId(): ?string;

    /**
     * @param string $value
     * @return self
     */
    public function setExternalId(string $value): self;

    /**
     * @return string|null
     */
    public function getName(): ?string;

    /**
     * @param string $value
     * @return self
     */
    public function setName(string $value): self;

    /**
     * @return float|null
     */
    public function getGiveBackRatio(): ?float;

    /**
     * @param float $value
     * @return self
     */
    public function setGiveBackRatio(float $value): self;

    /**
     * @return \DateTime|null
     */
    public function getFromDate(): ?\DateTime;

    /**
     * @param \DateTime $value
     * @return self
     */
    public function setFromDate(\DateTime $value): self;

    /**
     * @return int|null
     */
    public function getProcessingDays(): ?int;

    /**
     * @param int $value
     * @return self
     */
    public function setProcessingDays(int $value): self;

    /**
     * @return array|null
     */
    public function getInclude(): ?array;

    /**
     * @param array $value
     * @return self
     */
    public function setInclude(array $value): self;

    /**
     * @return array|null
     */
    public function getExclude(): ?array;

    /**
     * @param array $value
     * @return self
     */
    public function setExclude(array $value): self;

    /**
     * @return string|null
     */
    public function getApplicableTo(): ?string;

    /**
     * @param string $value
     * @return self
     */
    public function setApplicableTo(string $value): self;

    /**
     * @return string|null
     */
    public function getStatus(): ?string;

    /**
     * @param string $value
     * @return self
     */
    public function setStatus(string $value): self;

    /**
     * @return int|null
     */
    public function getVersion(): ?int;

    /**
     * @param int $value
     * @return self
     */
    public function setVersion(int $value): self;

    /**
     * @return \DateTime|null
     */
    public function getCreatedAt(): ?\DateTime;

    /**
     * @param \DateTime $value
     * @return self
     */
    public function setCreatedAt(\DateTime $value): self;

    /**
     * @return \DateTime|null
     */
    public function getUpdatedAt(): ?\DateTime;

    /**
     * @param \DateTime $value
     * @return self
     */
    public function setUpdatedAt(\DateTime $value): self;


    /**
     * @param int $value
     * @return self
     */
    public function setWebsiteId(int $value): self;

    /**
     * @return int|null
     */
    public function getWebsiteId(): ?int;
}
