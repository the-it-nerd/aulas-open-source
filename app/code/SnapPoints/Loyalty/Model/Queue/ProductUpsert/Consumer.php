<?php

namespace SnapPoints\Loyalty\Model\Queue\ProductUpsert;

use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Model\ProductRepository;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;
use SnapPoints\Loyalty\Model\Queue\ProductUpsert\ProductRequest\Builder;
use SnapPoints\Loyalty\Model\SDK\BaseSDKFactory;
use Snappoints\Sdk\Client\Merchant\Product\Product;

class Consumer
{

    /**
     * @var Product
     */
    private Product $productSDK;

    /**
     * @param ProductRepository $productRepository
     * @param BaseSDKFactory $baseSDKFactory
     * @param StoreManagerInterface $storeManager
     * @param Builder $dataBuilder
     */
    public function __construct(
        protected readonly ProductRepository     $productRepository,
        protected readonly BaseSDKFactory        $baseSDKFactory,
        protected readonly StoreManagerInterface $storeManager,
        protected readonly Builder $dataBuilder
    )
    {
        $this->productSDK = $this->baseSDKFactory->create()->getProductSDK();
    }

    /**
     * Processes a product by iterating through all stores and performing operations related to the product.
     *
     * @param int $productId The ID of the product to be processed.
     * @throws GuzzleException
     */
    public function process($productId)
    {
        foreach ($this->storeManager->getStores() as $store) {
            $storeId = $store->getId();
            $this->storeManager->setCurrentStore($storeId);

            try {
                $product = $this->productRepository->getById($productId, false, $storeId);
                $this->upsertProduct($product);
            } catch (NoSuchEntityException $e) {
                $this->deleteProduct($productId);
            }
        }
    }

    /**
     * @param ProductInterface $product
     * @return $this
     */
    protected function upsertProduct(ProductInterface $product): self
    {
        $productModel = $this->dataBuilder->process($product);

        try {
            $this->productSDK->createProduct($productModel);
        } catch (GuzzleException $e) {
            //TODO: log queue exception here
        } catch (Exception $e) {
            //TODO: log queue exception here
        }

        return $this;

    }

    /**
     * Deletes a product by its ID.
     *
     * @param string $productId The ID of the product to be deleted.
     * @return self The current instance after deletion.
     * @throws GuzzleException
     */
    protected function deleteProduct(string $productId): self
    {
        $this->productSDK->deleteProduct($productId);
        return $this;
    }
}
