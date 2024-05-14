#!/bin/sh

docker compose run --rm -T api sh -c '
if ! ./vendor/bin/php-cs-fixer fix --dry-run --stop-on-violation --allow-risky=yes; then
   echo "Code style violations found, fix and try again."
   exit 1
fi

echo "Code style Ok"
exit 0
'
