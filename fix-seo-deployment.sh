#!/bin/bash

# SEO & OG Image Fix - Deployment Script
# Run this on your server after pulling the code

echo "🚀 Starting SEO Fix Deployment..."
echo ""

# Check if we're in the right directory
if [ ! -f "artisan" ]; then
    echo "❌ Error: artisan file not found. Please run this from the Laravel root directory."
    exit 1
fi

# Step 1: Check APP_URL
echo "📋 Step 1: Checking APP_URL..."
APP_URL=$(grep "^APP_URL=" .env | cut -d '=' -f2)
echo "Current APP_URL: $APP_URL"

if [[ "$APP_URL" == *"localhost"* ]]; then
    echo "⚠️  WARNING: APP_URL is set to localhost!"
    echo "Please update .env file with your actual domain:"
    echo "APP_URL=https://jobone.in"
    echo ""
    read -p "Press Enter after updating .env file..."
fi

# Step 2: Generate OG Image
echo ""
echo "🖼️  Step 2: Generating OG Image..."
if [ ! -f "public/images/og-image.jpg" ]; then
    echo "Creating OG image..."
    php create-og-image.php
    
    if [ -f "public/images/og-image.jpg" ]; then
        echo "✅ OG image created successfully!"
        chmod 644 public/images/og-image.jpg
    else
        echo "⚠️  Could not auto-generate OG image."
        echo "Please create manually: public/images/og-image.jpg (1200x630px)"
    fi
else
    echo "✅ OG image already exists"
fi

# Step 3: Clear caches
echo ""
echo "🧹 Step 3: Clearing caches..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear
echo "✅ Caches cleared"

# Step 4: Check file permissions
echo ""
echo "🔐 Step 4: Checking file permissions..."
if [ -f "public/images/og-image.jpg" ]; then
    chmod 644 public/images/og-image.jpg
    echo "✅ File permissions set"
fi

# Step 5: Verify setup
echo ""
echo "✅ Deployment complete!"
echo ""
echo "📝 Next steps:"
echo "1. Test meta tags: https://developers.facebook.com/tools/debug/"
echo "2. Enter your URL: https://jobone.in"
echo "3. Click 'Scrape Again' to refresh cache"
echo "4. Test on WhatsApp by sharing a link"
echo "5. Test on Telegram by sharing a link"
echo ""
echo "📄 For detailed instructions, see: DEPLOYMENT_SEO_FIX.md"
