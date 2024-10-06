# docker compose down
# docker compose up -d
# time docker exec -it wolfshop-app sh -c 'sleep 2 && php artisan migrate --seed'
COMMAND='php artisan test '$@
docker exec -i wolfshop-app sh -c "$COMMAND"