#!/bin/bash

# Fix Website 500 Error
# Run this on server: bash fix-website-500.sh

echo "🔧 Fixing website 500 error..."

# Pull latest code
echo "📥 Pulling latest code..."
git pull portal main

# Check if NotificationService exists
if [ ! -f "app/Services/NotificationService.php" ]; then
    echo "❌ ERROR: NotificationService.php is missing!"
    echo "This file should exist. Checking git..."
    git checkout HEAD -- app/Services/NotificationService.php
fi

# Check if TestNotification exists
if [ ! -f "app/Console/Commands/TestNotification.php" ]; then
    echo "❌ ERROR: TestNotification.php is missing!"
    git checkout HEAD -- app/Console/Commands/TestNotification.php
fi

# Clear all caches
echo "🧹 Clearing caches..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Restart PHP-FPM
echo "🔄 Restarting PHP-FPM..."
sudo systemctl restart php8.2-fpm

# Check website status
echo "✅ Checking website..."
curl -I https://jobone.in

echo ""
echo "✨ Done! Check if website is working now."
