<?php

namespace TheITNerd\UX\Model\Api;


use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Model\ProductRepository;
use Magento\Framework\App\Request\Http;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Pricing\Helper\Data;
use Magento\Quote\Model\Quote\TotalsCollector;
use Magento\Quote\Model\QuoteFactory;
use TheITNerd\Core\Model\Adapters\PostcodeClientAdapter;
use TheITNerd\UX\Api\PDPEstimateShippingMethodsInterface;

/**
 * Class PDPEstimateShippingMethods
 * @package TheITNerd\UX\Model\Api
 */
class PDPEstimateShippingMethods implements PDPEstimateShippingMethodsInterface
{

    /***
     * @var ProductInterface
     * @noinspection PhpMissingFieldTypeInspection
     */
    private $product;

    /**
     * @param Http $request
     * @param QuoteFactory $quoteFactory
     * @param TotalsCollector $totalsCollector
     * @param ProductRepository $productRepository
     * @param Data $priceHelper
     * @param PostcodeClientAdapter $postcodeClientAdapter
     */
    public function __construct(
        private readonly Http                  $request,
        private readonly QuoteFactory          $quoteFactory,
        private readonly TotalsCollector       $totalsCollector,
        private readonly ProductRepository     $productRepository,
        private readonly Data                  $priceHelper,
        private readonly PostcodeClientAdapter $postcodeClientAdapter
    )
    {

    }

    /**
     * @inheritDoc
     */
    public function estimateShippingMethods(): array
    {
        if (!$this->validateRequest()) {
            throw new LocalizedException(__('Please provide a valid postcode and product.'));
        }

        $cart = $this->quoteFactory->create();
        $cart->addProduct($this->getProduct(), $this->getAddToCartParams());

        $address = $this->postcodeClientAdapter->searchAddress($this->request->getParam('postcode'));

        if (is_null($address)) {
            throw new LocalizedException(__('Please provide a valid postcode.'));
        }

        $cart->getShippingAddress()->setCountryId($address->getCountry() ?? '');
        $cart->getShippingAddress()->setPostcode($address->getPostcode() ?? '');

        $shippingAddress = $cart->getShippingAddress();
        $shippingAddress->setCollectShippingRates(true);

        $this->totalsCollector->collectAddressTotals($cart, $shippingAddress);

        $shippingRates = $shippingAddress->getGroupedAllShippingRates();

        $data = [];

        foreach ($shippingRates as $shippingRate) {
            $data[] = [
                'carrier' => $shippingRate[0]->getCarrierTitle(),
                'method' => $shippingRate[0]->getMethodTitle(),
                'price' => $this->priceHelper->currency($shippingRate[0]->getPrice(), true, false)
            ];
        }

        return $data;
    }

    /**
     * @return bool
     */
    private function validateRequest(): bool
    {
        return (
            $this->request->has('product')
            && $this->request->has('postcode')
        );
    }

    /**
     * @return ProductInterface
     * @throws NoSuchEntityException
     */
    private function getProduct(): ProductInterface
    {
        if (!$this->product) {
            $this->product = $this->productRepository->getById($this->request->getParam('product'));
        }

        return $this->product;
    }

    /**
     * @return DataObject
     */
    private function getAddToCartParams(): DataObject
    {
        return new DataObject($this->request->getParams());
    }
}
