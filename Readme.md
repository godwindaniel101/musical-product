
## About Application
A product purchase web application which gives users the apbility to purchase product and store product record. Basic functionality include.

- Authentication
- User creation
- Product creation
- Product purchase 

**System Requirement**
The software was designed on docker version 20.10.8

**Application Initial Set Up**
- Clone application from git respository or unzip project archive;
- Open  project directory  `cd  muscial_instrument  `
- Copy environmental vairables. `cp ./src/env.example ./src/env`
- Spin up docker    `docker-compose up --build -d`
- Open docker bash  `docker-compose exec app /bin/bash`
- Run the following command on docker bash

  `composer install   && php artisan migrate --seed  && php artisan passport:install`
  
- Application should be available on  port 8008

**Running Application**
- After inital set up above application can easily be brought up by runinng the command ; 
`docker-compose up --build -d`
- Application can be brought down by running the command   `docker-compose down `

**Testing  Application**
-After inital set up above, spin up the application by runing `docker-compose up --build -d`
- Run application shell by running    `docker-compose exec app /bin/bash`
- Run test by running  `php artisan test`
- **Note**  Test is also run on application bash to persist php version on test and runing instance 

#End Points
Base Url `http://localhost:8008/api`

**Login**  

`POST : {baseUrl}/auth`

Handles authentication of users

**Create User**  

`POST : {baseUrl}/register`

Handles creation of new users

**Get all Users**  

`Get : {baseUrl}/user/all`

Returns an array of all users

**Get all Products**  

`Get : {baseUrl}/user/all`

Returns an array of all Products

**Create Product **  

`POST : {baseUrl}/products`

Handles creation of new products 

**Get current  logged in user detail **  

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

Delete Records of user purchase on a particular product


> ** Note :  import attached postman collection for better understanding**


**Software Assumptions**
- A user can only purchase item they are yet to purchase. a user could be allowed to purchase one item multiple times but then the need for quantity count will be required which is beyound the scope of this project

- The use of some coding concepts such as microservices, database partinoning, respository structures etc, was avoiding during this code design due to the scope task requirement

- Port 8008, 3306 and 8020 are required to be available for docker container to work

- All response from the Application are also presented on **stdout**, thus visable on the docker console 

- Testing should be done within the docker container to ensure all running instance are the same
- Use of caching was used only for application configuration and not on system operation, this is due to the dynamic nature of the data. That is , the product , purchase and user record changes often
