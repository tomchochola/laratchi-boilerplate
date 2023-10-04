# Default shell
SHELL := /bin/bash

# Variables
MAKE_PHP_8_2_BIN ?= php8.2
MAKE_COMPOSER_2_BIN ?= /usr/local/bin/composer2

MAKE_PHP ?= ${MAKE_PHP_8_2_BIN}
MAKE_COMPOSER ?= ${MAKE_PHP} ${MAKE_COMPOSER_2_BIN}

# Default goal
.DEFAULT_GOAL := panic

# Goals
.PHONY: check
check: stan test lint audit

.PHONY: audit
audit: vendor
	${MAKE_COMPOSER} audit

.PHONY: stan
stan: vendor tools
	${MAKE_PHP} ./tools/phpstan/vendor/bin/phpstan analyse
	./tools/spectral/node_modules/.bin/spectral lint --fail-severity=hint ./public/docs/openapi*

.PHONY: lint
lint: vendor tools
	${MAKE_COMPOSER} validate --strict
	./tools/prettier/node_modules/.bin/prettier --plugin=./tools/prettier/node_modules/@prettier/plugin-xml/src/plugin.js --xml-quote-attributes=double --xml-whitespace-sensitivity=ignore -c .
	${MAKE_PHP} ./tools/php-cs-fixer/vendor/bin/php-cs-fixer fix --dry-run --diff

.PHONY: test
test: vendor clear
	./artisan test

.PHONY: fix
fix: vendor tools
	./tools/prettier/node_modules/.bin/prettier --plugin=./tools/prettier/node_modules/@prettier/plugin-xml/src/plugin.js --xml-quote-attributes=double --xml-whitespace-sensitivity=ignore --plugin=./tools/prettier/node_modules/@prettier/plugin-php/src/index.js --php-version=8.2 -w .
	${MAKE_PHP} ./tools/php-cs-fixer/vendor/bin/php-cs-fixer fix

.PHONY: production
production: composer clear migrate seed composer-no-dev optimize storage queue

.PHONY: staging
staging: production

.PHONY: development
development: composer clear migrate seed composer-no-dev optimize storage queue

.PHONY: local
local: composer clear migrate seed storage queue

.PHONY: testing
testing: composer clear migrate seed storage queue

.PHONY: composer
composer:
	${MAKE_COMPOSER} install

.PHONY: composer-no-dev
composer-no-dev:
	${MAKE_COMPOSER} install --no-dev -a

.PHONY: clear
clear: vendor
	./artisan optimize:clear
	./artisan cache:clear
	./artisan config:clear
	./artisan event:clear
	./artisan route:clear
	./artisan view:clear
	./artisan clear-compiled

.PHONY: migrate
migrate: vendor
	./artisan migrate --force

.PHONY: seed
seed: vendor
	./artisan db:seed --force

.PHONY: optimize
optimize: vendor
	./artisan optimize
	./artisan config:cache
	./artisan event:cache
	./artisan route:cache
	./artisan view:cache

.PHONY: storage
storage: vendor
	./artisan storage:link --force

.PHONY: queue
queue: vendor
	./artisan queue:restart

.PHONY: down
down: vendor
	./artisan down

.PHONY: up
up: vendor
	./artisan up

.PHONY: tinker
tinker: vendor
	./artisan tinker

.PHONY: serve
serve: vendor
	./artisan serve --host=0.0.0.0 --port=8000

.PHONY: clean-composer
clean-composer:
	rm -rf ./vendor
	rm -rf ./composer.lock

.PHONY: clean-tools
clean-tools:
	rm -rf ./tools/*/vendor
	rm -rf ./tools/*/node_modules
	rm -rf ./tools/*/composer.lock
	rm -rf ./tools/*/package-lock.json
	rm -rf ./tools/*/yarn.lock

.PHONY: clean-node
clean-node:
	rm -rf ./node_modules
	rm -rf ./package-lock.json
	rm -rf ./yarn.lock

.PHONY: clean
clean: clean-tools clean-composer clean-node

# Aliases
.PHONY: ci
ci: check

.PHONY: start
start: serve

.PHONY: dev
dev: serve

.PHONY: cli
cli: tinker

# Dependencies
tools: ./tools/prettier/node_modules/.bin/prettier ./tools/phpstan/vendor/bin/phpstan ./tools/php-cs-fixer/vendor/bin/php-cs-fixer ./tools/spectral/node_modules/.bin/spectral

vendor:
	${MAKE_COMPOSER} install

./tools/prettier/node_modules/.bin/prettier:
	npm --prefix=./tools/prettier install

./tools/phpstan/vendor/bin/phpstan:
	${MAKE_COMPOSER} --working-dir=./tools/phpstan install

./tools/php-cs-fixer/vendor/bin/php-cs-fixer:
	${MAKE_COMPOSER} --working-dir=./tools/php-cs-fixer install

./tools/spectral/node_modules/.bin/spectral:
	npm --prefix=./tools/spectral install
