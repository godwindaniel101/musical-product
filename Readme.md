
## About Application
A product purchase web application which gives users the ability to purchase product and store product record. Basic functionality include.

- Authentication
- User creation
- Product creation
- Product purchase 

**System Requirement**
- The software was designed on docker version 20.10.8

**Application Initial Set Up**
- Clone application from git respository or unzip project archive
- Open  project directory  `cd  muscial_instrument  `
- Copy environmental variables. `cp ./src/.env.example ./src/.env`
- Spin up Docker    `docker-compose up --build -d`
- Open Docker Bash  `docker-compose exec app /bin/bash`
- Run the following command on Docker Bash

  `composer install  && php artisan migrate --seed   && php artisan passport:install`
  
- Application should be available on  port 8008

**Running Application**
- After initial set up above application can easily be brought up by running the command   
`docker-compose up --build -d`
- Application can be brought down by running the command  `docker-compose down `

**Testing  Application**
-After initial set up above, spin up the application by running `docker-compose up --build -d`
- Run application shell by running    `docker-compose exec app /bin/bash`
- Run test by running  `php artisan test`
 **Note**  Test is to be ran on application bash to persist PHP version on test and running instance.

#End Points
Base URL `http://localhost:8008/api`

**Login**  

`POST : {baseUrl}/auth`

Handles authentication of users

**Create User**  

`POST : {baseUrl}/register`

Handles creation of new user

**Get all Users**  

`Get : {baseUrl}/user/all`

Returns an array of all users

**Get all Products**  

`Get : {baseUrl}/user/all`

Returns an array of all Products

**Create Product**  

`POST : {baseUrl}/products`

Handles creation of new products 

**Get current  logged in user detail**  

`GET : {baseUrl}/user`

Returns an object of current logged in user data

**Get User Purchase Product**  

`GET : {baseUrl}/user/products/product-sku`

Returns an array of all products purchased by a user


**Attach User Purchase Product**  

`POST : {baseUrl}/user/products`

Handles addition of purchase product to a user

**Detach User Purchase Product**  

`DELETE : {baseUrl}/user/products`

Delete Record of user purchase on a particular product


> ** Note :  import attached postman collection for better understanding**


**Software Assumptions**
- A user can only purchase item they are yet to purchase.

- When using Postman to test, the Postman collection and environment files found in the root folder of the  project must have been imported and selected.

- The use of some coding concepts such as Micro-services, Database partitioning, Repository structures etc, was avoiding during this code design due to the scope of the task requirement.

- Port 8008, 3306 and 8020 are required to be available for Docker Container to work.

- All response from the Application are also presented on **stdout**, thus visible on the Docker console.

- Testing will be done within the Docker container to ensure all running instance are the same.

- Use of caching was used only for application configuration and not on system operation, this is due to the dynamic nature of the data. That is , the product , purchase and user record changes often.

**Recommendations**
- A user should be allowed to purchase one item multiple times but then the need for quantity count will be required.

- For scaling the use of microservices or modular code structure is highly recommended

##### Best  Regards!


