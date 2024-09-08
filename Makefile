# Default shell
SHELL := /bin/bash

# Variables
MAKE_PHP_8_3_BIN ?= php8.3
MAKE_COMPOSER_2_BIN ?= /usr/local/bin/composer2

MAKE_PHP ?= ${MAKE_PHP_8_3_BIN}
MAKE_COMPOSER ?= ${MAKE_PHP} ${MAKE_COMPOSER_2_BIN}
MAKE_ARTISAN ?= ${MAKE_PHP} ./artisan

# Default goal
.DEFAULT_GOAL := panic

# Goals
.PHONY: check
check: stan lint audit test

.PHONY: audit
audit: ./vendor ./composer.lock ./node_modules ./package-lock.json
	${MAKE_COMPOSER} audit
	${MAKE_COMPOSER} check-platform-reqs
	${MAKE_COMPOSER} validate --strict --no-check-all
	npm audit --audit-level info

.PHONY: stan
stan: ./vendor/bin/phpstan ./node_modules/.bin/spectral
	${MAKE_PHP} ./vendor/bin/phpstan analyse
	./node_modules/.bin/spectral lint --fail-severity=hint ./public/docs/openapi*

.PHONY: lint
lint: ./node_modules/.bin/prettier ./vendor/bin/php-cs-fixer
	./node_modules/.bin/prettier --plugin=@prettier/plugin-xml --xml-quote-attributes=double --xml-whitespace-sensitivity=ignore -c .
	${MAKE_PHP} ./vendor/bin/php-cs-fixer fix --dry-run --diff

.PHONY: fix
fix: ./node_modules/.bin/prettier ./vendor/bin/php-cs-fixer
	./node_modules/.bin/prettier --plugin=@prettier/plugin-xml --xml-quote-attributes=double --xml-whitespace-sensitivity=ignore --plugin=@prettier/plugin-php --php-version=8.2 -w .
	${MAKE_PHP} ./vendor/bin/php-cs-fixer fix

.PHONY: test
test: ./vendor/bin/phpunit ./.env
	${MAKE_ARTISAN} optimize:clear
	${MAKE_ARTISAN} cache:clear
	${MAKE_ARTISAN} config:clear
	${MAKE_ARTISAN} event:clear
	${MAKE_ARTISAN} route:clear
	${MAKE_ARTISAN} view:clear
	${MAKE_ARTISAN} clear-compiled
	${MAKE_ARTISAN} test

.PHONY: clean
clean:
	rm -rf ./node_modules
	rm -rf ./package-lock.json
	rm -rf ./vendor
	rm -rf ./composer.lock

# Deploy / Release
.PHONY: local
local: ./.env
	${MAKE_COMPOSER} update
	npm update --install-links
	${MAKE_ARTISAN} optimize:clear
	${MAKE_ARTISAN} cache:clear
	${MAKE_ARTISAN} config:clear
	${MAKE_ARTISAN} event:clear
	${MAKE_ARTISAN} route:clear
	${MAKE_ARTISAN} view:clear
	${MAKE_ARTISAN} clear-compiled
	${MAKE_ARTISAN} migrate --force
	${MAKE_ARTISAN} db:seed --force
	${MAKE_ARTISAN} storage:link --force
	${MAKE_ARTISAN} queue:restart
	${MAKE_ARTISAN} up

.PHONY: testing
testing: local

.PHONY: development
development: ./.env
	${MAKE_COMPOSER} update
	npm update --install-links
	${MAKE_ARTISAN} optimize:clear
	${MAKE_ARTISAN} cache:clear
	${MAKE_ARTISAN} config:clear
	${MAKE_ARTISAN} event:clear
	${MAKE_ARTISAN} route:clear
	${MAKE_ARTISAN} view:clear
	${MAKE_ARTISAN} clear-compiled
	${MAKE_ARTISAN} migrate --force
	${MAKE_ARTISAN} db:seed --force
	${MAKE_COMPOSER} update -a --no-dev
	npm update --omit dev --install-links
	${MAKE_ARTISAN} optimize
	${MAKE_ARTISAN} config:cache
	${MAKE_ARTISAN} event:cache
	${MAKE_ARTISAN} route:cache
	${MAKE_ARTISAN} view:cache
	${MAKE_ARTISAN} storage:link --force
	${MAKE_ARTISAN} queue:restart
	${MAKE_ARTISAN} up

.PHONY: staging
staging: development

.PHONY: production
production: development

.PHONY: serve
serve: local
	${MAKE_ARTISAN} serve --host=0.0.0.0 --port=8000

# Dependencies
./vendor ./composer.lock ./vendor/bin/phpstan ./vendor/bin/php-cs-fixer ./vendor/bin/phpunit:
	${MAKE_COMPOSER} update

./node_modules ./package-lock.json ./node_modules/.bin/prettier ./node_modules/.bin/spectral:
	npm update --install-links
