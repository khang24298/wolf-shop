COMMAND='php artisan test '$@
docker exec -i laravel-app sh -c "$COMMAND"