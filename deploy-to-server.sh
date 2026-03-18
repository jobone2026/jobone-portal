#!/bin/bash

# Deployment script for karnatakajob.online domain filtering
# This script resolves conflicts and deploys the latest code

echo "=== Starting Deployment ==="

cd /var/www/jobone

# Step 1: Backup current state
echo "Step 1: Creating backup..."
git stash save "backup-before-deploy-$(date +%Y%m%d-%H%M%S)"

# Step 2: Pull latest changes
echo "Step 2: Pulling latest changes from GitHub..."
git pull origin main

# Step 3: Clear all caches
echo "Step 3: Clearing caches..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Step 4: Restart PHP-FPM
echo "Step 4: Restarting PHP-FPM..."
sudo systemctl restart php8.2-fpm

# Step 5: Test both domains
echo ""
echo "=== Deployment Complete ==="
echo ""
echo "Testing karnatakajob.online (should show ONLY Karnataka):"
curl -s https://karnatakajob.online | grep -o 'state-box">[^<]*</a' | head -5
echo ""
echo "Testing jobone.in (should show ALL states):"
curl -s https://jobone.in | grep -o 'state-box">[^<]*</a' | head -5
echo ""
echo "Done!"
