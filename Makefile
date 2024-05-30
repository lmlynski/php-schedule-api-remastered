current-dir := $(dir $(abspath $(lastword $(MAKEFILE_LIST))))
SHELL = /bin/sh
docker-container = schedule_php_remastered

help: ## Show make targets
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_\-\/]+:.*?## / {sub("\\\\n",sprintf("\n%22c"," "), $$2);printf " \033[36m%-24s\033[0m  %s\n", $$1, $$2}' $(MAKEFILE_LIST)

start: ## Start and run project
	docker compose up -d

stop: ## Stop project
	docker compose down --remove-orphans -v

install: ## Install dependencies
	docker exec $(docker-container) composer install

all: ## Start and run project
	$(MAKE) start
	$(MAKE) install