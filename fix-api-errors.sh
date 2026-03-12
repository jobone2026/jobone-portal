#!/bin/bash

echo "=========================================="
echo "Fixing API Errors on Server"
echo "=========================================="

# Navigate to application directory
cd /var/www/jobone

echo ""
echo "Step 1: Checking composer dependencies..."
composer install --no-dev --optimize-autoloader

echo ""
echo "Step 2: Clearing all caches..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

echo ""
echo "Step 3: Optimizing application..."
php artisan config:cache
php artisan route:cache

echo ""
echo "Step 4: Checking Laravel logs for errors..."
tail -50 storage/logs/laravel.log

echo ""
echo "Step 5: Restarting PHP-FPM..."
sudo systemctl restart php8.2-fpm

echo ""
echo "Step 6: Checking PHP-FPM status..."
sudo systemctl status php8.2-fpm --no-pager

echo ""
echo "=========================================="
echo "✅ Fix script complete"
echo "=========================================="
echo ""
echo "Now test the API with:"
echo "curl -H 'Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a' https://jobone.in/api/categories"
