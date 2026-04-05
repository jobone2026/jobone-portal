#!/bin/bash
# Deploy fix for Organization, Total Vacancies, and Last Date fields

echo "=== Deploying Post Fields Fix ==="

cd /var/www/jobone

# Pull latest changes from GitHub
echo "Pulling latest changes..."
git pull origin main

# Clear all caches
echo "Clearing caches..."
php artisan view:clear
php artisan cache:clear
php artisan config:clear
php artisan route:clear

# Restart services
echo "Restarting services..."
sudo service php8.2-fpm restart
sudo service nginx restart

echo ""
echo "✓ Deployment complete!"
echo ""
echo "What was fixed:"
echo "- Organization field now saves properly"
echo "- Total Vacancies field now saves properly"
echo "- Last Date field now saves properly"
echo "- Notification Date field added to form"
echo "- All fields now display on public pages"
echo ""
echo "Test by creating a new post in admin panel:"
echo "https://jobone.in/admin/posts/create"
