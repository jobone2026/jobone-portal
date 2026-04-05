#!/bin/bash

echo "🚀 Deploying improved jobs listing page..."
echo ""

# Navigate to project directory
cd /var/www/jobone

# Pull latest changes
echo "📥 Pulling latest changes from GitHub..."
git pull origin main

# Clear all caches
echo "🧹 Clearing caches..."
sudo php artisan view:clear
sudo php artisan cache:clear
sudo php artisan config:clear

# Fix permissions
echo "🔐 Fixing permissions..."
sudo chown -R www-data:www-data storage bootstrap/cache

# Restart services
echo "🔄 Restarting services..."
sudo service php8.2-fpm restart
sudo service nginx restart

echo ""
echo "✅ Deployment complete!"
echo ""
echo "🌐 Test the jobs listing page at:"
echo "   https://jobone.in/jobs"
echo "   https://jobone.in/admit-cards"
echo "   https://jobone.in/results"
echo ""
echo "💡 If changes don't appear, clear browser cache (Ctrl+Shift+R or F12 → Empty Cache and Hard Reload)"
