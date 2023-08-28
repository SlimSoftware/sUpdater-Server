#!/bin/bash
cp -n .env.example .env
docker exec supdater-server-php-1 php artisan key:generate --force
docker exec supdater-server-php-1 chown -R /var/www/html/
docker exec supdater-server-php-1 chmod -R 775 /var/www/html/bootstrap/cache/
docker exec supdater-server-php-1 chmod -R 775 /var/www/html/storage/