## Application documentation

Source files are located in [./docs/application_documentation.md](./docs/application_documentation.md).

## API specification

Available at URL `/api/v1/spec`.

Source files are located in [./public/docs/openapi_v1.json](./public/docs/openapi_v1.json).

## HTTPie samples

Available at URL `/docs/httpie.sh`.

Source files are located in [./public/docs/httpie.sh](./public/docs/httpie.sh).

## Database schema

Source files are located in [./docs/database_schema.md](./docs/database_schema.md).

## How to provision

```sh
# configure ENV via .env
cp -n .env.example .env

# build app for selected environment
make production
make staging
make development
make local
make testing
```

## Artisan

```sh
# scaffold validity
php8.2 artisan make:validity SharedValidity

# test mailer integration
php8.2 artisan test:mail

# scaffold crud
php8.2 artisan make:tchi Model
```

## Makefile

```sh
# required env variables
MAKE_PHP_8_2_BIN="php8.2"
MAKE_COMPOSER_2_BIN="/usr/local/bin/composer2"

# production provision
make production

# staging provision
make staging

# development provision
make development

# local provision
make local

# testing provision
make testing

# lint code style, unit tests, static analysis
make check

# fix code style
make fix

# update everything
make update-full
```
