#!/bin/sh
cp -n .env.example.prod .env

if ! grep -q APP_KEY .env 2>/dev/null ; then
  php artisan key:generate --force
fi

# Run the main container command
exec "$@"
