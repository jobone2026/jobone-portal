#!/bin/bash

# Quick deployment script to fix 500 error
set -e

echo "🚀 Deploying fix for jobs page 500 error..."

cd /var/www/jobone

echo "📥 Pulling latest changes..."
git pull portal main

echo "🧹 Clearing caches..."
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear

echo "🔄 Restarting PHP-FPM..."
sudo systemctl restart php8.2-fpm

echo "✅ Deployment complete!"
echo "🌐 Test at: https://jobone.in/jobs"
