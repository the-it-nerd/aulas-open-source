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
