#!/bin/bash

# Quick Rollback Script for JobOne.in
# Usage: ./rollback.sh [commit-hash]
# If no commit hash provided, rolls back to previous commit

cd /var/www/jobone

if [ -z "$1" ]; then
    echo "⏮️  Rolling back to previous commit..."
    git reset --hard HEAD~1
else
    echo "⏮️  Rolling back to commit: $1"
    git reset --hard $1
fi

echo "🧹 Clearing caches..."
php artisan view:clear
php artisan cache:clear
php artisan config:clear
php artisan route:clear

echo "🔄 Restarting PHP-FPM..."
sudo systemctl restart php8.2-fpm

echo "✅ Rollback complete!"
echo "📌 Current commit: $(git rev-parse HEAD)"
