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
	${MAKE_COMPOSER} audit

.PHONY: stan
stan: vendor tools
	${MAKE_PHP} tools/phpstan/vendor/bin/phpstan analyse
	"tools/spectral/node_modules/.bin/spectral" lint --fail-severity=hint public/docs/openapi*

.PHONY: lint
lint: vendor tools
	${MAKE_COMPOSER} validate --strict
	"tools/prettier-lint/node_modules/.bin/prettier" -c .
	${MAKE_PHP} tools/php-cs-fixer/vendor/bin/php-cs-fixer fix --dry-run --diff

.PHONY: test
test: vendor clear
	${MAKE_ARTISAN} test

.PHONY: fix
fix: vendor tools
	"tools/prettier-fix/node_modules/.bin/prettier" -w .
	${MAKE_PHP} tools/php-cs-fixer/vendor/bin/php-cs-fixer fix

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
	${MAKE_ARTISAN} optimize:clear
	${MAKE_ARTISAN} cache:clear
	${MAKE_ARTISAN} config:clear
	${MAKE_ARTISAN} event:clear
	${MAKE_ARTISAN} route:clear
	${MAKE_ARTISAN} view:clear
	${MAKE_ARTISAN} clear-compiled

.PHONY: migrate
migrate: vendor
	${MAKE_ARTISAN} migrate --force

.PHONY: seed
seed: vendor
	${MAKE_ARTISAN} db:seed --force

.PHONY: optimize
optimize: vendor
	${MAKE_ARTISAN} optimize
	${MAKE_ARTISAN} config:cache
	${MAKE_ARTISAN} event:cache
	${MAKE_ARTISAN} route:cache
	${MAKE_ARTISAN} view:cache

.PHONY: storage
storage: vendor
	${MAKE_ARTISAN} storage:link --force

.PHONY: queue
queue: vendor
	${MAKE_ARTISAN} queue:restart

.PHONY: down
down: vendor
	${MAKE_ARTISAN} down

.PHONY: up
up: vendor
	${MAKE_ARTISAN} up

.PHONY: tinker
tinker: vendor
	${MAKE_ARTISAN} tinker

.PHONY: serve
serve: vendor
	${MAKE_ARTISAN} serve

.PHONY: clean-composer
clean-composer:
	git clean -xfd vendor composer.lock

.PHONY: update-composer
update-composer: clean-composer
	${MAKE_COMPOSER} update

.PHONY: clean-tools
clean-tools:
	git clean -xfd tools

.PHONY: update-tools
update-tools: clean-tools tools

.PHONY: update
update: update-tools update-composer

.PHONY: clean
clean: clean-tools clean-composer
	git clean -xfd public

# Aliases
.PHONY: start
start: serve

.PHONY: ci
ci: check

.PHONY: update-full
update-full: update

# Dependencies
tools: tools/prettier-lint/node_modules/.bin/prettier tools/prettier-fix/node_modules/.bin/prettier tools/phpstan/vendor/bin/phpstan tools/php-cs-fixer/vendor/bin/php-cs-fixer tools/spectral/node_modules/.bin/spectral

tools/prettier-lint/node_modules/.bin/prettier:
	npm --prefix=tools/prettier-lint update

tools/prettier-fix/node_modules/.bin/prettier:
	npm --prefix=tools/prettier-fix update

vendor:
	${MAKE_COMPOSER} install

tools/phpstan/vendor/bin/phpstan:
	${MAKE_COMPOSER} --working-dir=tools/phpstan update

tools/php-cs-fixer/vendor/bin/php-cs-fixer:
	${MAKE_COMPOSER} --working-dir=tools/php-cs-fixer update

tools/spectral/node_modules/.bin/spectral:
	npm --prefix=tools/spectral update
