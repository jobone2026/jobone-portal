#!/bin/bash

# HTML Content Fix - Server Deployment Commands
# Run these commands on your server to apply the fix

echo "================================================"
echo "  HTML Content Fix - Server Deployment"
echo "================================================"
echo ""

# Navigate to project directory
cd /var/www/jobone || cd ~/jobone || cd ~/public_html

echo "Step 1: Pull latest changes from GitHub..."
git pull origin main

echo ""
echo "Step 2: Install/Update Node dependencies..."
npm install

echo ""
echo "Step 3: Build assets (CSS & JS)..."
npm run build

echo ""
echo "Step 4: Clear Laravel caches..."
php artisan cache:clear
php artisan view:clear
php artisan config:clear
php artisan route:clear

echo ""
echo "Step 5: Optimize Laravel..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo ""
echo "Step 6: Set permissions..."
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

echo ""
echo "Step 7: Restart PHP-FPM..."
sudo systemctl restart php8.3-fpm || sudo systemctl restart php8.2-fpm || sudo systemctl restart php-fpm

echo ""
echo "================================================"
echo "  Deployment Complete!"
echo "================================================"
echo ""
echo "Test your website now - HTML content should display correctly!"
