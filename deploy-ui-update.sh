#!/bin/bash

# Enhanced Home Page UI Deployment Script
# Run this on the production server

echo "🚀 Deploying Enhanced Home Page UI..."
echo "========================================"

cd /var/www/jobone

# Pull latest changes
echo "⬇  Pulling latest changes from GitHub..."
git pull portal main

if [ $? -ne 0 ]; then
    echo "❌ Git pull failed!"
    exit 1
fi

# Clear view cache
echo "🧹 Clearing view cache..."
php artisan view:clear

# Restart PHP-FPM
echo "🔄 Restarting PHP-FPM..."
sudo systemctl restart php8.2-fpm

if [ $? -eq 0 ]; then
    echo "✅ Deployment successful!"
    echo ""
    echo "🎨 UI Enhancements Applied:"
    echo "  - Animated pulse effect on NEW badges"
    echo "  - Enhanced card shadows and borders"
    echo "  - Post count badges on headers"
    echo "  - Colorful hover effects"
    echo "  - Better mobile responsiveness"
    echo ""
    echo "🌐 Visit: https://jobone.in"
else
    echo "❌ PHP-FPM restart failed!"
    exit 1
fi
