#!/bin/bash

arg1=${1:-""}

docker-compose down

if [ "$arg1" != "down" ] ; then
	docker-compose up --build
fi
