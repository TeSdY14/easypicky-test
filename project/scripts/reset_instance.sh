#!/usr/bin/env bash

docker-compose exec ep-php bin/console doctrine:database:drop --force
docker-compose exec ep-php bin/console doctrine:database:create
docker-compose exec ep-php bin/console doctrine:migration:migrate --no-interaction
docker-compose exec ep-php bin/console doctrine:fixtures:load --append --no-interaction
