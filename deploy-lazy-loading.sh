#!/bin/bash

# Lazy Loading Deployment Script
# Run this on the server to deploy lazy loading changes

set -e

echo "🚀 Deploying Lazy Loading Feature..."

cd /var/www/jobone

echo "📥 Pulling latest changes..."
git pull portal main

echo "🧹 Clearing caches..."
php artisan cache:clear
php artisan config:clear

echo "🔄 Restarting PHP-FPM..."
sudo systemctl restart php8.2-fpm

echo "✅ Deployment complete!"
echo "🌐 Visit: https://jobone.in/admin/posts to test"
