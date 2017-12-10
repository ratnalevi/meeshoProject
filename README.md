# meeshoProject
Test project to implement rest API and client for it
Message Queues and its worker.

The repository has five different folders

1. Config - Has the basic cofiguration of message queues and path details
2. console -  Has the worker implementation and be driven from console. 
LIMITATION - The worker can be initiated from console folder ONLY. `php processQueue.php `
3. Controllers - This is for rest api to insert an order into message queue
4. Helpers - This folder has supporting classes for the execution like message class, queue class, validator class, mailer class and http response class.
5. Test - This folder has a test case to post an order to API. Can be executed from command line by using `php postToAPI.php` from this folder.

This repository has a dependency on external library for data validation. It is done by using composer. 

Tutorial to install composer : https://www.digitalocean.com/community/tutorials/how-to-install-and-use-composer-on-ubuntu-14-04

SO before starting the project install composer in the repository. `composer install`

NOTE : While development, the API were used via http://meesho.com domain. So configura the apache system and /etc/hosts/ file to support this.

The API to push order to API : http://meesho.com/routes.php?action=add

Code flow : 

When API hits this server,

1. routes.php
2. To respective controller and method ( OrderController::addOrder )
3. Data Validation
4. Add data to Queue.
5. According to request header, set response and respond.

Not found routes and methods handled through proper response.

Things thought of doing put pending : 

1. Proper Logging in file
2. Use of namespaces instead of require
3. Pretty url format, done partially in .htaccess file but file is effecting apache.


