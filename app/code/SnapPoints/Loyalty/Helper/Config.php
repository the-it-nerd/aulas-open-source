<?php
/**
 * Copyright © SnapPoints Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace SnapPoints\Loyalty\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\Encryption\EncryptorInterface;


class Config extends AbstractHelper
{
    // Main Module Configuration
    private const XML_PATH_ENABLED = 'snappoints/general/enabled';
    private const XML_PATH_PRODUCTION_MODE = 'snappoints/general/production_mode';

    // Production Credentials
    private const XML_PATH_PRODUCTION_MERCHANT_ID = 'snappoints/general/production_merchant_id';
    private const XML_PATH_PRODUCTION_CLIENT_ID = 'snappoints/general/production_client_id';
    private const XML_PATH_PRODUCTION_CLIENT_SECRET = 'snappoints/general/production_client_secret';

    // Sandbox Credentials
    private const XML_PATH_SANDBOX_MERCHANT_ID = 'snappoints/general/sandbox_merchant_id';
    private const XML_PATH_SANDBOX_CLIENT_ID = 'snappoints/general/sandbox_client_id';
    private const XML_PATH_SANDBOX_CLIENT_SECRET = 'snappoints/general/sandbox_client_secret';

    // Integration Settings
    private const XML_PATH_INTEGRATION_ENABLED = 'snappoints_integrations/general/enabled';
    private const XML_PATH_NOTIFICATION_EMAILS = 'snappoints_integrations/general/notification_emails';
    private const XML_PATH_QUEUE_LOG_RETENTION = 'snappoints_integrations/general/queue_log_retention';
    private const XML_PATH_GENERAL_LOG_RETENTION = 'snappoints_integrations/general/general_log_retention';

    // Cron Settings
    private const XML_PATH_FAILED_JOBS_SCHEDULE = 'snappoints_integrations/cron_settings/failed_jobs_schedule';
    private const XML_PATH_NOTIFICATIONS_SCHEDULE = 'snappoints_integrations/cron_settings/notifications_schedule';
    private const XML_PATH_CATALOG_SYNC_SCHEDULE = 'snappoints_integrations/cron_settings/catalog_sync_schedule';

    // UI Features
    private const XML_PATH_ENABLE_TOPBAR = 'snappoints_ui/features/enable_topbar';
    private const XML_PATH_ENABLE_PRODUCT_CARDS = 'snappoints_ui/features/enable_product_cards';
    private const XML_PATH_ENABLE_PDP_WIDGET = 'snappoints_ui/features/enable_pdp_widget';
    private const XML_PATH_ENABLE_CART_WIDGET = 'snappoints_ui/features/enable_cart_widget';
    private const XML_PATH_ENABLE_CHECKOUT_WIDGET = 'snappoints_ui/features/enable_checkout_widget';
    private const XML_PATH_ENABLE_CUSTOMER_ACCOUNT = 'snappoints_ui/features/enable_customer_account';

    // Display Settings
    private const XML_PATH_POINTS_LABEL = 'snappoints_ui/display_settings/points_label';
    private const XML_PATH_POINTS_FORMAT = 'snappoints_ui/display_settings/points_format';


    /**
     * @param Context $context
     */
    public function __construct(
        Context $context,
        protected readonly EncryptorInterface $encryptor
    )
    {
        parent::__construct($context);
    }

    /**
     * Checks if the feature is enabled for the given
     *
     * @param string|null $store
     * @return bool
     */
    public function isEnabled(?string $store = null): bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_ENABLED, ScopeInterface::SCOPE_STORE, $store);
    }

    /**
     * Determines if the application is in production mode.
     *
     * @param string|null $store The specific store code to check the setting for, or null for the default store.
     * @return bool True if the application is in production mode, false otherwise.
     */
    public function isProductionMode(?string $store = null): bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_PRODUCTION_MODE, ScopeInterface::SCOPE_STORE, $store);
    }

    /**
     * Retrieve the merchant ID based on the store configuration.
     *
     * @param string|null $store The store code or null to use the default store.
     * @return string The merchant ID configured for the given store.
     */
    public function getMerchantId(?string $store = null): string
    {
        $path = $this->isProductionMode($store)
            ? self::XML_PATH_PRODUCTION_MERCHANT_ID
            : self::XML_PATH_SANDBOX_MERCHANT_ID;
        return (string)$this->scopeConfig->getValue($path, ScopeInterface::SCOPE_STORE, $store);
    }

    /**
     * Retrieves the client ID based on the store and mode (production or sandbox).
     *
     * @param string|null $store The store code for which the client ID is to be retrieved. Defaults to null.
     * @return string The client ID for the specified store.
     */
    public function getClientId(?string $store = null): string
    {
        $path = $this->isProductionMode($store)
            ? self::XML_PATH_PRODUCTION_CLIENT_ID
            : self::XML_PATH_SANDBOX_CLIENT_ID;
        return (string)$this->scopeConfig->getValue($path, ScopeInterface::SCOPE_STORE, $store);
    }

    /**
     * Retrieves the client secret based on the current mode (production or sandbox).
     *
     * @param string|null $store The store scope for which the client secret is retrieved
     */
    public function getClientSecret(?string $store = null): string
    {
        $path = $this->isProductionMode($store)
            ? self::XML_PATH_PRODUCTION_CLIENT_SECRET
            : self::XML_PATH_SANDBOX_CLIENT_SECRET;
        $encryptedValue = $this->scopeConfig->getValue($path, ScopeInterface::SCOPE_STORE, $store);

        return $this->encryptor->decrypt($encryptedValue);

    }

    /**
     * Determines if the integration feature is enabled for the specified store scope.
     *
     * @*/
    public function isIntegrationEnabled(?string $store = null): bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_INTEGRATION_ENABLED, ScopeInterface::SCOPE_STORE, $store);
    }

    /**
     * Retrieves the notification emails for the specified store scope.
     *
     * @param string|null $store The store scope for which the notification emails are retrieved
     * @return string The notification emails configured for the specified store scope
     */
    public function getNotificationEmails(?string $store = null): string
    {
        return (string)$this->scopeConfig->getValue(self::XML_PATH_NOTIFICATION_EMAILS, ScopeInterface::SCOPE_STORE, $store);
    }

    /**
     * Retrieves the queue log retention duration for the specified store scope.
     *
     * @param string|null $store The store scope for which the queue log retention duration is retrieved
     * @return int The duration of the queue log retention in days
     */
    public function getQueueLogRetention(?string $store = null): int
    {
        return (int)$this->scopeConfig->getValue(self::XML_PATH_QUEUE_LOG_RETENTION, ScopeInterface::SCOPE_STORE, $store);
    }

    /**
     * Retrieves the general log retention period configuration value for the specified store scope.
     *
     * @param string|null $store The store scope for which the general log retention value is retrieved
     * @return int The general log retention period
     */
    public function getGeneralLogRetention(?string $store = null): int
    {
        return (int)$this->scopeConfig->getValue(self::XML_PATH_GENERAL_LOG_RETENTION, ScopeInterface::SCOPE_STORE, $store);
    }

    /**
     * Retrieves the schedule configuration for failed jobs.
     *
     * @param string|null $store The store scope for which the failed jobs schedule is retrieved
     * @return string The configuration value for the failed jobs schedule
     */
    public function getFailedJobsSchedule(?string $store = null): string
    {
        return (string)$this->scopeConfig->getValue(self::XML_PATH_FAILED_JOBS_SCHEDULE, ScopeInterface::SCOPE_STORE, $store);
    }

    /**
     * Retrieves the notifications schedule configuration value for the given store scope.
     *
     * @param string|null $store The store scope for which the notifications schedule is retrieved
     * @return string The notifications schedule configuration value
     */
    public function getNotificationsSchedule(?string $store = null): string
    {
        return (string)$this->scopeConfig->getValue(self::XML_PATH_NOTIFICATIONS_SCHEDULE, ScopeInterface::SCOPE_STORE, $store);
    }

    /**
     * Retrieves the catalog synchronization schedule configuration value for the specified store.
     *
     * @param string|null $store The store scope for which the catalog sync schedule is retrieved.
     * @return string The catalog sync schedule configuration value.
     */
    public function getCatalogSyncSchedule(?string $store = null): string
    {
        return (string)$this->scopeConfig->getValue(self::XML_PATH_CATALOG_SYNC_SCHEDULE, ScopeInterface::SCOPE_STORE, $store);
    }

    /**
     * Determines whether the topbar is enabled for the specified store scope.
     *
     * @param string|null $store The store scope to check the topbar status for
     * @return bool True if the topbar is enabled, otherwise false
     */
    public function isTopbarEnabled(?string $store = null): bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_ENABLE_TOPBAR, ScopeInterface::SCOPE_STORE, $store);
    }

    /**
     * Determines if the PDP (Product Detail Page) widget is enabled for the specified store.
     *
     * @param string|null $store The store scope to check if the PDP widget is enabled
     * @return bool True if the PDP widget is enabled, false otherwise
     */
    public function isPdpWidgetEnabled(?string $store = null): bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_ENABLE_PDP_WIDGET, ScopeInterface::SCOPE_STORE, $store);
    }

    /**
     * Checks if the cart widget is enabled for the given store scope.
     *
     * @param string|null $store The store scope for which the cart widget setting is checked
     * @return bool Returns true if the cart widget is enabled, otherwise false
     */
    public function isCartWidgetEnabled(?string $store = null): bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_ENABLE_CART_WIDGET, ScopeInterface::SCOPE_STORE, $store);
    }

    /**
     * Determines if the checkout widget is enabled for the specified store.
     *
     * @param string|null $store The store code. If null, the current store is used.
     * @return bool True if the checkout widget is enabled, false otherwise.
     */
    public function isCheckoutWidgetEnabled(?string $store = null): bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_ENABLE_CHECKOUT_WIDGET, ScopeInterface::SCOPE_STORE, $store);
    }

    /**
     * @param string|null $store
     * @return bool
     */
    public function isCustomerAccountEnabled(?string $store = null): bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_ENABLE_CUSTOMER_ACCOUNT, ScopeInterface::SCOPE_STORE, $store);
    }

    /**
     * @param string|null $store
     * @return string
     */
    public function getPointsLabel(?string $store = null): string
    {
        return (string)$this->scopeConfig->getValue(self::XML_PATH_POINTS_LABEL, ScopeInterface::SCOPE_STORE, $store);
    }

    /**
     * Retrieves the points format configuration for the specified store.
     *
     * @param string|null $store The store code. If null, the current store is used.
     * @return string The configured points format.
     */
    public function getPointsFormat(?string $store = null): string
    {
        return (string)$this->scopeConfig->getValue(self::XML_PATH_POINTS_FORMAT, ScopeInterface::SCOPE_STORE, $store);
    }

}

