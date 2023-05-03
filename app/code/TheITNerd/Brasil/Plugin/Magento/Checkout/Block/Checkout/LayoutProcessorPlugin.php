<?php

namespace TheITNerd\Brasil\Plugin\Magento\Checkout\Block\Checkout;

use Magento\Checkout\Block\Checkout\LayoutProcessor;

class LayoutProcessorPlugin
{
    /**
     * @param LayoutProcessor $subject
     * @param array $jsLayout
     * @return array
     */
    public function afterProcess(
        LayoutProcessor $subject,
        array           $jsLayout
    )
    {

        //Change shipping address fields
        $this->changeAddressFormInputTemplates($jsLayout['components']["checkout"]["children"]["steps"]["children"]["shipping-step"]["children"]["shippingAddress"]["children"]["shipping-address-fieldset"]["children"]);

        //change payment method billing address fields
        foreach ($jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']['payment']['children']['payments-list']['children'] as &$paymentMethod) {
            if (isset($paymentMethod['children']['form-fields']['children'])) {
                $this->changeAddressFormInputTemplates($paymentMethod['children']['form-fields']['children']);
            }
        }

        //change payment page billing address fields
        if (isset($jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']['payment']["children"]["afterMethods"]["children"]["billing-address-form"]["children"]["form-fields"]['children'])) {
            $this->changeAddressFormInputTemplates($jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']['payment']["children"]["afterMethods"]["children"]["billing-address-form"]["children"]["form-fields"]['children']);
        }


        return $jsLayout;
    }

    /**
     * @param array $data
     * @return void
     */
    protected function changeAddressFormInputTemplates(array &$data): void
    {

        $data['postcode']['config']['elementTmpl'] = 'TheITNerd_Brasil/ui/form/element/cepInput';
        $data['vat_id']['config']['elementTmpl'] = 'TheITNerd_Brasil/ui/form/element/cpfCnpjInput';
        $data['telephone']['config']['elementTmpl'] = 'TheITNerd_Brasil/ui/form/element/telephoneInput';

    }
}
