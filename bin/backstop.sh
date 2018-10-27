#!/bin/bash

if [ $1 = "open" ]; then
	open backstop_data/html_report/index.html
else
	docker-compose run --rm backstopjs "$@"
fi
