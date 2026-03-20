#!/bin/bash

###############################################################################
# Automated Deployment Script for JobOne.in SEO Fix
# Run this on your server after pushing to GitHub
###############################################################################

set -e  # Exit on any error

echo "╔══════════════════════════════════════════════════════════════════════╗"
echo "║         JobOne.in - SEO Fix Automated Deployment                    ║"
echo "╚══════════════════════════════════════════════════════════════════════╝"
echo ""

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Function to print colored output
print_success() {
    echo -e "${GREEN}✅ $1${NC}"
}

print_error() {
    echo -e "${RED}❌ $1${NC}"
}

print_warning() {
    echo -e "${YELLOW}⚠️  $1${NC}"
}

print_info() {
    echo -e "${BLUE}ℹ️  $1${NC}"
}

# Check if we're in the right directory
if [ ! -f "artisan" ]; then
    print_error "Error: artisan file not found. Please run this from the Laravel root directory."
    exit 1
fi

print_info "Starting deployment..."
echo ""

# Step 1: Pull latest changes from GitHub
echo "📥 Step 1: Pulling latest changes from GitHub..."
if git pull origin main; then
    print_success "Code updated from GitHub"
else
    print_error "Failed to pull from GitHub"
    exit 1
fi
echo ""

# Step 2: Check if og-image.jpg exists
echo "🖼️  Step 2: Checking OG image..."
if [ -f "public/images/og-image.jpg" ]; then
    SIZE=$(stat -f%z "public/images/og-image.jpg" 2>/dev/null || stat -c%s "public/images/og-image.jpg" 2>/dev/null)
    print_success "og-image.jpg exists (Size: $((SIZE / 1024))KB)"
    chmod 644 public/images/og-image.jpg
    print_success "File permissions set (644)"
else
    print_error "og-image.jpg not found!"
    print_info "Attempting to generate..."
    if php create-og-image.php; then
        print_success "OG image generated"
    else
        print_warning "Could not generate OG image. Please create manually."
    fi
fi
echo ""

# Step 3: Check APP_URL in .env
echo "🔧 Step 3: Checking APP_URL configuration..."
APP_URL=$(grep "^APP_URL=" .env | cut -d '=' -f2)
print_info "Current APP_URL: $APP_URL"

if [[ "$APP_URL" == *"localhost"* ]]; then
    print_error "APP_URL is still set to localhost!"
    print_warning "Please update .env manually:"
    echo "   nano .env"
    echo "   Change: APP_URL=http://localhost:8000"
    echo "   To:     APP_URL=https://jobone.in"
    echo ""
    read -p "Press Enter after updating .env file..."
    
    # Re-check APP_URL
    APP_URL=$(grep "^APP_URL=" .env | cut -d '=' -f2)
    if [[ "$APP_URL" == *"localhost"* ]]; then
        print_error "APP_URL still contains localhost. Deployment cannot continue."
        exit 1
    fi
fi
print_success "APP_URL is correctly set"
echo ""

# Step 4: Clear all caches
echo "🧹 Step 4: Clearing Laravel caches..."
php artisan config:clear && print_success "Config cache cleared"
php artisan cache:clear && print_success "Application cache cleared"
php artisan view:clear && print_success "View cache cleared"
php artisan route:clear && print_success "Route cache cleared"
echo ""

# Step 5: Verify configuration
echo "✓ Step 5: Verifying configuration..."
VERIFIED_URL=$(php artisan config:show app.url 2>/dev/null || echo "")
if [ -n "$VERIFIED_URL" ]; then
    print_info "Verified APP_URL: $VERIFIED_URL"
    if [[ "$VERIFIED_URL" == *"localhost"* ]]; then
        print_error "Config still shows localhost! Clear cache again."
        php artisan config:clear
    else
        print_success "Configuration verified"
    fi
else
    print_warning "Could not verify config (command not available)"
fi
echo ""

# Step 6: Test og-image accessibility
echo "🌐 Step 6: Testing OG image accessibility..."
DOMAIN=$(echo $APP_URL | sed 's|http://||' | sed 's|https://||' | sed 's|/.*||')
if curl -I "https://$DOMAIN/images/og-image.jpg" 2>/dev/null | grep -q "200 OK"; then
    print_success "OG image is accessible at https://$DOMAIN/images/og-image.jpg"
else
    print_warning "Could not verify OG image accessibility"
    print_info "Check manually: https://$DOMAIN/images/og-image.jpg"
fi
echo ""

# Step 7: Test meta tags
echo "🔍 Step 7: Testing meta tags..."
if curl -s "https://$DOMAIN" 2>/dev/null | grep -q "og:image"; then
    print_success "Meta tags found in HTML"
    
    # Check for localhost
    if curl -s "https://$DOMAIN" 2>/dev/null | grep -qi "localhost"; then
        print_error "Found localhost references in HTML!"
        print_warning "Clear cache again and check .env"
    else
        print_success "No localhost references found"
    fi
else
    print_warning "Could not verify meta tags"
fi
echo ""

# Step 8: Summary
echo "╔══════════════════════════════════════════════════════════════════════╗"
echo "║                    Deployment Summary                                ║"
echo "╚══════════════════════════════════════════════════════════════════════╝"
echo ""
print_success "Deployment completed successfully!"
echo ""
echo "📋 Next Steps:"
echo "   1. Test with Facebook Debugger:"
echo "      https://developers.facebook.com/tools/debug/"
echo ""
echo "   2. Enter your URL: https://$DOMAIN"
echo ""
echo "   3. Click 'Debug' then 'Scrape Again'"
echo ""
echo "   4. Test in WhatsApp by sharing: https://$DOMAIN"
echo ""
echo "   5. Test in Telegram by sharing: https://$DOMAIN"
echo ""
echo "📖 For detailed testing, see: POST_DEPLOYMENT_TEST.md"
echo ""

# Optional: Run tests
read -p "Would you like to run automated tests? (y/n) " -n 1 -r
echo ""
if [[ $REPLY =~ ^[Yy]$ ]]; then
    echo ""
    echo "🧪 Running automated tests..."
    echo ""
    
    # Test 1: Check og-image
    echo "Test 1: OG Image File"
    if [ -f "public/images/og-image.jpg" ]; then
        print_success "PASS: og-image.jpg exists"
    else
        print_error "FAIL: og-image.jpg not found"
    fi
    
    # Test 2: Check APP_URL
    echo "Test 2: APP_URL Configuration"
    if [[ "$APP_URL" != *"localhost"* ]]; then
        print_success "PASS: APP_URL is not localhost"
    else
        print_error "FAIL: APP_URL contains localhost"
    fi
    
    # Test 3: Check meta tags
    echo "Test 3: Meta Tags in HTML"
    if curl -s "https://$DOMAIN" 2>/dev/null | grep -q "og:image.*https://$DOMAIN"; then
        print_success "PASS: Meta tags contain correct domain"
    else
        print_warning "WARN: Could not verify meta tags"
    fi
    
    # Test 4: Check image accessibility
    echo "Test 4: OG Image Accessibility"
    if curl -I "https://$DOMAIN/images/og-image.jpg" 2>/dev/null | grep -q "200 OK"; then
        print_success "PASS: OG image is accessible"
    else
        print_error "FAIL: OG image not accessible"
    fi
    
    echo ""
    print_info "Tests completed!"
fi

echo ""
echo "╔══════════════════════════════════════════════════════════════════════╗"
echo "║                    🎉 Deployment Complete! 🎉                        ║"
echo "╚══════════════════════════════════════════════════════════════════════╝"
