## Application documentation

Available at [./docs/application_documentation.md](./docs/application_documentation.md).

## API specification

Available at URL `/api/v1/spec`.

Source files are located in [./public/docs/openapi_v1.json](./public/docs/openapi_v1.json).

## HTTPie samples

Available at URL `/docs/httpie.sh`.

Source files are located in [./public/docs/httpie.sh](./public/docs/httpie.sh).

## Database schema

Available at [./docs/database_schema.md](./docs/database_schema.md).

## How to setup

```sh
# configure ENV via .env
cp -n .env.example .env

nano .env

# build app for selected environment
make production
make staging
make development
make local
make testing

# direct webserver strictly to /public/index.php only
```

## Artisan

```sh
# make validity class
php8.1 artisan make:validity SharedValidity

# test mail
php8.1 artisan test:mail

# scaffold
php8.1 artisan make:tchi Model
```

## Makefile

```sh
# required env variables
MAKE_PHP_8_1_BIN="php8.1"
MAKE_COMPOSER_2_BIN="/usr/local/bin/composer2"

# production build
make production

# staging build
make staging

# development build
make development

# local build
make local

# testing build
make testing

# check code
make check

# fix code
make fix

# local update
make update-full
```
