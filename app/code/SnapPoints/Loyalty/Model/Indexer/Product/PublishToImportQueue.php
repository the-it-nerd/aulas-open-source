<?php

namespace SnapPoints\Loyalty\Model\Indexer\Product;


use Magento\Catalog\Model\Product\Visibility;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\Indexer\ActionInterface as IndexerActionInterface;
use Magento\Framework\Mview\ActionInterface as MviewActionInterface;
use SnapPoints\Loyalty\Model\Queue\ProductUpsert\Publisher;

class PublishToImportQueue implements IndexerActionInterface, MviewActionInterface
{

    /**
     * @param Publisher $publisher
     * @param CollectionFactory $productCollectionFactory
     */
    public function __construct(
        protected readonly Publisher         $publisher,
        protected readonly CollectionFactory $productCollectionFactory,
    )
    {
    }

    /**
     * @param $ids
     * @return void
     */
    public function execute($ids)
    {
        if (is_array($ids)) {
            $this->executeList($ids);
        } else {
            $this->executeRow($ids);
        }
    }

    /**
     * Executes the list of products.
     *
     * @param array $ids An array of product identifiers.
     */

    public function executeList(array $ids)
    {
        foreach ($ids as $id) {
            $this->publishProduct((int)$id);
        }
    }

    /**
     * Publishes a product by its ID.
     *
     * @param int $entityId The identifier of the product to be published.
     * @return void
     */
    protected function publishProduct(int $entityId)
    {
        $this->publisher->publishProductById($entityId);
    }

    /**
     * Executes a single product row.
     *
     * @param mixed $id The product identifier. It should be cast to an integer.
     */
    public function executeRow($id)
    {
        $this->publishProduct((int)$id);
    }

    /**
     * Executes a full process to publish all products in the collection that are visible.
     *
     * @return void
     */
    public function executeFull()
    {
        $collection = $this->productCollectionFactory->create()
            ->addAttributeToFilter('visibility', ['neq' => Visibility::VISIBILITY_NOT_VISIBLE]);

        foreach ($collection as $product) {
            $this->publishProduct((int)$product->getId());
        }
    }
}
