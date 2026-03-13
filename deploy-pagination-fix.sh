#!/bin/bash

echo "🚀 Deploying pagination fix..."

# Pull latest changes
git pull portal main

# Clear caches
php artisan view:clear
php artisan cache:clear
php artisan config:clear

# Restart PHP-FPM
sudo systemctl restart php8.2-fpm

echo "✅ Pagination fix deployed successfully!"
echo "📝 Changes:"
echo "   - Updated posts index to use custom pagination view"
echo "   - Pagination should now display correctly on all posts pages"
