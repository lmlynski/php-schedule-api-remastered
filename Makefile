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

test: ## Run tests
	docker exec $(docker-container) bin/phpunit tests

stop: ## Stop project
	docker compose down --remove-orphans -v

run: ## Start and run project
	$(MAKE) start
	$(MAKE) install
	$(MAKE) prepare

all: ## Make full circle (start, prepare, run tests and stop the project_
	$(MAKE) start
	$(MAKE) install
	$(MAKE) prepare
	$(MAKE) test
	$(MAKE) stop