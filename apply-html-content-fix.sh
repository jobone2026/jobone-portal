#!/bin/bash

# HTML Content Display Fix - Deployment Script
# This script applies the HTML content rendering fix

echo "================================================"
echo "  HTML Content Display Fix - Deployment"
echo "================================================"
echo ""

# Colors for output
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# Check if we're in the right directory
if [ ! -f "artisan" ]; then
    echo -e "${RED}Error: artisan file not found. Please run this script from the Laravel project root.${NC}"
    exit 1
fi

echo -e "${YELLOW}Step 1: Installing Node dependencies...${NC}"
if [ ! -d "node_modules" ]; then
    npm install
else
    echo "Node modules already installed, skipping..."
fi
echo ""

echo -e "${YELLOW}Step 2: Building assets (CSS & JS)...${NC}"
npm run build
if [ $? -eq 0 ]; then
    echo -e "${GREEN}✓ Assets built successfully${NC}"
else
    echo -e "${RED}✗ Asset build failed${NC}"
    exit 1
fi
echo ""

echo -e "${YELLOW}Step 3: Clearing Laravel caches...${NC}"
php artisan cache:clear
php artisan view:clear
php artisan config:clear
php artisan route:clear
echo -e "${GREEN}✓ Caches cleared${NC}"
echo ""

echo -e "${YELLOW}Step 4: Optimizing application...${NC}"
php artisan config:cache
php artisan route:cache
php artisan view:cache
echo -e "${GREEN}✓ Application optimized${NC}"
echo ""

echo -e "${YELLOW}Step 5: Setting proper permissions...${NC}"
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || chown -R $(whoami):$(whoami) storage bootstrap/cache
echo -e "${GREEN}✓ Permissions set${NC}"
echo ""

# Check if PHP-FPM is running
echo -e "${YELLOW}Step 6: Restarting PHP-FPM (if available)...${NC}"
if systemctl is-active --quiet php8.3-fpm; then
    sudo systemctl restart php8.3-fpm
    echo -e "${GREEN}✓ PHP 8.3-FPM restarted${NC}"
elif systemctl is-active --quiet php8.2-fpm; then
    sudo systemctl restart php8.2-fpm
    echo -e "${GREEN}✓ PHP 8.2-FPM restarted${NC}"
elif systemctl is-active --quiet php-fpm; then
    sudo systemctl restart php-fpm
    echo -e "${GREEN}✓ PHP-FPM restarted${NC}"
else
    echo -e "${YELLOW}⚠ PHP-FPM not found or not running as service${NC}"
fi
echo ""

echo "================================================"
echo -e "${GREEN}  HTML Content Fix Applied Successfully!${NC}"
echo "================================================"
echo ""
echo "Next steps:"
echo "1. Visit a post page on your website"
echo "2. Check if HTML content displays correctly"
echo "3. Test on mobile devices"
echo "4. Clear browser cache if needed (Ctrl+Shift+R)"
echo ""
echo "If you encounter issues, check:"
echo "- Browser console for errors"
echo "- storage/logs/laravel.log for Laravel errors"
echo "- public/build/manifest.json exists"
echo ""
echo "For more details, see: HTML_CONTENT_FIX.md"
echo ""
