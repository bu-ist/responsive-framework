#!/bin/bash

if [ -z `docker ps -q --no-trunc | grep $(docker-compose ps -q wordpress-backend)` ]; then
  echo "wordpress-backend isn't running. Please try starting it with 'docker-compose up'"
else
  docker-compose exec --user=www-data wordpress-backend wp "$@"
fi


