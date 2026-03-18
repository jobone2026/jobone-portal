#!/bin/bash

echo "=========================================="
echo "Domain Filtering - Deployment Fix Script"
echo "=========================================="
echo ""

# Check if we're in the right directory
if [ ! -f "artisan" ]; then
    echo "❌ Error: Not in Laravel root directory"
    echo "Please cd to /var/www/govt-job-portal-new first"
    exit 1
fi

echo "1. Fixing storage permissions..."
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
echo "✓ Permissions fixed"
echo ""

echo "2. Clearing configuration cache..."
php artisan config:clear
echo "✓ Config cache cleared"
echo ""

echo "3. Clearing application cache..."
sudo php artisan cache:clear
echo "✓ Application cache cleared"
echo ""

echo "4. Clearing view cache..."
php artisan view:clear
echo "✓ View cache cleared"
echo ""

echo "5. Reloading systemd daemon..."
sudo systemctl daemon-reload
echo "✓ Daemon reloaded"
echo ""

echo "6. Restarting PHP-FPM..."
sudo systemctl restart php8.2-fpm
echo "✓ PHP-FPM restarted"
echo ""

echo "7. Checking PHP-FPM status..."
sudo systemctl status php8.2-fpm --no-pager | head -n 5
echo ""

echo "8. Running verification script..."
php verify-domain-filter.php
echo ""

echo "=========================================="
echo "Deployment Fix Complete!"
echo "=========================================="
