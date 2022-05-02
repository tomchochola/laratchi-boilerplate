# Default shell
SHELL := /bin/bash

# Variables
MAKE_PHP_8_1_BIN ?= php8.1
MAKE_COMPOSER_2_BIN ?= /usr/local/bin/composer2

MAKE_PHP ?= ${MAKE_PHP_8_1_BIN}
MAKE_COMPOSER ?= ${MAKE_PHP} ${MAKE_COMPOSER_2_BIN}

# Default goal
.DEFAULT_GOAL := check

# Goals
.PHONY: check
check: audit lint test

.PHONY: audit
audit: composer.lock tools
	tools/local-php-security-checker/vendor/bin/local-php-security-checker

.PHONY: lint
lint: vendor tools
	tools/prettier/node_modules/.bin/prettier --ignore-path .gitignore -c . '!**/*.svg'
	${MAKE_COMPOSER} validate --strict
	${MAKE_PHP} tools/phpstan/vendor/bin/phpstan analyse
	set -e; for file in composer.json tools/*/composer.json; do ${MAKE_PHP} tools/composer-normalize/vendor/bin/composer-normalize $$file --dry-run --diff --indent-size=2 --indent-style=space; done
	${MAKE_PHP} tools/php-cs-fixer/vendor/bin/php-cs-fixer fix --dry-run --diff
	tools/spectral/node_modules/.bin/spectral lint --fail-severity=hint docs/api_v1_spec.json

.PHONY: test
test: vendor vendor/bin/phpunit
	${MAKE_PHP} vendor/bin/phpunit

.PHONY: fix
fix: tools
	tools/prettier/node_modules/.bin/prettier --ignore-path .gitignore -w . '!**/*.svg'
	${MAKE_PHP} tools/php-cs-fixer/vendor/bin/php-cs-fixer fix

.PHONY: composer-normalize
composer-normalize: tools
	set -e; for file in composer.json tools/*/composer.json; do ${MAKE_PHP} tools/composer-normalize/vendor/bin/composer-normalize $$file --indent-size=2 --indent-style=space; done

.PHONY: clean
clean:
	git clean -Xfd

.PHONY: cold
cold:
	git clean -Xfd tools composer.lock vendor package-lock.json node_modules

# Aliases
.PHONY: ci
ci: check

# Dependencies
tools: tools/prettier/node_modules/.bin/prettier tools/phpstan/vendor/bin/phpstan tools/php-cs-fixer/vendor/bin/php-cs-fixer tools/composer-normalize/vendor/bin/composer-normalize tools/local-php-security-checker/vendor/bin/local-php-security-checker tools/spectral/node_modules/.bin/spectral

tools/prettier/node_modules/.bin/prettier:
	npm --prefix=tools/prettier update

composer.lock vendor vendor/bin/phpunit:
	${MAKE_COMPOSER} update

tools/phpstan/vendor/bin/phpstan:
	${MAKE_COMPOSER} --working-dir=tools/phpstan update

tools/php-cs-fixer/vendor/bin/php-cs-fixer:
	${MAKE_COMPOSER} --working-dir=tools/php-cs-fixer update

tools/composer-normalize/vendor/bin/composer-normalize:
	${MAKE_COMPOSER} --working-dir=tools/composer-normalize update

tools/local-php-security-checker/vendor/bin/local-php-security-checker:
	${MAKE_COMPOSER} --working-dir=tools/local-php-security-checker update

tools/spectral/node_modules/.bin/spectral:
	npm --prefix=tools/spectral update
