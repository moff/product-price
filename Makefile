SHELL := /bin/sh # Use sh syntax
DOCKER_COMPOSE_EXEC_APP_NO_TTY := docker-compose exec -T -u laravel app
DOCKER_COMPOSE_EXEC_APP := docker-compose exec -u laravel app
DOCKER_COMPOSE_EXEC_NPM := docker-compose exec -u laravel npm
DOCKER_COMPOSE_RUN_APP_NO_TTY := docker-compose run --rm -T -u laravel app
DOCKER_COMPOSE_RUN_APP := docker-compose run --rm -u laravel app

up: ## Up doker-compose project.
# 	docker-compose -f docker-compose.dev.yml down --remove-orphans
# 	@$(MAKE) --no-print-directory bash-history
	@docker-compose up -d

art: ## Alias to artisan. Takes string.
	@$(eval CMD_ARGS = $(filter-out $@,$(MAKECMDGOALS)))
	${DOCKER_COMPOSE_EXEC_APP} php artisan ${CMD_ARGS}

exec: ## make exec.
	${DOCKER_COMPOSE_EXEC_APP} sh

npm:
	@docker-compose exec -u laravel npm sh

npm-install:
	@docker-compose run --rm npm install

npm-dev:
	@docker-compose run --rm npm run dev

npm-build:
	@docker-compose run --rm npm run build

test: ## Run tests dev environment
	@echo "Run tests"
	${DOCKER_COMPOSE_EXEC_APP} php artisan test $(if $(filter),--filter $(filter),)
