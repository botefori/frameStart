APP_NAME ?= framework
DOCKER_NETWORK ?= framework

up:
	docker-compose up -d

down:
	docker-compose down

clear:
	docker-compose down -v


init:
	docker-compose run --rm framework composer install --no-interaction
