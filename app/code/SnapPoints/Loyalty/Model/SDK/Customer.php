<?php

namespace SnapPoints\Loyalty\Model\SDK;


class Customer extends BaseSDK
{


    public function getCustomerByOrder(\Magento\Sales\Model\Order $order): \Snappoints\Sdk\DataObjects\Interfaces\Objects\CustomerInterface
    {
        $customer = new \Snappoints\Sdk\DataObjects\Entities\Customer()
            ->setExternalId($order->getCustomerEmail())
            ->setEmail($order->getCustomerEmail())
            ->setFirstName($order->getCustomerFirstname())
            ->setLastName($order->getCustomerLastname());

        return $this->getCustomerSDK()->upsertCustomer($customer);

    }
}
