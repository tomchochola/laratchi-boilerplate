# Default shell
SHELL := /bin/bash

# Variables
MAKE_PHP_8_2_BIN ?= php8.2
MAKE_COMPOSER_2_BIN ?= /usr/local/bin/composer2

MAKE_PHP ?= ${MAKE_PHP_8_2_BIN}
MAKE_COMPOSER ?= ${MAKE_PHP} ${MAKE_COMPOSER_2_BIN}
MAKE_ARTISAN ?= ${MAKE_PHP} artisan

# Default goal
.DEFAULT_GOAL := assert-never

# Goals
.PHONY: check
check: stan test lint audit

.PHONY: audit
audit: vendor tools
	${MAKE_COMPOSER} audit --no-interaction

.PHONY: stan
stan: vendor tools
	${MAKE_PHP} tools/phpstan/vendor/bin/phpstan analyse --no-progress --no-interaction
	tools/spectral/node_modules/.bin/spectral lint --fail-severity=hint public/docs/openapi*

.PHONY: lint
lint: vendor tools
	${MAKE_COMPOSER} validate --strict --no-interaction
	tools/prettier-lint/node_modules/.bin/prettier -c .
	${MAKE_PHP} tools/php-cs-fixer/vendor/bin/php-cs-fixer fix --dry-run --diff --no-interaction

.PHONY: test
test: vendor clear
	${MAKE_ARTISAN} test --exclude-group integration --no-interaction

.PHONY: test-integration
test-integration: vendor clear
	${MAKE_ARTISAN} test --group integration --no-interaction

.PHONY: fix
fix: vendor tools
	tools/prettier-fix/node_modules/.bin/prettier -w .
	${MAKE_PHP} tools/php-cs-fixer/vendor/bin/php-cs-fixer fix --no-interaction

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
	${MAKE_COMPOSER} install -o --no-progress --no-interaction

.PHONY: composer-no-dev
composer-no-dev:
	${MAKE_COMPOSER} install --no-dev -a --no-progress --no-interaction

.PHONY: clear
clear: vendor
	${MAKE_ARTISAN} optimize:clear --no-interaction
	${MAKE_ARTISAN} cache:clear --no-interaction
	${MAKE_ARTISAN} config:clear --no-interaction
	${MAKE_ARTISAN} event:clear --no-interaction
	${MAKE_ARTISAN} route:clear --no-interaction
	${MAKE_ARTISAN} view:clear --no-interaction
	${MAKE_ARTISAN} clear-compiled --no-interaction

.PHONY: migrate
migrate: vendor
	${MAKE_ARTISAN} migrate --force --no-interaction

.PHONY: seed
seed: vendor
	${MAKE_ARTISAN} db:seed --force --no-interaction

.PHONY: optimize
optimize: vendor
	${MAKE_ARTISAN} optimize --no-interaction
	${MAKE_ARTISAN} config:cache --no-interaction
	${MAKE_ARTISAN} event:cache --no-interaction
	${MAKE_ARTISAN} route:cache --no-interaction
	${MAKE_ARTISAN} view:cache --no-interaction

.PHONY: storage
storage: vendor
	${MAKE_ARTISAN} storage:link --force --no-interaction

.PHONY: queue
queue: vendor
	${MAKE_ARTISAN} queue:restart --no-interaction

.PHONY: down
down: vendor
	${MAKE_ARTISAN} down --no-interaction

.PHONY: up
up: vendor
	${MAKE_ARTISAN} up --no-interaction

.PHONY: tinker
tinker: vendor
	${MAKE_ARTISAN} tinker --no-interaction

.PHONY: serve
serve: vendor
	${MAKE_ARTISAN} serve --no-interaction

.PHONY: clean-composer
clean-composer:
	git clean -xfd vendor composer.lock

.PHONY: update-composer
update-composer: clean-composer
	${MAKE_COMPOSER} update -o --no-progress

.PHONY: clean-tools
clean-tools:
	git clean -xfd tools

.PHONY: update-tools
update-tools: clean-tools tools

.PHONY: clean-npm
clean-npm:
	git clean -xfd package-lock.json node_modules

.PHONY: update-full
update-full: update-tools update-composer

.PHONY: clean
clean: clean-tools clean-composer clean-npm
	git clean -xfd public

# Aliases
.PHONY: start
start: serve

# Dependencies
tools: tools/prettier-lint/node_modules/.bin/prettier tools/prettier-fix/node_modules/.bin/prettier tools/phpstan/vendor/bin/phpstan tools/php-cs-fixer/vendor/bin/php-cs-fixer tools/spectral/node_modules/.bin/spectral

tools/prettier-lint/node_modules/.bin/prettier:
	npm --prefix=tools/prettier-lint update --no-progress

tools/prettier-fix/node_modules/.bin/prettier:
	npm --prefix=tools/prettier-fix update --no-progress

vendor:
	${MAKE_COMPOSER} install -o --no-progress --no-interaction

tools/phpstan/vendor/bin/phpstan:
	${MAKE_COMPOSER} --working-dir=tools/phpstan update -o --no-progress --no-interaction

tools/php-cs-fixer/vendor/bin/php-cs-fixer:
	${MAKE_COMPOSER} --working-dir=tools/php-cs-fixer update -o --no-progress --no-interaction

tools/spectral/node_modules/.bin/spectral:
	npm --prefix=tools/spectral update --no-progress
