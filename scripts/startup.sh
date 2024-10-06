docker compose up -d
time docker exec -it laravel-app sh -c 'sleep 1 && php artisan migrate --seed'