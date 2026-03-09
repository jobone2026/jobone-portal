#!/bin/bash

# Quick fix script for Vite manifest issue on current server
# Run this on your AWS Lightsail server (3.108.161.67)

set -e

APP_DIR="/var/www/jobone"

echo "=========================================="
echo "Fixing Vite Manifest Issue"
echo "=========================================="

cd $APP_DIR

# Fix the manifest file location
echo "Copying manifest file..."
if [ -f "public/build/.vite/manifest.json" ]; then
    sudo cp public/build/.vite/manifest.json public/build/manifest.json
    echo "✓ Manifest copied"
else
    echo "✗ Manifest file not found at public/build/.vite/manifest.json"
    exit 1
fi

# Fix ownership of the entire public/build directory
echo "Fixing public/build ownership..."
sudo chown -R www-data:www-data public/build
sudo chmod -R 775 public/build
echo "✓ Ownership fixed"

# Fix storage permissions
echo "Fixing storage permissions..."
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
echo "✓ Storage permissions fixed"

# Clear all caches
echo "Clearing caches..."
sudo -u www-data php artisan config:clear
sudo -u www-data php artisan cache:clear
sudo -u www-data php artisan view:clear
echo "✓ Caches cleared"

# Restart PHP-FPM
echo "Restarting PHP-FPM..."
sudo systemctl restart php8.2-fpm
echo "✓ PHP-FPM restarted"

echo ""
echo "=========================================="
echo "Fix Complete!"
echo "=========================================="
echo ""
echo "Your website should now be accessible at:"
echo "http://3.108.161.67"
echo ""
echo "Admin panel:"
echo "http://3.108.161.67/admin/login"
echo "Email: admin@jobone.in"
echo "Password: Admin@123"
echo ""
echo "If you haven't created the admin user yet, run:"
echo "sudo -u www-data php artisan tinker"
echo "Then paste:"
echo "\$admin = new App\\Models\\Admin();"
echo "\$admin->name = 'Admin';"
echo "\$admin->email = 'admin@jobone.in';"
echo "\$admin->password = bcrypt('Admin@123');"
echo "\$admin->save();"
echo "exit"
echo ""
