CONTAINER_NAME=payment-charge
COMPOSEV2 := $(shell docker compose version)

ifdef COMPOSEV2
    COMMAND=docker compose
else
    COMMAND=docker-compose
endif


docker-install:
	make docker-build
	make docker-up
	make docker-composer-install
	make docker-migrate
	make docker-clear

docker-up:
	$(COMMAND) up -d

docker-down:
	$(COMMAND) down

docker-bash:
	make docker-up
	docker exec -it $(CONTAINER_NAME) sh

docker-build:
	$(COMMAND) build

docker-composer-install:
	docker exec $(CONTAINER_NAME) composer install --no-interaction --no-scripts

docker-test:
ifdef FILTER
	make docker-clear
	docker exec -t $(CONTAINER_NAME) composer unit-test -- --filter="$(FILTER)"
else
	make docker-clear
	docker exec -t $(CONTAINER_NAME) composer unit-test
endif

docker-logs:
	$(COMMAND) logs --follow

docker-migrate:
	make docker-migrate-refresh
	make docker-migrate-refresh-test

docker-migrate-refresh:
	docker exec $(CONTAINER_NAME) php artisan db:wipe --env=example
	docker exec $(CONTAINER_NAME) php -d memory_limit=-1 artisan migrate --env=example --seed

docker-migrate-refresh-test:
	docker exec $(CONTAINER_NAME) php artisan db:wipe --env=test
	docker exec $(CONTAINER_NAME) php -d memory_limit=-1 artisan migrate --env=test

docker-clear:
	docker exec $(CONTAINER_NAME) sh -c "php artisan optimize:clear"

docker-coverage-html:
	make docker-up-all
	make docker-clear
	docker exec -t $(CONTAINER_NAME) composer test-coverage-html

docker-format: docker-up
	docker exec -t $(CONTAINER_NAME) composer format

docker-lint-fix:
	make docker-up
	docker exec -t $(CONTAINER_NAME) composer lint-fix
