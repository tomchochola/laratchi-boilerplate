## Application documentation

Available at [./docs/application_documentation.md](./docs/application_documentation.md).

## API specification

Available at URL `/api/v1/spec`.

Source files are located in [./public/openapi/openapi_v1.json](./public/openapi/openapi_v1.json).

## Database schema

Available at [./docs/database_schema.md](./docs/database_schema.md).

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
make start
make serve
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

# clean install vendor, clear bootstrap files
make lukewarm

# check code
make check
make ci

# audit packages
make audit

# lint code
make lint

# run unit tests without large group
make test

# run only large group unit tests
make test-large

# fix code
make fix

# remove ignored files
make clean

# update
make update
make update-tools
make update-composer
```
