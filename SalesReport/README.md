# TNW_TriadHQ
Extended Ordered Products Report

## Installation
### Manual Installation
1. Place TriadHQ directory in the app/code/TNW/
2. Disable the cache under System->Cache Management
3. Enter the following in the command line:
    ```bash
    bin/magento module:enable --clear-static-content TNW_TriadHQ
    bin/magento setup:upgrade
    bin/magento cache:clean
   ```
   
### Using Composer
1.  Register the repository  
    ```bash
    composer config repositories.tnw/triadhq git git@github.com:PowerSync/TNW_TriadHQ.git
    ```
2.  Download module files  
    ```bash
    composer require tnw/triadhq dev-develop
    ```
