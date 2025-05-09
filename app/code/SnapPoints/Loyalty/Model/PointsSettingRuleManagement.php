<?php

namespace SnapPoints\Loyalty\Model;

use SnapPoints\Loyalty\Api\PointsSettingRuleManagementInterface;
use SnapPoints\Loyalty\Model\ResourceModel\PointsSettingRule\CollectionFactory;
use Snappoints\Sdk\DataObjects\Collection\PointsSettingRuleCollection;
use Snappoints\Sdk\DataObjects\Collection\ProductCollection;
use Snappoints\Sdk\DataObjects\Entities\Product;
use Snappoints\Sdk\DataObjects\Interfaces\Collections\PointsSettingRuleCollectionInterface;

class PointsSettingRuleManagement implements PointsSettingRuleManagementInterface
{

    /**
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        protected readonly CollectionFactory $collectionFactory
    )
    {

    }

    /**
     * @inheritDoc
     */
    public function getRules(): array
    {
        $collection = new PointsSettingRuleCollection();
        $rules = $this->collectionFactory->create()->addFieldToFilter('status', 'active');

        foreach ($rules->load() as $rule) {
            /**
             * @var $rule PointsSettingRule
             */

            $includes = new ProductCollection();
            foreach ($rule->getInclude() as $include) {
                $includes->add(new Product()
                    ->setId($include)
                    ->setName($include));
            }

            $excludes = new ProductCollection();
            foreach ($rule->getExclude() as $exclude) {
                $excludes->add(new Product()
                    ->setId($exclude)
                    ->setName($exclude));
            }

            $object = new \Snappoints\Sdk\DataObjects\Entities\PointsSettingRule()
                ->setStatus($rule->getStatus())
                ->setId($rule->getExternalId())
                ->setName($rule->getName())
                ->setApplicableTo($rule->getApplicableTo())
                ->setVersion($rule->getVersion())
                ->setCreatedAt($rule->getCreatedAt())
                ->setUpdatedAt($rule->getUpdatedAt())
                ->setGiveBackRatio($rule->getGiveBackRatio())
                ->setExclude($excludes)
                ->setInclude($includes)
                ->setProcessingDays($rule->getProcessingDays());

            $collection->add($object);

        }

        return $collection->toArray();
    }
}
