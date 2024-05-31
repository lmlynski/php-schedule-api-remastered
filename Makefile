current-dir := $(dir $(abspath $(lastword $(MAKEFILE_LIST))))
SHELL = /bin/sh
docker-container = schedule_php_remastered

help: ## Show make targets
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_\-\/]+:.*?## / {sub("\\\\n",sprintf("\n%22c"," "), $$2);printf " \033[36m%-24s\033[0m  %s\n", $$1, $$2}' $(MAKEFILE_LIST)

start: ## Start project
	docker compose up -d

install: ## Install dependencies
	docker exec $(docker-container) composer install -o

prepare: ## Set up project data
	docker exec $(docker-container) composer install -o

syntax: ## Check syntax
	docker exec $(docker-container) vendor/bin/php-cs-fixer fix --dry-run --diff --config .php-cs-fixer.dist.php --verbose
	docker exec $(docker-container) vendor/bin/phpstan analyse

test: ## Run tests
	docker exec $(docker-container) bin/phpunit tests

stop: ## Stop project
	docker compose down --remove-orphans -v

run: ## Start and run project
	$(MAKE) start
	$(MAKE) install
	$(MAKE) prepare

all: ## Make full circle (start, install, prepare, run syntax check and tests and stop the project)
	$(MAKE) start
	$(MAKE) install
	$(MAKE) prepare
	$(MAKE) syntax
	$(MAKE) test
	$(MAKE) stop
