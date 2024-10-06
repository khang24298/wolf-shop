docker compose up -d
docker exec -it wolfshop-app sh -c 'sleep 1 && php artisan migrate --seed'