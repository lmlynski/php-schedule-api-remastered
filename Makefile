DOCKER_BUILD_VARS := COMPOSE_DOCKER_CLI_BUILD=1 DOCKER_BUILDKIT=1
DOCKER_BUILD := ${DOCKER_BUILD_VARS} docker build
DOCKER_COMPOSE := $(DOCKER_BUILD_VARS) docker-compose
DOCKER_PHP_CONTAINER = schedule_api_remastered_php

# Phony targets
.PHONY: help start install prepare syntax test bash stop destroy run all

help: ## Show make targets
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_\-\/]+:.*?## / {sub("\\\\n",sprintf("\n%22c"," "), $$2); printf " \033[36m%-24s\033[0m  %s\n", $$1, $$2}' $(MAKEFILE_LIST)

start: ## Start containers
	@echo "Starting containers..."
	${DOCKER_COMPOSE} up -d --build --remove-orphans

install: ## Install dependencies
	@echo "Installing dependencies..."
	${DOCKER_COMPOSE} run --rm php composer install -o

prepare: ## Set up project startup data
	@echo "Setting up project startup data..."
	@test -s .env && echo ".env already exists" || (echo "Copying .env.dist to .env" && cp -n .env.dist .env)
	@test -s var/db.json && echo "var/db.json already exists" || (echo "Copying data/db.json to var/db.json" && cp -n data/db.json var/db.json)

syntax: ## Check syntax
	@echo "Checking syntax..."
	docker exec $(DOCKER_PHP_CONTAINER) vendor/bin/php-cs-fixer fix --dry-run --diff --config .php-cs-fixer.dist.php --verbose
	docker exec $(DOCKER_PHP_CONTAINER) vendor/bin/phpstan analyse
	docker exec $(DOCKER_PHP_CONTAINER) vendor/bin/phpmd src,tests ansi phpmd.xml

test: ## Run tests
	@echo "Running tests..."
	${DOCKER_COMPOSE} run --rm php php bin/phpunit tests

bash: ## Access php container shell
	@echo "Accessing php container shell..."
	${DOCKER_COMPOSE} run php bash

stop: ## Stop project
	@echo "Stopping project..."
	${DOCKER_COMPOSE} down --remove-orphans -v

destroy: stop ## Remove containers and volumes
	@echo "Removing containers and volumes..."
	${DOCKER_COMPOSE} rm --force --stop -v

run: ## Start and run project
	@echo "Start the project..."
	$(MAKE) prepare
	$(MAKE) start
	$(MAKE) install

all: ## Make full circle (prepare env, start, install, run syntax check and tests and stop the project)
	@echo "Running full project lifecycle..."
	$(MAKE) prepare
	$(MAKE) start
	$(MAKE) install
	$(MAKE) syntax
	$(MAKE) test
	$(MAKE) stop
