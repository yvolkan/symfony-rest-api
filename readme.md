# Symfony Rest API

## Installation

1. First of clone this repo with `git clone https://github.com/yvolkan/symfony-rest-api` command on your computer.
2. Then open terminal and go to where your folder is located.
3. Run `composer install` command; this will generate _vendor_ folder. (You can run this command after docker build command into docker php container)
4. Build and run project `docker-compose up -d --build` with Docker.
5. If the docker was successful you can see `http://localhost/api/status` website on your browser.
6. Finally run commands `php bin/console doctrine:schema:create` to create tables and `php bin/console doctrine:fixtures:load` to test data into a database.

## Getting Started

To get started with the Postman collections you will need to download the Postman tool from getpostman.com/postman.

With Postman installed, you can then import the files whose file location is **postman** folder into Postman and start making your requests.
