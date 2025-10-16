SHELL = /bin/sh

build:
	@docker-compose build

up:
	@docker-compose up -d

down:
	@docker-compose down --remove-orphans

composer-install:
	@docker-compose exec -ti php composer install

composer-update:
	@docker-compose exec -ti php composer update

fixer:
	@docker-compose exec -ti php vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.php -v

test:
	@docker-compose exec -ti php vendor/bin/phpunit

test-deprecations:
	@docker-compose exec -ti php vendor/bin/phpunit --display-deprecations

test-with-coverage:
	@docker-compose exec -e XDEBUG_MODE=coverage -ti php vendor/bin/phpunit --coverage-html var

sh:
	@docker-compose exec -ti php /bin/sh