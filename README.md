## Application documentation

Source files are located in [./docs/application_documentation.md](./docs/application_documentation.md).

## API specification

Available at URL `/api/v1/spec`.

Source files are located in [./public/docs/openapi_v1.json](./public/docs/openapi_v1.json).

## Database schema

Source files are located in [./docs/database_schema.md](./docs/database_schema.md).

## CLI

```sh
# scaffold validity
./artisan make:validity SharedValidity

# test mailer integration
./artisan test:mail

# scaffold crud
./artisan make:tchi Model
```

## Provision

```sh
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
```
