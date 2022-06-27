set -e

composer install --dev --ignore-platform-reqs
echo "APP_KEY=" > .env
php artisan key:generate
php artisan migrate

exec apache2-foreground             # main execution