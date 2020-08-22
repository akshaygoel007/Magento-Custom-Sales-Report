# Venture7_CouponReport
Extended Ordered Coupons Report

## Installation
### Manual Installation
1. Place CouponReport directory in the app/code/Venture7/
2. Disable the cache under System->Cache Management
3. Enter the following in the command line:
    ```bash
    bin/magento module:enable --clear-static-content Venture7_CouponReport
    bin/magento setup:upgrade
    bin/magento cache:clean
   ```
   
### Using Composer
1.  Register the repository  
    ```bash
    composer config repositories.venture7/couponreport git git@github.com:PowerSync/Venture7_CouponReport.git
    ```
2.  Download module files  
    ```bash
    composer require venture7/couponreport dev-develop
    ```
