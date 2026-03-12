#!/bin/bash

echo "=========================================="
echo "Deploying Latest Jobs Carousel"
echo "=========================================="

# Pull latest changes
echo "Pulling latest changes from GitHub..."
git pull origin main

# Clear caches
echo "Clearing Laravel caches..."
php artisan view:clear
php artisan cache:clear
php artisan config:clear

# Restart PHP-FPM
echo "Restarting PHP-FPM..."
sudo systemctl restart php8.2-fpm

echo ""
echo "=========================================="
echo "✅ Deployment Complete!"
echo "=========================================="
echo ""
echo "Changes deployed:"
echo "  ✓ Latest jobs carousel added to header"
echo "  ✓ Scroll navigation (left/right arrows)"
echo "  ✓ Today's date and day name displayed"
echo "  ✓ Clickable job links"
echo ""
echo "Visit: https://jobone.in to see the changes"
echo ""
