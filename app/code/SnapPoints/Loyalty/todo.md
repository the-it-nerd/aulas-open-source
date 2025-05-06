# define
https://api.snappoints.com/documentation#/
- which api to use for programs
  - /api/v1/merchants/{merchantId}/loyalty-programs
  - /api/v1/merchants/{merchantId}/loyalty-programs/{loyaltyProgramId}
  - /api/v1/merchants/{merchantId}/loyalty-programs-points/{currency}/program-points
  - /api/v1/merchants/{merchantId}/loyalty-programs-points/{currency}/program-points-simulation
  - /api/v1/merchants/{merchantId}/loyalty-programs-pricing/{currency}/program-pricing
- which api to use for rules
  - /api/v1/merchants/{merchantId}/points-settings-rules
  - /api/v1/merchants/{merchantId}/points-settings
- which api to use for product rules
  - /api/v1/merchants/{merchantId}/products-computed-settings
- which api for customers
  - /api/v1/merchants/{merchantId}/customers
  - /api/v1/users
   
- create client as standalone php library

# DEVOPS Setup
- git repository
- packagist access
- host logos on a single domain with image transformation is possible

# Module setup
- PHPUnit Tests
- Cron for archiving logs
- Admin configuration for the api connection
- Admin configuration for widgets to display
- Admin configuration for log retention
- Finish Admin CRUDs (everything needs to be read only)

# Ideas / Future 
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

Next Steps:
- Thu, May 1: Build Snappoints order processing flow.
- Mon, May 5: First integrated test.

Other Pending Items:
- Code reviews (PHP & JS).
- PHP unit tests.
- Frontend/UX review (Mobile-first).
- Versioning review (2.4.7/PHP 8.3 & 2.4.6/PHP 8.2).
- Publish SDK & Module (Public Repos & Magento Marketplace).
