#!/bin/sh

php /usr/local/bin/composer i -o --prefer-dist --no-progress

exec "$@"