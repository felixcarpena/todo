COMPOSER=composer
CONTAINER-REGULAR-USER=docker exec -w /app -itu docker todo-php
CONTAINER-ROOT-USER=docker exec -w /app -it todo-php

### COMPOSER ###
.PHONY: composer
composer: disdebug
	$(CONTAINER-REGULAR-USER) $(COMPOSER) $(cmd)

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

### UP CONTAINERS ###
.PHONY: containers
containers:
	docker-compose up -d

### RUN TEST SUITES ###
.PHONY: tests
tests: disdebug phpunit phpspec behat

### PHP CONTAINER SHELL ###
.PHONY: php-shell
php-shell:
	$(CONTAINER-REGULAR-USER) zsh
