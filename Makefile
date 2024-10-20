BIN = ./vendor/bin
SAIL = $(BIN)/sail

## —— 🎵 🐳 The Symfony-docker Makefile 🐳 🎵 ——————————————————————————————————
help: ## Outputs this help screen
	@grep -E '(^[a-zA-Z0-9_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

# Docker --------------------------------------------------------------------- #
up:
	$(SAIL) up -d

down:
	$(SAIL) down

rebuild: ## rebuilds docker
	make down;
	$(SAIL) build --no-cache;
	make restart;

restart:  ## restarts docker image
	make down;make up;

# App ------------------------------------------------------------------------ #
local-setup:  ## setup local environment
	$(SAIL) artisan key:generate;
	$(SAIL) artisan storage:link;
	make migrate;

post-pull:
	$(SAIL) composer install;
	make migrate;
	make restart;
	make clean;

local-update: ## updates local repo
	$(SAIL) composer install;
	$(SAIL) artisan migrate
	make restart;
	make clean;

migrate: ## runs the migrations with seeding
	$(SAIL) artisan migrate:fresh --seed;

clean: ## clean the cache, views, config and routes
	$(SAIL) artisan view:clear;
	$(SAIL) artisan config:clear;
	$(SAIL) artisan optimize:clear;
	$(SAIL) artisan route:clear;

test: ## Run the tests
	$(SAIL) artisan test;

# Linters-php ---------------------------------------------------------------- #
stan: ## runs phpstan
	$(SAIL) php -d memory_limit=-1 $(BIN)/phpstan analyse;

ide-helper: ## runs the ide helper
	$(SAIL) artisan ide-helper:models --write --smart-reset;


# --set-baseline
stan-sbl: ## setting baseline with phpstan
	$(SAIL) php -d memory_limit=-1 $(BIN)/phpstan analyse --generate-baseline;

cs-fixer: ## running cs-fixer
	$(SAIL) php $(BIN)/php-cs-fixer fix --config ./.php-cs-fixer --allow-risky=yes;

rector :## running php rector
	$(SAIL) php $(BIN)/rector process;

pmd: ## Run the PHP mess detector
	$(SAIL) php $(BIN)/phpmd ./app text codesize;

sniffer: ## Run the php code sniffer and fixes anything it can
	$(SAIL) php -d memory_limit=-1 $(BIN)/phpcbf --colors  app
	$(SAIL) php -d memory_limit=-1 $(BIN)/phpcbf --colors  routes
	$(SAIL) php -d memory_limit=-1 $(BIN)/phpcbf --colors  database


security-checker: ## Runs the security checker
	$(SAIL) exec laravel.test ./local-php-security-checker

# Ci ------------------------------------------------------------------------- #
ci: ## Runs all the checkers and mess detector and tests before push
	$(SAIL) composer dump;
	make rector;
	make ide-helper;
#	make stan;
	make cs-fixer;
	make sniffer;
	make pmd;
	make security-checker;
	make test;
