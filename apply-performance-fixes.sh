#!/bin/bash

echo "🚀 Applying Performance Optimizations to JobOne.in"
echo "═══════════════════════════════════════════════════════════════"
echo ""

# Colors for output
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# Check if we're in the right directory
if [ ! -f "artisan" ]; then
    echo -e "${RED}❌ Error: Not in Laravel project root!${NC}"
    echo "Please run this script from /var/www/jobone"
    exit 1
fi

echo -e "${YELLOW}📋 This script will apply the following optimizations:${NC}"
echo "  1. Add aria-labels to buttons (Accessibility)"
echo "  2. Async load Font Awesome (Saves 900ms)"
echo "  3. Add font-display: swap"
echo "  4. Convert logo to WebP (Saves 7.7 KB)"
echo "  5. Update Nginx config (Cache + Security headers)"
echo ""
read -p "Continue? (y/n) " -n 1 -r
echo ""
if [[ ! $REPLY =~ ^[Yy]$ ]]; then
    echo "Aborted."
    exit 1
fi

echo ""
echo "═══════════════════════════════════════════════════════════════"
echo "🔧 Step 1: Backing up files..."
echo "═══════════════════════════════════════════════════════════════"

# Create backup directory
BACKUP_DIR="backups/performance-$(date +%Y%m%d-%H%M%S)"
mkdir -p "$BACKUP_DIR"

# Backup layout file
cp resources/views/layouts/app.blade.php "$BACKUP_DIR/"
echo -e "${GREEN}✅ Backed up app.blade.php${NC}"

# Backup Nginx config if it exists
if [ -f "/etc/nginx/sites-available/jobone.in" ]; then
    sudo cp /etc/nginx/sites-available/jobone.in "$BACKUP_DIR/"
    echo -e "${GREEN}✅ Backed up Nginx config${NC}"
fi

echo ""
echo "═══════════════════════════════════════════════════════════════"
echo "🔧 Step 2: Converting logo to WebP..."
echo "═══════════════════════════════════════════════════════════════"

# Install webp tools if not installed
if ! command -v cwebp &> /dev/null; then
    echo "📦 Installing WebP tools..."
    sudo apt-get update -qq
    sudo apt-get install -y webp
fi

# Convert logo
if [ -f "public/images/jobone-logo.png" ]; then
    cd public/images
    cwebp -q 90 jobone-logo.png -o jobone-logo.webp 2>/dev/null
    if [ -f "jobone-logo.webp" ]; then
        sudo chown www-data:www-data jobone-logo.webp
        sudo chmod 644 jobone-logo.webp
        ORIGINAL_SIZE=$(du -h jobone-logo.png | cut -f1)
        WEBP_SIZE=$(du -h jobone-logo.webp | cut -f1)
        echo -e "${GREEN}✅ Logo converted: $ORIGINAL_SIZE → $WEBP_SIZE${NC}"
    else
        echo -e "${RED}❌ WebP conversion failed${NC}"
    fi
    cd ../..
else
    echo -e "${YELLOW}⚠️  Logo not found, skipping...${NC}"
fi

echo ""
echo "═══════════════════════════════════════════════════════════════"
echo "🔧 Step 3: Updating layout file..."
echo "═══════════════════════════════════════════════════════════════"

LAYOUT_FILE="resources/views/layouts/app.blade.php"

# Fix 1: Add aria-label to mobile menu button
sed -i 's/<button id="mobile-menu-button" class="p-2 text-gray-700 hover:text-blue-600 focus:outline-none">/<button id="mobile-menu-button" class="p-2 text-gray-700 hover:text-blue-600 focus:outline-none" aria-label="Toggle mobile menu" aria-expanded="false">/g' "$LAYOUT_FILE"
echo -e "${GREEN}✅ Added aria-label to mobile menu button${NC}"

# Fix 2: Async load Font Awesome
sed -i 's|<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">|<link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" as="style" onload="this.onload=null;this.rel='"'"'stylesheet'"'"'">\n    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"></noscript>|g' "$LAYOUT_FILE"
echo -e "${GREEN}✅ Font Awesome now loads asynchronously${NC}"

# Fix 3: Add font-display swap (add after Font Awesome link)
# This is complex with sed, so we'll create a note for manual addition
echo -e "${YELLOW}⚠️  Please manually add font-display: swap after Font Awesome link${NC}"

# Fix 4: Update logo to use WebP
sed -i 's|<img src="{{ asset('"'"'images/jobone-logo.png'"'"') }}" alt="JobOne.in" class="h-10 md:h-16 w-auto object-contain">|<picture>\n                    <source srcset="{{ asset('"'"'images/jobone-logo.webp'"'"') }}" type="image/webp">\n                    <img src="{{ asset('"'"'images/jobone-logo.png'"'"') }}" alt="JobOne.in" class="h-10 md:h-16 w-auto object-contain">\n                </picture>|g' "$LAYOUT_FILE"
echo -e "${GREEN}✅ Logo now uses WebP format${NC}"

echo ""
echo "═══════════════════════════════════════════════════════════════"
echo "🔧 Step 4: Updating Nginx configuration..."
echo "═══════════════════════════════════════════════════════════════"

echo -e "${YELLOW}⚠️  Nginx configuration must be updated manually${NC}"
echo ""
echo "Run these commands:"
echo "  sudo nano /etc/nginx/sites-available/jobone.in"
echo ""
echo "Add the configuration from: nginx-performance-config.conf"
echo ""
echo "Then test and reload:"
echo "  sudo nginx -t"
echo "  sudo service nginx reload"

echo ""
echo "═══════════════════════════════════════════════════════════════"
echo "🔧 Step 5: Clearing caches..."
echo "═══════════════════════════════════════════════════════════════"

php artisan view:clear
php artisan cache:clear
php artisan config:clear
echo -e "${GREEN}✅ Caches cleared${NC}"

echo ""
echo "═══════════════════════════════════════════════════════════════"
echo "🔧 Step 6: Restarting services..."
echo "═══════════════════════════════════════════════════════════════"

sudo service php8.2-fpm restart
echo -e "${GREEN}✅ PHP-FPM restarted${NC}"

echo ""
echo "═══════════════════════════════════════════════════════════════"
echo "✅ Performance optimizations applied!"
echo "═══════════════════════════════════════════════════════════════"
echo ""
echo "📝 Manual steps remaining:"
echo "  1. Update Nginx config (see nginx-performance-config.conf)"
echo "  2. Add font-display: swap styles"
echo "  3. Test the site"
echo ""
echo "🧪 Test performance:"
echo "  https://pagespeed.web.dev/analysis?url=https://jobone.in&form_factor=mobile"
echo ""
echo "📂 Backups saved to: $BACKUP_DIR"
echo ""
echo "═══════════════════════════════════════════════════════════════"
