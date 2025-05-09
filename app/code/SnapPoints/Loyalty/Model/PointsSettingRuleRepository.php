<?php

namespace SnapPoints\Loyalty\Model;


use Exception;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use SnapPoints\Loyalty\Api\Data\PointsSettingRuleInterface;
use SnapPoints\Loyalty\Api\Data\PointsSettingRuleInterfaceFactory;
use SnapPoints\Loyalty\Api\Data\PointsSettingRuleSearchResultsInterface;
use SnapPoints\Loyalty\Api\Data\PointsSettingRuleSearchResultsInterfaceFactory;
use SnapPoints\Loyalty\Api\PointsSettingRuleRepositoryInterface;
use SnapPoints\Loyalty\Model\ResourceModel\PointsSettingRule as ResourcePointsSettingRule;
use SnapPoints\Loyalty\Model\ResourceModel\PointsSettingRule\CollectionFactory as PointsSettingRuleCollectionFactory;


class PointsSettingRuleRepository implements PointsSettingRuleRepositoryInterface
{
    /**
     * @param ResourcePointsSettingRule $resource
     * @param PointsSettingRuleInterfaceFactory $pointsSettingRuleFactory
     * @param PointsSettingRuleCollectionFactory $pointsSettingRuleCollectionFactory
     * @param PointsSettingRuleSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        protected readonly ResourcePointsSettingRule                      $resource,
        protected readonly PointsSettingRuleInterfaceFactory              $pointsSettingRuleFactory,
        protected readonly PointsSettingRuleCollectionFactory             $pointsSettingRuleCollectionFactory,
        protected readonly PointsSettingRuleSearchResultsInterfaceFactory $searchResultsFactory,
        protected readonly CollectionProcessorInterface                   $collectionProcessor
    )
    {
    }

    /**
     * @inheritDoc
     */
    public function getList(
        SearchCriteriaInterface $criteria
    ): PointsSettingRuleSearchResultsInterface
    {
        $collection = $this->pointsSettingRuleCollectionFactory->create();

        $this->collectionProcessor->process($criteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $items = [];
        foreach ($collection as $model) {
            $items[] = $model;
        }

        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * @inheritDoc
     */
    public function deleteById($pointsSettingRuleId): bool
    {
        return $this->delete($this->get($pointsSettingRuleId));
    }

    /**
     * @inheritDoc
     */
    public function delete(PointsSettingRuleInterface $pointsSettingRule): bool
    {
        try {
            $pointsSettingRuleModel = $this->pointsSettingRuleFactory->create();
            $this->resource->load($pointsSettingRuleModel, $pointsSettingRule->getEntityId());
            $this->resource->delete($pointsSettingRuleModel);
        } catch (Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the rule: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function get($pointsSettingRuleId): PointsSettingRuleInterface
    {
        $pointsSettingRule = $this->pointsSettingRuleFactory->create();
        $this->resource->load($pointsSettingRule, $pointsSettingRuleId);
        if (!$pointsSettingRule->getId()) {
            throw new NoSuchEntityException(__('rule with id "%1" does not exist.', $pointsSettingRuleId));
        }
        return $pointsSettingRule;
    }

    /**
     * @inheritDoc
     */
    public function upsertRule(\Snappoints\Sdk\DataObjects\Interfaces\Objects\PointsSettingRuleInterface $pointsSettingRule,  \Magento\Store\Api\Data\WebsiteInterface $website): PointsSettingRuleInterface
    {
        try {
            $DBModel = $this->getByExternalId($pointsSettingRule->getId());
        } catch (NoSuchEntityException $e) {
            $DBModel = $this->pointsSettingRuleFactory->create();
        }

        $includes = [];
        foreach ($pointsSettingRule->getInclude() as $include) {
            $include = $include->toArray();
            $includes[] = [$include['id']];
            $includes[] = array_column($include['variants'], 'id');
        }
        if(count($includes) > 0) {
            $includes = array_values(array_unique(array_merge(...$includes)));
        }

        $excludes = [];
        foreach ($pointsSettingRule->getExclude() as $exclude) {
            $exclude = $exclude->toArray();
            $excludes[] = [$exclude['id']];
            $excludes[] = array_column($exclude['variants'], 'id');
            $excludes[] = array_column($exclude->toArray(), 'id');
        }
        if(count($excludes) > 0) {
            $excludes = array_values(array_unique(array_merge(...$excludes)));
        }

        // Map all available fields from SDK to database entity
        $DBModel->setExternalId($pointsSettingRule->getId())
            ->setName($pointsSettingRule->getName())
            ->setVersion($pointsSettingRule->getVersion())
            ->setGiveBackRatio($pointsSettingRule->getGiveBackRatio())
            ->setFromDate($pointsSettingRule->getFromDate())
            ->setProcessingDays($pointsSettingRule->getProcessingDays())
            ->setInclude($includes)
            ->setExclude($excludes)
            ->setStatus($pointsSettingRule->getStatus())
            ->setApplicableTo($pointsSettingRule->getApplicableTo())
            ->setWebsiteId($website->getId());

        // Save the mapped entity
        try {
            $this->save($DBModel);
        } catch (CouldNotSaveException $e) {
            throw new CouldNotSaveException(__(
                'Could not save rule data from SDK: %1',
                $e->getMessage()
            ));
        }

        return $DBModel;
    }

    /**
     * @param string $id
     * @return PointsSettingRuleInterface
     * @throws NoSuchEntityException
     */
    public function getByExternalId(string $id): PointsSettingRuleInterface
    {

        $pointsSettingRule = $this->pointsSettingRuleFactory->create();
        $this->resource->load($pointsSettingRule, $id, 'external_id');

        if (!$pointsSettingRule->getId()) {
            throw new NoSuchEntityException(__('Points Setting Rule with external ID "%1" does not exist.', $id));
        }

        return $pointsSettingRule;
    }

    /**
     * @inheritDoc
     */
    public function save(PointsSettingRuleInterface $pointsSettingRule): PointsSettingRuleInterface
    {
        try {
            $this->resource->save($pointsSettingRule);
        } catch (Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the rule: %1',
                $exception->getMessage()
            ));
        }
        return $pointsSettingRule;
    }
}


