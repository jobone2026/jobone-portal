#!/bin/bash

echo "================================================"
echo "  Fixing Server Issues"
echo "================================================"
echo ""

# Step 1: Fix git divergent branches
echo "Step 1: Fixing git divergent branches..."
cd /var/www/jobone
git config pull.rebase false
git pull origin main

echo ""
echo "Step 2: Fix permissions..."
sudo chown -R www-data:www-data /var/www/jobone
sudo chmod -R 755 /var/www/jobone
sudo chmod -R 775 /var/www/jobone/storage
sudo chmod -R 775 /var/www/jobone/bootstrap/cache

echo ""
echo "Step 3: Clear caches..."
php artisan cache:clear
php artisan view:clear
php artisan config:clear

echo ""
echo "Step 4: Optimize..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo ""
echo "Step 5: Find and restart correct PHP-FPM version..."
if systemctl list-units --type=service | grep -q "php8.2-fpm"; then
    echo "Found PHP 8.2-FPM, restarting..."
    sudo systemctl restart php8.2-fpm
elif systemctl list-units --type=service | grep -q "php8.1-fpm"; then
    echo "Found PHP 8.1-FPM, restarting..."
    sudo systemctl restart php8.1-fpm
elif systemctl list-units --type=service | grep -q "php-fpm"; then
    echo "Found PHP-FPM, restarting..."
    sudo systemctl restart php-fpm
else
    echo "PHP-FPM service not found, skipping restart"
fi

echo ""
echo "================================================"
echo "  Issues Fixed!"
echo "================================================"
