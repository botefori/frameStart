APP_NAME ?= api
DOCKER_NETWORK ?= viparis

up:
	docker-compose up -d

down:
	docker-compose down

clear:
	docker-compose down -v


init:
	docker-compose run --rm api composer install --no-interaction
	docker-compose run --rm -w "/var/www/html" -v "${CURDIR}/site:/var/www/html" -v "${CURDIR}/docker/php70/generate-jwt.sh:/generate-jwt.sh" site /generate-jwt.sh

launch-proxy:
	docker run --network "${DOCKER_NETWORK}_default" --rm -it -v /tmp/.mitmproxy:/home/mitmproxy/.mitmproxy mitmproxy/mitmproxy