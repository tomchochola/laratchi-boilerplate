## API specification

Available at `/api/v1/spec`.

Source files are located in [./docs/openapi_v1.json](./docs/openapi_v1.json).

## How to setup

```sh
# clone code
git clone

# enter directory
cd project

# configure env
cp -n .env.example .env

nano .env

# build app for selected environment
make production
make staging
make development
make local
make testing

# start server or direct webserver to `public/index.php`
php artisan serve
```

## CLI

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

# remove re-creatable files
make cold

# check code
make check
make ci

# audit packages
make audit

# lint code
make lint

# run unit tests
make test

# fix code
make fix

# normalize composer.json files
make composer-normalize

# remove ignored files
make clean
```
