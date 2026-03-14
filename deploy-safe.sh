#!/bin/bash

# Safe Deployment Script for JobOne.in
# Usage: ./deploy-safe.sh

echo "🚀 Starting safe deployment..."

# Backup current state
echo "📦 Creating backup..."
BACKUP_DIR="/var/www/backups/jobone-$(date +%Y%m%d-%H%M%S)"
mkdir -p /var/www/backups
cp -r /var/www/jobone $BACKUP_DIR
echo "✅ Backup created at: $BACKUP_DIR"

# Store current commit hash
cd /var/www/jobone
CURRENT_COMMIT=$(git rev-parse HEAD)
echo "📌 Current commit: $CURRENT_COMMIT"

# Pull latest changes
echo "⬇️  Pulling latest changes..."
git pull portal main

if [ $? -ne 0 ]; then
    echo "❌ Git pull failed! Aborting deployment."
    exit 1
fi

# Clear caches
echo "🧹 Clearing caches..."
php artisan view:clear
php artisan cache:clear
php artisan config:clear
php artisan route:clear

# Restart PHP-FPM
echo "🔄 Restarting PHP-FPM..."
sudo systemctl restart php8.2-fpm

# Test if site is accessible
echo "🔍 Testing site..."
HTTP_CODE=$(curl -s -o /dev/null -w "%{http_code}" https://jobone.in)

if [ "$HTTP_CODE" == "200" ]; then
    echo "✅ Deployment successful! Site is accessible."
    echo "📝 Deployed commit: $(git rev-parse HEAD)"
else
    echo "❌ Site returned HTTP $HTTP_CODE - Rolling back!"
    git reset --hard $CURRENT_COMMIT
    php artisan view:clear
    php artisan cache:clear
    sudo systemctl restart php8.2-fpm
    echo "↩️  Rolled back to: $CURRENT_COMMIT"
    exit 1
fi

echo "🎉 Deployment complete!"
