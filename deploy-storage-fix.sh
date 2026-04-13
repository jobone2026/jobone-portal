#!/bin/bash
# JobOne Storage Fix Deployment Script
# Run this after every deployment to ensure storage directories exist

set -e

echo "🔧 Fixing JobOne Storage Directories..."

# SSH to server and run commands
ssh -i .ssh/jobone2026.pem ubuntu@3.108.161.67 << 'REMOTE_COMMANDS'
    cd /var/www/jobone
    
    echo "📁 Creating storage directories..."
    sudo mkdir -p /var/www/jobone/storage/framework/{views,cache,sessions} /var/www/jobone/storage/logs
    
    echo "🔐 Setting permissions..."
    sudo chown -R www-data:www-data /var/www/jobone/storage
    sudo chmod -R 775 /var/www/jobone/storage
    
    echo "🚀 Running Laravel storage init command..."
    sudo -u www-data php artisan storage:init
    
    echo "🔄 Clearing caches..."
    sudo -u www-data php artisan cache:clear
    sudo -u www-data php artisan view:clear
    
    echo "✅ Storage fix completed!"
REMOTE_COMMANDS

echo "✅ All done! Storage directories are now properly configured."
