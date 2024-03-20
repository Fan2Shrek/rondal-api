DOCKER_ENABLED=1
PHPSTAN_CONFIGURATION_FILE=phpstan.neon

include .boing/makes/boing.mk
include .boing/makes/symfony.mk

phpunit:
	$(php) bin/phpunit

phpunit-coverage:
	$(php) bin/phpunit --coverage-html=var/coverage

pretests: 
	$(php) bin/console --env=test doctrine:database:drop --force --if-exists
	$(php) bin/console --env=test doctrine:database:create --if-not-exists
	$(php) bin/console --env=test doctrine:schema:update --force --complete 
