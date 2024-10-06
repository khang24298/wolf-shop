docker compose down
docker compose up -d
time docker exec -it wolfshop-app sh -c 'sleep 2 && php artisan migrate --seed'