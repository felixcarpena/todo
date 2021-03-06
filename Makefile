include .env

COMPOSER=composer
CONTAINER-REGULAR-USER=docker exec -w /app -itu docker todo-php
CONTAINER-ROOT-USER=docker exec -w /app -it todo-php

### COMPOSER ###
.PHONY: composer
composer: disdebug
	$(CONTAINER-REGULAR-USER) $(COMPOSER) $(cmd)

### COMPOSER-INSTALL ###
.PHONY: composer-install
composer-install:
	docker run --rm -it -v $$PWD:/app -u $(id -u):$(id -g) composer install --ignore-platform-reqs

### EXECUTION HELPER ###
.PHONY: php
php: disdebug
	$(CONTAINER-REGULAR-USER) php $(cmd)

### EXECUTION DEBUGING HELPER ###
.PHONY: dphp
dphp: endebug
	$(CONTAINER-REGULAR-USER) bin/cli-debug.sh $(cmd)

### XDEBUG (en/dismod is not available)###
.PHONY: disdebug
disdebug:
	$(CONTAINER-ROOT-USER) rm -rf /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

### XDEBUG (enable debug)###
.PHONY: endebug
endebug:
	$(CONTAINER-ROOT-USER) docker-php-ext-enable xdebug

### EXECUTION SPEC TEST SUITE ###
.PHONY: phpspec
phpspec: disdebug
	$(CONTAINER-REGULAR-USER) vendor/bin/phpspec --config=phpspec.yml run

### EXECUTION SPEC TEST SUITE ###
.PHONY: behat
behat: disdebug
	$(CONTAINER-REGULAR-USER) vendor/bin/behat -c behat.yml --format progress -vv

### EXECUTION UNIT TEST SUITE ###
.PHONY: phpunit
phpunit: disdebug
	$(CONTAINER-REGULAR-USER) vendor/bin/phpunit --config=phpunit.xml

### COVERALL - PHP ###
.PHONY: coverall
coverall:
	docker exec -w /app --env COVERALLS_REPO_TOKEN=$(COVERALLS_REPO_TOKEN) -it todo-php php vendor/bin/php-coveralls --coverage_clover=build/clover.xml --json_path=build/coveralls-upload.json -v

### UP CONTAINERS ###
.PHONY: containers
containers:
	docker-compose up -d

### REMOVE CONTAINERS ###
.PHONY: containers-rm
containers-rm:
	docker-compose stop && docker-compose rm -f

### RUN TEST SUITES ###
.PHONY: tests
tests: disdebug phpunit phpspec behat

### PHP CONTAINER SHELL ###
.PHONY: php-shell
php-shell:
	$(CONTAINER-REGULAR-USER) zsh

### INIT DATABASE ###
.PHONY: init-database
init-database:
	$(CONTAINER-REGULAR-USER) bin/console doctrine:database:create && bin/console doctrine:schema:create && yes | bin/console doctrine:migrations:migrate
