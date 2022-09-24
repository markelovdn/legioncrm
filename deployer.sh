set -e

echo "Deploying application ..."

(php artisan down --message 'Updating application') || true
    git pull origin main
php artisan up

echo "Application deployed!"
