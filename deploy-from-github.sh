#!/bin/bash

echo "=========================================="
echo "Deploy from GitHub to Server"
echo "=========================================="
echo ""

cd /var/www/jobone

echo "1. Pulling latest changes from GitHub..."
git pull origin main

if [ $? -ne 0 ]; then
    echo "❌ Git pull failed"
    exit 1
fi

echo "✓ Latest changes pulled"
echo ""

echo "2. Fixing permissions..."
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
echo "✓ Permissions fixed"
echo ""

echo "3. Clearing caches..."
php artisan config:clear
sudo php artisan cache:clear
php artisan view:clear
echo "✓ Caches cleared"
echo ""

echo "4. Restarting PHP-FPM..."
sudo systemctl restart php8.2-fpm
echo "✓ PHP-FPM restarted"
echo ""

echo "5. Testing domains..."
echo -n "karnatakajob.online: "
curl -s -o /dev/null -w "%{http_code}" https://karnatakajob.online
echo ""
echo -n "jobone.in: "
curl -s -o /dev/null -w "%{http_code}" https://jobone.in
echo ""

echo ""
echo "=========================================="
echo "✅ Deployment Complete!"
echo "=========================================="
echo ""
echo "Verify in browser:"
echo "• https://karnatakajob.online → Karnataka jobs only"
echo "• https://jobone.in → All jobs"
echo ""
