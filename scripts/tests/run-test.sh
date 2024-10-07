docker-compose down --remove-orphans
docker-compose -f docker-compose.testing.yml up -d
COMMAND='sleep 3 && php artisan test --env=testing '$@
docker exec -i wolfshop-app sh -c "$COMMAND"