#!/bin/bash

docker-compose up --build

docker-compose exec app php artisan key:generate
docker-compose exec app php artisan migrate
