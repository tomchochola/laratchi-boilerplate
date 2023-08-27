# Application documentation

## Tech stack

- PHP 8.2
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

- Mailer - SMTP (development|staging)
- Mailer - Mailgun (production)

## Cookies

| name                                                | description  |
| --------------------------------------------------- | ------------ |
| \_\_Host-{app_name}\_{env}\_database_token\_{table} | bearer token |
| \_\_Host-{app_name}\_{env}\_session                 | session      |

## Cron

```
* * * * * ./artisan schedule:run | rotatelogs -n 1 ./storage/logs/cron.log 50M
```

## Supervisor

```
./artisan queue:work redis --tries=3 --sleep=3 --memory=65535 --timeout=86400 --queue=default --max-time=86400 --max-jobs=1000 --backoff=3600
```
