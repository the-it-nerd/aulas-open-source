<?php

namespace TheITNerd\Brasil\Model\Clients\ViaCEP;

use Magento\Framework\HTTP\Client\Curl;
use TheITNerd\Brasil\Api\Adapters\PostcodeClientInterface;
use TheITNerd\Brasil\Api\Objects\AddressObjectInterface;
use TheITNerd\Brasil\Model\DataObjects\AddressObjectFactory;

class ViaCEPClient implements PostcodeClientInterface
{
    public const API_URL = "https://viacep.com.br/ws/";

    public const API_ADDRESS_ENDPOINT = "{postcode}/json/";
    public const API_POSTCODE_ENDPOINT = "{region}/{city}/{street}/json/";

    /**
     * @var Curl
     */
    private Curl $httpClient;

    /**
     * @var AddressObjectFactory
     */
    private AddressObjectFactory $addressObjectFactory;

    /**
     * @param Curl $httpClient
     * @param AddressObjectFactory $addressObjectFactory
     */
    public function __construct(
        Curl                 $httpClient,
        AddressObjectFactory $addressObjectFactory
    )
    {
        $this->httpClient = $httpClient;
        $this->addressObjectFactory = $addressObjectFactory;
    }

    /**
     * @inheritDoc
     */
    public function getLabel(): string
    {
        return 'ViaCEP Client - Brasil only';
    }

    /**
     * @inheritDoc
     */
    public function searchAddress(string $postcode): AddressObjectInterface|null
    {
        $url = str_replace('{postcode}', rawurlencode($postcode), self::API_URL . self::API_ADDRESS_ENDPOINT);
        $this->httpClient->get($url);

        return $this->viaCEPAddressToDataObject(json_decode($this->httpClient->getBody(), true));
    }

    /**
     * @inheritDoc
     */
    public function searchPostcode(AddressObjectInterface $addressObject): array
    {
        $url = str_replace(['{region}','{city}','{street}'], [rawurlencode($addressObject->getRegionCode()), rawurlencode($addressObject->getCity()), rawurlencode($addressObject->getStreet())], self::API_URL . self::API_POSTCODE_ENDPOINT);
        try {
            $this->httpClient->get($url);
            $objects = [];

            foreach(json_decode($this->httpClient->getBody(), true) as $address) {
                $objects[] = $this->viaCEPAddressToDataObject($address)->toArray();
            }
            return $objects;
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * @param array $data
     * @return AddressObjectInterface
     */
    protected function viaCEPAddressToDataObject(array $data): AddressObjectInterface
    {
        return $this->addressObjectFactory->create()
            ->setCity($data['localidade'] ?? null)
            ->setCallingCode($data['ddd'] ?? null)
            ->setComplement($data['complemento'] ?? null)
            ->setNeighborhood($data['bairro'] ?? null)
            ->setStreet($data['logradouro'] ?? null)
            ->setCityCode($data['ibge'] ?? null)
            ->setPostcode($data['cep'] ?? null)
            ->setRegionCode($data['uf'] ?? null)
            ->setCountry('BR');

    }
}
