#!/bin/bash

# Fix Build Permission Issue and Deploy Language Switcher
# This script fixes the Vite build permission error and deploys the latest changes

echo "=========================================="
echo "Fix Build & Deploy Language Switcher"
echo "=========================================="

# Navigate to application directory
cd /var/www/jobone

# Pull latest changes
echo ""
echo "📥 Pulling latest changes from GitHub..."
sudo git pull origin main

# Fix ownership for build process
echo ""
echo "🔧 Fixing ownership for build process..."
sudo chown -R ubuntu:ubuntu .

# Remove old build directory if it exists
echo ""
echo "🗑️  Removing old build directory..."
rm -rf public/build

# Install/update dependencies
echo ""
echo "📦 Installing dependencies..."
npm install

# Build assets
echo ""
echo "🏗️  Building assets..."
npm run build

# Fix ownership back to www-data
echo ""
echo "🔧 Restoring ownership to www-data..."
sudo chown -R www-data:ubuntu .

# Ensure public/build has correct permissions
echo ""
echo "🔐 Setting correct permissions for public/build..."
sudo chmod -R 755 public/build
sudo chown -R www-data:ubuntu public/build

# Clear Laravel caches
echo ""
echo "🧹 Clearing Laravel caches..."
sudo -u www-data php artisan view:clear
sudo -u www-data php artisan cache:clear
sudo -u www-data php artisan config:clear

# Restart PHP-FPM
echo ""
echo "🔄 Restarting PHP-FPM..."
sudo systemctl restart php8.2-fpm

echo ""
echo "=========================================="
echo "✅ Deployment Complete!"
echo "=========================================="
echo ""
echo "Language switcher has been updated."
echo "Please test at: https://jobone.in"
echo ""
echo "To test:"
echo "1. Click the language dropdown (globe icon)"
echo "2. Select a language (HI, TE, etc.)"
echo "3. Page should translate automatically"
echo "4. Select EN to return to English"
echo ""
