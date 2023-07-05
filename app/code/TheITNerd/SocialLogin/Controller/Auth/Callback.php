<?php

namespace TheITNerd\SocialLogin\Controller\Auth;

use Exception;
use Magento\Customer\Api\AccountManagementInterface;
use Magento\Customer\Api\CustomerRepositoryInterface as CustomerRepository;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Model\Account\Redirect as AccountRedirect;
use Magento\Customer\Model\Registration;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\CsrfAwareActionInterface;
use Magento\Framework\App\Request\InvalidRequestException;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Forward;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Message\MessageInterface;
use Magento\Framework\Stdlib\Cookie\CookieMetadataFactory;
use Magento\Framework\Stdlib\Cookie\FailureToSendException;
use Magento\Framework\Stdlib\Cookie\PhpCookieManager;
use Magento\Framework\UrlFactory;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;
use TheITNerd\SocialLogin\Model\OAuth;


/**
 * Class Callback
 * @package TheITNerd\SocialLogin\Controller\Auth
 */
class Callback extends Action\Action implements CsrfAwareActionInterface
{
    /**
     * @var UrlInterface
     */
    private UrlInterface $urlModel;

    /**
     * @param Action\Context $context
     * @param Session $session
     * @param OAuth $oauthAdapter
     * @param ScopeConfigInterface $scopeConfig
     * @param StoreManagerInterface $storeManager
     * @param AccountManagementInterface $accountManagement
     * @param Registration $registration
     * @param AccountRedirect $accountRedirect
     * @param CustomerRepository $customerRepository
     * @param CookieMetadataFactory $cookieMetadataFactory
     * @param PhpCookieManager $cookieMetadataManager
     * @param LoggerInterface $logger
     * @param UrlFactory $urlFactory
     */
    public function __construct(
        private readonly Action\Context             $context,
        private readonly Session                    $session,
        private readonly OAuth                      $oauthAdapter,
        private readonly ScopeConfigInterface       $scopeConfig,
        private readonly StoreManagerInterface      $storeManager,
        private readonly AccountManagementInterface $accountManagement,
        private readonly Registration               $registration,
        private readonly AccountRedirect            $accountRedirect,
        private readonly CustomerRepository         $customerRepository,
        private readonly CookieMetadataFactory      $cookieMetadataFactory,
        private readonly PhpCookieManager           $cookieMetadataManager,
        private readonly LoggerInterface            $logger,
        UrlFactory                                  $urlFactory
    )
    {

        $this->urlModel = $urlFactory->create();

        parent::__construct($context);
    }

    /**
     * @param RequestInterface $request
     * @return InvalidRequestException|null
     */
    public function createCsrfValidationException(RequestInterface $request): ?InvalidRequestException
    {
        return null;
    }

    /**
     * @return ResponseInterface|Forward|Redirect|ResultInterface
     */
    public function execute()
    {
        //Validate request
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($this->session->isLoggedIn() || !$this->registration->isAllowed()) {
            $resultRedirect->setPath('/');
            return $resultRedirect;
        }

        if (!$this->getRequest()->isPost()) {
            $url = $this->urlModel->getUrl('customer/account/create', ['_secure' => true]);
            return $this->resultRedirectFactory->create()
                ->setUrl($this->_redirect->error($url));
        }

        try {

            $adapter = $this->oauthAdapter->getOathAdapter($this->getRequest()->getParam('type'));
            if (!is_null($adapter)) {
                $customer = $adapter->getCustomerData($this->getRequest());
            } else {
                $this->messageManager->addErrorMessage(__('The login method is not available'));
                $resultRedirect = $this->resultRedirectFactory->create();
                $resultRedirect->setPath('/customer/account/login');
                return $resultRedirect;
            }

            //If existing customer login
            if ($existingCustomer = $this->getCustomer($customer)) {
                return $this->loginCustomer($existingCustomer, true);
            }

            // else create customer
            return $this->createCustomer($customer);
        } catch (Exception $e) {
            $this->logger->critical('Social Login Error', ['e' => $e]);
            $this->messageManager->addErrorMessage(__('Sorry we were unable to log you in.'));
            $resultRedirect = $this->resultRedirectFactory->create();
            $resultRedirect->setPath('/');
            return $resultRedirect;
        }


    }

    /**
     * @param CustomerInterface $customer
     * @return bool|CustomerInterface
     * @throws LocalizedException
     */
    private function getCustomer(CustomerInterface $customer): bool|CustomerInterface
    {
        try {
            return $this->customerRepository->get($customer->getEmail(), $this->storeManager->getWebsite()->getId());
        } catch (NoSuchEntityException $e) {
            return false;
        }
    }

    /**
     * @param CustomerInterface $customer
     * @param bool $withMessage
     * @return Forward|Redirect
     * @throws FailureToSendException
     * @throws InputException
     */
    private function loginCustomer(CustomerInterface $customer, bool $withMessage = false): Forward|Redirect
    {
        $this->session->setCustomerDataAsLoggedIn($customer);

        if ($withMessage) {
            $message = $this->messageManager
                ->createMessage(MessageInterface::TYPE_SUCCESS)
                ->setText(
                    __('You were successfully logged in.')
                );

            $this->messageManager->addMessage($message);
        }

        $resultRedirect = $this->resultRedirectFactory->create();

        //redirect to home if redirect to customer dashboard is disabled
        if (!$this->scopeConfig->getValue('customer/startup/redirect_dashboard')) {
            $resultRedirect->setUrl('/');
            $this->accountRedirect->clearRedirectCookie();
            return $resultRedirect;
        }

        //redirect to home if redirect to customer dashboard is enabled
        $resultRedirect = $this->accountRedirect->getRedirect();

        if ($this->cookieMetadataManager->getCookie('mage-cache-sessid')) {
            $metadata = $this->cookieMetadataFactory->createCookieMetadata();
            $metadata->setPath('/');
            $this->cookieMetadataManager->deleteCookie('mage-cache-sessid', $metadata);
        }

        return $resultRedirect;
    }

    /**
     * @param CustomerInterface $customer
     * @return Forward|Redirect
     */
    private function createCustomer(CustomerInterface $customer): Forward|Redirect
    {
        $this->session->regenerateId();
        try {
            //create dummy password
            $password = base64_encode(md5(random_int(0, 1000)));
            $redirectUrl = $this->session->getBeforeAuthUrl();
            $extensionAttributes = $customer->getExtensionAttributes();
            $extensionAttributes->setIsSubscribed(false);
            $customer->setExtensionAttributes($extensionAttributes);

            $customer = $this->accountManagement
                ->createAccount($customer, $password, $redirectUrl);

            $this->_eventManager->dispatch(
                'customer_register_success',
                ['account_controller' => $this, 'customer' => $customer]
            );

            $redirect = $this->loginCustomer($customer);

            $message = $this->messageManager
                ->createMessage(MessageInterface::TYPE_SUCCESS)
                ->setText(
                    __('Thank you for registering with %1.', $this->storeManager->getStore()->getFrontendName())
                );

            $this->messageManager->addMessage($message);

            return $redirect;

        } catch (Exception $e) {
            $this->messageManager->addErrorMessage(__('We can\'t save the customer. %1', $e->getMessage()));
            $resultRedirect = $this->resultRedirectFactory->create();
            $resultRedirect->setPath('/');
            return $resultRedirect;
        }
    }

    /**
     * @inheritDoc
     */
    public function validateForCsrf(RequestInterface $request): ?bool
    {
        return true;
    }
}
