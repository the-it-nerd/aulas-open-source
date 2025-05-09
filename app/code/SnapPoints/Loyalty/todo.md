# On queue
- First integrated test (WIP)
- Implement Queue Logger on the queues publishers and consumers
  - Cron for archiving logs
- Create Queue Retrier/Manager
- Finish the product level max give back ratio rule
- Finish Admin CRUDs For logs and queue messages (everything needs to be read-only)

# DEVOPS Setup
- Code reviews (PHP & JS).
- PHP unit tests.
- Frontend/UX review (Mobile-first).
- Versioning review (2.4.7/PHP 8.3 & 2.4.6/PHP 8.2).
- Move magento module to src compose structure
- Publish SDK & Module (Public Repos & Magento Marketplace).

# Module setup
- PHPUnit Tests

# Ideas / Future
- new widgets
  - mini cart
  - cart page subtotals
- Host logos on a single domain with image transformation is possible
- Provide Program description through API
- Programs custom page
- Logged in customer points reports
- PWA Template implementation for PWA Studio
- HYVA integration
- Mage-OS QA


Magento 2 Snappoints Module - Status Update
Current Status:
- Core module structure, database, and admin configuration are complete.
- PHP SDK (Alpha) for loyalty programs is implemented, including secure key storage.
- Frontend widget locations defined and implemented.
- The process for loading program/points updates is built and under.
- Finalize frontend implementation & points calculation.
- Checkout update to use the new js widget, done but will wait for the quote data to generate the correct points
- Import the max give back ratio

- WIP:
- Fixing the Points calculation model
- Tue, Apr 29: Build Magento -> Snappoints product importer and product point calculation.
- 


