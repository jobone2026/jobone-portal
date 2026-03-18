#!/bin/bash

# Deploy Domain Filtering to /var/www/jobone
# Run this script from the govt-job-portal-new directory

echo "=========================================="
echo "Deploying Domain Filtering to Server"
echo "=========================================="
echo ""

TARGET_DIR="/var/www/jobone"

# Check if target directory exists
if [ ! -d "$TARGET_DIR" ]; then
    echo "❌ Error: $TARGET_DIR does not exist"
    exit 1
fi

echo "Target directory: $TARGET_DIR"
echo ""

# 1. Copy middleware
echo "1. Copying DomainStateFilter middleware..."
sudo cp app/Http/Middleware/DomainStateFilter.php $TARGET_DIR/app/Http/Middleware/
echo "✓ Middleware copied"
echo ""

# 2. Update bootstrap/app.php
echo "2. Updating bootstrap/app.php..."
if grep -q "DomainStateFilter" $TARGET_DIR/bootstrap/app.php; then
    echo "⚠ DomainStateFilter already registered in bootstrap/app.php"
else
    echo "Please manually add DomainStateFilter to bootstrap/app.php"
    echo "See: KARNATAKA_DOMAIN_SETUP.md for instructions"
fi
echo ""

# 3. Update controllers
echo "3. Copying updated controllers..."
sudo cp app/Http/Controllers/HomeController.php $TARGET_DIR/app/Http/Controllers/
sudo cp app/Http/Controllers/PostController.php $TARGET_DIR/app/Http/Controllers/
sudo cp app/Http/Controllers/SearchController.php $TARGET_DIR/app/Http/Controllers/
sudo cp app/Http/Controllers/CategoryController.php $TARGET_DIR/app/Http/Controllers/
echo "✓ Controllers copied"
echo ""

# 4. Copy verification script
echo "4. Copying verification script..."
sudo cp verify-domain-filter.php $TARGET_DIR/
sudo chmod +x $TARGET_DIR/verify-domain-filter.php
echo "✓ Verification script copied"
echo ""

# 5. Copy documentation
echo "5. Copying documentation..."
sudo cp DOMAIN_STATE_FILTERING.md $TARGET_DIR/
sudo cp KARNATAKA_DOMAIN_SETUP.md $TARGET_DIR/
sudo cp QUICK_DEPLOY.txt $TARGET_DIR/
sudo cp DEPLOYMENT_CHECKLIST.md $TARGET_DIR/
echo "✓ Documentation copied"
echo ""

# 6. Update .env
echo "6. Updating .env file..."
if grep -q "DOMAIN_STATE_MAP" $TARGET_DIR/.env; then
    echo "⚠ DOMAIN_STATE_MAP already exists in .env"
else
    echo "" | sudo tee -a $TARGET_DIR/.env
    echo "# Domain-specific state filtering" | sudo tee -a $TARGET_DIR/.env
    echo "DOMAIN_STATE_MAP=karnatakajob.online:karnataka,www.karnatakajob.online:karnataka" | sudo tee -a $TARGET_DIR/.env
    echo "✓ DOMAIN_STATE_MAP added to .env"
fi
echo ""

# 7. Fix permissions
echo "7. Fixing permissions..."
sudo chown -R www-data:www-data $TARGET_DIR/storage $TARGET_DIR/bootstrap/cache
sudo chmod -R 775 $TARGET_DIR/storage $TARGET_DIR/bootstrap/cache
echo "✓ Permissions fixed"
echo ""

# 8. Clear caches
echo "8. Clearing caches..."
cd $TARGET_DIR
php artisan config:clear
sudo php artisan cache:clear
php artisan view:clear
echo "✓ Caches cleared"
echo ""

# 9. Restart PHP-FPM
echo "9. Restarting PHP-FPM..."
sudo systemctl daemon-reload
sudo systemctl restart php8.2-fpm
echo "✓ PHP-FPM restarted"
echo ""

# 10. Verify
echo "10. Running verification..."
php verify-domain-filter.php
echo ""

echo "=========================================="
echo "Deployment Complete!"
echo "=========================================="
echo ""
echo "Next steps:"
echo "1. Manually update bootstrap/app.php (see KARNATAKA_DOMAIN_SETUP.md)"
echo "2. Configure DNS for karnatakajob.online"
echo "3. Configure Nginx virtual host"
echo "4. Test the domain"
echo ""
