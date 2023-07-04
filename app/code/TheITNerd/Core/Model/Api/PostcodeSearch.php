<?php

namespace TheITNerd\Core\Model\Api;

use Magento\Framework\App\Request\Http;
use Magento\Framework\Exception\LocalizedException;
use TheITNerd\Core\Model\DataObjects\AddressObjectFactory;
use TheITNerd\Core\Api\Objects\AddressObjectInterface;
use TheITNerd\Core\Api\PostcodeSearchInterface;
use TheITNerd\Core\Model\Adapters\PostcodeClientAdapter;

/**
 * Class PostcodeSearch
 * @package TheITNerd\Core\Model\Api
 */
class PostcodeSearch implements PostcodeSearchInterface
{

    /**
     * @param Http $request
     * @param PostcodeClientAdapter $adapter
     * @param AddressObjectFactory $addressObjectFactory
     */
    public function __construct(
        private readonly Http                  $request,
        private readonly PostcodeClientAdapter $adapter,
        private readonly AddressObjectFactory  $addressObjectFactory
    )
    {
    }

    /**
     * {@inheritdoc}
     * @throws LocalizedException
     */
    public function searchAddress(): array
    {
        if (!$this->request->has('postcode')) {
            throw new LocalizedException(__('Please inform the postcode'));
        }

        $address = $this->adapter->searchAddress($this->request->getParam('postcode'));

        if (!$address instanceof AddressObjectInterface) {
            throw new LocalizedException(__('Something went wrong, please check the provided information and try again'));
        }

        return [$address->toArray()];

    }

    /**
     * {@inheritdoc}
     * @throws LocalizedException
     */
    public function searchPostcode(): array
    {
        $errors = [];
        if (!$this->request->has('region')) {
            $errors[] = __('region');
        }

        if (!$this->request->has('city')) {
            $errors[] = __('city');
        }

        if (!$this->request->has('street')) {
            $errors[] = __('street');
        }

        if (!empty($errors)) {
            throw new LocalizedException(__('Please inform the required parameters: %1', implode(',  ', $errors)));
        }

        $addressObject = $this->addressObjectFactory->create()
            ->setRegionCode($this->request->getParam('region'))
            ->setCity($this->request->getParam('city'))
            ->setStreet($this->request->getParam('street'));

        $data = $this->adapter->searchPostcode($addressObject);

        if (!is_null($data)) {
            return [$data];
        }

        throw new LocalizedException(__('Something went wrong, please check the provided information and try again'));
    }
}
