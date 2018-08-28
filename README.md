# Simple RESTful Voucher-Pool API 

Framework: Slim Framework v3

    
## Install the Application

Run this command from the directory in which you want to install your new Slim Framework application.

    git clone [url] /my/project/folder/

Replace `[/my/project/folder/]` with the desired directory name for your new application. You'll want to:

* Point your virtual host document root to your new application's `public/` directory.

* Create `logs/` folder and ensure the folder is web writable.

To run the application in development, you can run these commands 

	cd /my/project/folder/
	composer install

Creating/updating Entities

	php vendor/bin/doctrine orm:convert-mapping --namespace="App\\Entity\\" --from-database --force xml src/maps /change/folder/name/to/maps/folder

For UnitTest, first go to project folder, then please run the command below

    ./vendor/bin/phpunit --bootstrap vendor/autoload.php tests/
    
### Endpoints

##### Create Recipient
    
    curl -X POST \
      http://project.address/recipient \
      -H 'content-type: application/json' \
      -d '{"name": "Simple Name", "email": "info@simple.com"}'

##### Create Offer
    
    curl -X POST \
      http://project.address/offer \
      -H 'content-type: application/json' \
      -d '{"name": "Spring2018", "discount": 70}'

##### Create Voucher
    
    curl -X POST \
      http://project.address/recipient \
      -H 'content-type: application/json' \
      -d '{"offer_id": 1, "expiration_date": "2018-09-05"}'
      
##### Using the Voucher
    
    curl -X POST \
      http://project.address/useVoucher \
      -H 'content-type: application/json' \
      -d '{"code": "Spring2018", "email": "info@simple.com"}'
      
 
##### Extras

Postman and Database exports are in `exports` folder.
