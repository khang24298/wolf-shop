docker-compose down --remove-orphans
docker-compose -f docker-compose.yml up -d
time docker exec -it wolfshop-app sh -c 'sleep 3 && php artisan migrate'