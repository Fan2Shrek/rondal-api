DOCKER_ENABLED=1
PHPSTAN_CONFIGURATION_FILE=phpstan.neon

include .boing/makes/boing.mk
include .boing/makes/symfony.mk

PHP_CS_FIXER_CONFIGURATION_FILE=.php-cs-fixer.php

phpunit:
	$(php) bin/phpunit

phpunit-coverage:
	$(php) bin/phpunit --coverage-html=var/coverage

pretests: 
	$(php) bin/console --env=test doctrine:database:drop --force --if-exists
	$(php) bin/console --env=test doctrine:database:create --if-not-exists
	$(php) bin/console --env=test doctrine:schema:update --force --complete 
	$(php) bin/console --env=test cache:clear --no-warmup
