# Simple Password Recovery Microservice

A little project to demonstrate the basics of distributed system using message queue and microservice with potential to be scalable. There are three components in this project: Web Client, API Gateway, and the Service.

- The Web Client is the interface for the users
- The API Gateway is a single entryway to redirect all request to the services
- The Service is the part where requests are queued inside a message broker, and a worker would fetch the request and asynchronously execute it.

## Installation

This project requires Composer and RabbitMQ to run.

To install RabbitMQ, see the following [link](https://www.rabbitmq.com/download.html). To install RabbitMQ in MacOS using brew, ppen terminal and insert the following command:

```sh
$ brew install rabbitmq
```

Afterward, the components can be setup. First, setup the Service.

```sh
$ cd services
$ composer install
$ php -S locahost:5003
```

Next, run the API Gateway.

```sh
$ cd api
$ php -S locahost:5002
```

And run the Web Client.

```sh
$ cd web
$ php -S locahost:5001
```

Press `Ctrl+C` to end the processes.

## Usage

To access the web client, open `locahost:5001` in your browser.

## Config

To run the project in a different environment, some changes can be made in the configs file.

Config for Web Client: `web/config.php`

```
define('API_LOGIN_URL', 'http://localhost:5002/login/');
define('API_FORGOT_PASSWORD_URL', 'http://localhost:5002/forgot/');
```

You can change the location of the API:

```
define('API_LOGIN_URL', '<API URL>/login/');
define('API_FORGOT_PASSWORD_URL', '<API URL>/forgot/');
```

The same also goes for the config for the API.

Config for API Gateway: `api/config.php`

```
define('WEB_LOGIN_URL', 'http://localhost:5001/');
define('WEB_FORGOT_PASS_URL', 'http://localhost:5001/forgot.php');

define('AUTH_SERVICE_URL', 'http://localhost:5003/auth/');
```

You can change the location of the Web Client and the Service:

```
define('WEB_LOGIN_URL', '<WEB CLIENT URL>');
define('WEB_FORGOT_PASS_URL', '<WEB CLIENT URL>/forgot.php');

define('AUTH_SERVICE_URL', '<SERVICE URL>/auth/');
```

This way, you can put the three components in different servers and it would work.

## Database

To minimize the setup requred for the demo project, a database is replaced with an array located in `services/database.php`.

```
$db_user_table = array(
  1 => array('id' => '1', 'username' => 'helloprint', 'password' => 'P@ssw0rd!', 'email' => 'hello@print.com', 'status' => '1')
);
```

## License
[MIT](https://choosealicense.com/licenses/mit/)