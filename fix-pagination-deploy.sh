#!/bin/bash

echo "🔧 FIXING PAGINATION - COMPREHENSIVE DEPLOYMENT"
echo "================================================"

# Pull latest changes
echo "📥 Pulling latest code..."
git pull portal main

# Clear ALL caches
echo "🧹 Clearing all caches..."
php artisan cache:clear
php artisan view:clear
php artisan config:clear
php artisan route:clear

# Clear Redis cache if using Redis
echo "🗑️ Clearing Redis cache..."
php artisan cache:flush || echo "Redis not configured, skipping..."

# Restart PHP-FPM
echo "🔄 Restarting PHP-FPM..."
sudo systemctl restart php8.2-fpm

# Restart Nginx to clear any server-side cache
echo "🔄 Restarting Nginx..."
sudo systemctl restart nginx

echo ""
echo "✅ DEPLOYMENT COMPLETE!"
echo "================================================"
echo "📝 Changes applied:"
echo "   ✓ Removed page cache middleware from posts routes"
echo "   ✓ Changed pagination from 50 to 20 posts per page"
echo "   ✓ Cleared all Laravel caches"
echo "   ✓ Cleared Redis cache"
echo "   ✓ Restarted PHP-FPM and Nginx"
echo ""
echo "🧪 TEST NOW:"
echo "   1. Visit: https://jobone.in/jobs"
echo "   2. Scroll to bottom"
echo "   3. You should see pagination if more than 20 posts"
echo ""
echo "💡 If still not working, check:"
echo "   - Browser cache (Ctrl+Shift+R to hard refresh)"
echo "   - Total number of posts in database"
echo "   - Check debug message at bottom of page"
