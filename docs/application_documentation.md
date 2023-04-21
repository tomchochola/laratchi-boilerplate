# Application documentation

## Tech stack

- PHP 8.1
- Laravel 9
- Composer 2

## Software requirements

- Oracle MySQL 8
- Redis
- Cron
- Supervisor

## Required PHP extensions

- bcmath
- ctype
- fileinfo
- json
- mbstring
- openssl
- pdo
- tokenizer
- xml
- iconv
- pcre
- session
- simplexml
- curl
- dom
- filter
- libxml
- phar
- xmlwriter
- intl
- gd
- pcntl
- posix
- redis
- gmp
- uuid
- cli
- memcached
- amqp
- mongodb
- pgsql
- soap
- zip
- imagick
- imap
- mysql
- tidy
- exif

## Packages

| package                                 | description |
| --------------------------------------- | ----------- |
| https://github.com/tomchochola/laratchi | laratchi    |

## Tooling

| tool                                         | description     |
| -------------------------------------------- | --------------- |
| https://github.com/tomchochola/php-cs-fixer  | code style      |
| https://github.com/tomchochola/phpstan-rules | static analysis |
| https://github.com/prettier/prettier         | code style      |
| https://github.com/stoplightio/spectral      | static analysis |

## Locales

- cs
- en

## Services

- Mailer - SMTP (development staging)
- Mailer - Mailgun (production)

## ENV

No special ENV needed.

## Cookies

| name                                                | description  |
| --------------------------------------------------- | ------------ |
| \_\_Host-{app_name}\_{env}\_database_token\_{table} | bearer token |
| \_\_Host-{app_name}\_{env}\_session                 | session      |

## Cron

| command                     | cycle        |
| --------------------------- | ------------ |
| php8.1 artisan schedule:run | every minute |

## Queues

| name    | cores | tries | sleep | memory | timeout | max time |
| ------- | ----- | ----- | ----- | ------ | ------- | -------- |
| default | max   | 1     | 3     | 65535  | 3600    | 86400    |
