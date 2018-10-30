#!/bin/bash

arg1=${1:-""}

predefined_tables="wp_options,wp_users,wp_usermeta"

if [ "$arg1" = "predefined" ] ; then
	bin/wp.sh db export --add-drop-table --extended-insert=FALSE --tables=$predefined_tables - > wp-db/01_predefined.sql
else
	bin/wp.sh db export --add-drop-table --extended-insert=FALSE --exclude_tables=$predefined_tables - > wp-db/02_variable.sql
fi
