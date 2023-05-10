<?php

namespace TheITNerd\Brasil\Model\Api;

use Magento\Framework\Exception\LocalizedException;
use TheITNerd\Brasil\Api\PostcodeSearchInterface;
use Magento\Framework\App\Request\Http;
use TheITNerd\Brasil\Model\Adapters\PostcodeClientAdapter;
use TheITNerd\Brasil\Model\DataObjects\AddressObjectFactory;

class PostcodeSearch implements PostcodeSearchInterface
{

    /**
     * @var Http
     */
    private Http $request;

    /**
     * @var PostcodeClientAdapter
     */
    private PostcodeClientAdapter $adapter;

    /**
     * @var AddressObjectFactory
     */
    private AddressObjectFactory $addressObjectFactory;

    /**
     * @param Http $request
     * @param PostcodeClientAdapter $adapter
     * @param AddressObjectFactory $addressObjectFactory
     */
    public function __construct(
        Http                  $request,
        PostcodeClientAdapter $adapter,
        AddressObjectFactory  $addressObjectFactory
    )
    {
        $this->request = $request;
        $this->adapter = $adapter;
        $this->addressObjectFactory = $addressObjectFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function searchAddress(): array
    {
        if (!$this->request->has('postcode')) {
            throw new LocalizedException(__('Please inform the postcode'));
        }

        return [$this->adapter->searchAddress($this->request->getParam('postcode'))->toArray()];

    }

    /**
     * {@inheritdoc}
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

        return [$this->adapter->searchPostcode($addressObject)];

    }
}
