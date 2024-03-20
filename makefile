DOCKER_ENABLED=1
PHPSTAN_CONFIGURATION_FILE=phpstan.neon

include .boing/makes/boing.mk
include .boing/makes/symfony.mk

phpunit-coverage:
	$(php) bin/phpunit --coverage-html=var/coverage
