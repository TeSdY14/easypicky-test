#!/usr/bin/env bash

docker-compose exec -e APP_ENV=test api bin/console  doctrine:schema:drop --force
docker-compose exec -e APP_ENV=test api bin/console  doctrine:schema:create
docker-compose exec -e APP_ENV=test api bin/console  hautelook:fixtures:load --no-interaction
