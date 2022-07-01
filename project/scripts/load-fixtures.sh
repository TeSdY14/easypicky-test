#!/usr/bin/env bash

docker-compose exec api bin/console doctrine:schema:drop --force
docker-compose exec api bin/console doctrine:schema:create
docker-compose exec api bin/console hautelook:fixtures:load --no-interaction
