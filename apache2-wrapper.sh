#!/bin/bash

wp --allow-root core is-installed

if [ $? -eq 1 ]; then

	wp --allow-root core install --url=http://localhost:8080 --title="Visual Regression Site" --admin_user=admin --admin_password=password --admin_email=admin@wp.localhost --skip-email;

	wp --allow-root plugin install https://github.com/bu-ist/bu-navigation/archive/1.2.13.zip
	wp --allow-root plugin activate bu-navigation

	wp --allow-root theme activate responsive-framework-2-x

fi

exec "$@"
