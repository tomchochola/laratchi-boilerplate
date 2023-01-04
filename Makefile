# Default shell
SHELL := /bin/bash

# Variables
MAKE_PHP_8_1_BIN ?= php8.1
MAKE_COMPOSER_2_BIN ?= /usr/local/bin/composer2

MAKE_PHP ?= ${MAKE_PHP_8_1_BIN}
MAKE_COMPOSER ?= ${MAKE_PHP} ${MAKE_COMPOSER_2_BIN}
MAKE_ARTISAN ?= ${MAKE_PHP} artisan

# Default goal
.DEFAULT_GOAL := check

# Goals
.PHONY: check
check: audit lint test

.PHONY: audit
audit: vendor tools
	tools/local-php-security-checker/vendor/bin/local-php-security-checker
	${MAKE_COMPOSER} audit

.PHONY: lint
lint: vendor tools
	tools/prettier/node_modules/.bin/prettier --ignore-path .gitignore -c . '!**/*.svg'
	${MAKE_COMPOSER} validate --strict
	${MAKE_PHP} tools/phpstan/vendor/bin/phpstan analyse
	${MAKE_PHP} tools/php-cs-fixer/vendor/bin/php-cs-fixer fix --dry-run --diff
	tools/spectral/node_modules/.bin/spectral lint --fail-severity=hint public/openapi/*

.PHONY: test
test: vendor clear
	${MAKE_ARTISAN} test --exclude-group large

.PHONY: test-large
test-large: vendor clear
	${MAKE_ARTISAN} test --group large

.PHONY: fix
fix: tools
	tools/prettier/node_modules/.bin/prettier --ignore-path .gitignore -w . '!**/*.svg'
	${MAKE_PHP} tools/php-cs-fixer/vendor/bin/php-cs-fixer fix

.PHONY: clean
clean:
	git clean -Xfd

.PHONY: cold
cold:
	git clean -xfd tools composer.lock vendor package-lock.json node_modules public bootstrap storage/framework .phpunit.result.cache

.PHONY: lukewarm
lukewarm:
	git clean -xfd composer.lock vendor package-lock.json node_modules public bootstrap storage/framework .phpunit.result.cache

.PHONY: production
production: MAKE_COMPOSER_ARGUMENTS := --no-dev -a
production: composer clear migrate seed optimize storage queue

.PHONY: staging
staging: production

.PHONY: development
development: MAKE_COMPOSER_ARGUMENTS := -a
development: composer clear migrate seed optimize storage queue

.PHONY: local
local: MAKE_COMPOSER_ARGUMENTS := -o
local: composer clear migrate seed storage queue

.PHONY: testing
testing: MAKE_COMPOSER_ARGUMENTS := -a
testing: composer clear migrate seed storage queue

.PHONY: composer
composer:
	${MAKE_COMPOSER} install ${MAKE_COMPOSER_ARGUMENTS}

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

.PHONY: update
update:
	${MAKE_COMPOSER} update ${MAKE_COMPOSER_ARGUMENTS}

.PHONY: remove-tools
remove-tools:
	rm -rf tools/*/vendor
	rm -rf tools/*/node_modules

.PHONY: update-tools
update-tools: remove-tools tools

# Aliases
.PHONY: ci
ci: check

.PHONY: start
start: serve

.PHONY: update-composer
update-composer: update

# Dependencies
tools: tools/prettier/node_modules/.bin/prettier tools/phpstan/vendor/bin/phpstan tools/php-cs-fixer/vendor/bin/php-cs-fixer tools/local-php-security-checker/vendor/bin/local-php-security-checker tools/spectral/node_modules/.bin/spectral

tools/prettier/node_modules/.bin/prettier:
	npm --prefix=tools/prettier update

vendor:
	${MAKE_COMPOSER} install ${MAKE_COMPOSER_ARGUMENTS}

tools/phpstan/vendor/bin/phpstan:
	${MAKE_COMPOSER} --working-dir=tools/phpstan update -o

tools/php-cs-fixer/vendor/bin/php-cs-fixer:
	${MAKE_COMPOSER} --working-dir=tools/php-cs-fixer update -o

tools/local-php-security-checker/vendor/bin/local-php-security-checker:
	${MAKE_COMPOSER} --working-dir=tools/local-php-security-checker update -o

tools/spectral/node_modules/.bin/spectral:
	npm --prefix=tools/spectral update
