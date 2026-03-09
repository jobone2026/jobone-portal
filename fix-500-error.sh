#!/bin/bash

echo "=========================================="
echo "Fix 500 Internal Server Error"
echo "=========================================="

cd /var/www/jobone

# Check Laravel error log
echo ""
echo "📋 Checking Laravel error log (last 30 lines):"
echo "=========================================="
sudo tail -n 30 storage/logs/laravel.log

# Check PHP error log
echo ""
echo "📋 Checking PHP error log (last 20 lines):"
echo "=========================================="
sudo tail -n 20 /var/log/php8.2-fpm.log

# Check Nginx error log
echo ""
echo "📋 Checking Nginx error log (last 20 lines):"
echo "=========================================="
sudo tail -n 20 /var/log/nginx/error.log

# Fix permissions
echo ""
echo "🔧 Fixing permissions..."
sudo chown -R www-data:ubuntu .
sudo chmod -R 755 storage bootstrap/cache
sudo chmod -R 775 storage/logs

# Clear all caches
echo ""
echo "🧹 Clearing all caches..."
sudo -u www-data php artisan cache:clear
sudo -u www-data php artisan config:clear
sudo -u www-data php artisan view:clear
sudo -u www-data php artisan route:clear

# Restart services
echo ""
echo "🔄 Restarting services..."
sudo systemctl restart php8.2-fpm
sudo systemctl restart nginx

echo ""
echo "=========================================="
echo "✅ Fix Complete!"
echo "=========================================="
echo ""
echo "Try accessing the site now: https://jobone.in"
echo ""
