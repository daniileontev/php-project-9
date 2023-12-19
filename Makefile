PORT ?= 8000
start:
	PHP_CLI_SERVER_WORKERS=5 php -S 0.0.0.0:$(PORT) -t public
install:
	composer install

compose:
	docker-compose up

compose-bash:
	docker-compose run web bash

compose-setup: compose-build
	docker-compose run web make setup

compose-build:
	docker-compose build

compose-down:
	docker-compose down -v

lint:
	composer run-script phpcs -- --standard=PSR12 public
lint2:
	composer run-script phpcs -- --standard=PSR12 public tests

lint-fix:
	composer exec --verbose phpcbf -- --standard=PSR12 src tests

test:
	composer exec --verbose phpunit tests

test-coverage:
	composer exec --verbose phpunit tests -- --coverage-clover build/logs/clover.xml

validate:
	composer validate

autoload:
	composer dump-autoload