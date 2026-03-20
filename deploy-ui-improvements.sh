#!/bin/bash

# UI Improvements Deployment Script for JobOne.in
# This script deploys the latest UI enhancements to the production server

echo "╔══════════════════════════════════════════════════════════════╗"
echo "║                                                              ║"
echo "║         JobOne.in - UI Improvements Deployment              ║"
echo "║                                                              ║"
echo "╚══════════════════════════════════════════════════════════════╝"
echo ""

# Colors for output
GREEN='\033[0;32m'
BLUE='\033[0;34m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# Function to print colored output
print_status() {
    echo -e "${BLUE}[INFO]${NC} $1"
}

print_success() {
    echo -e "${GREEN}[SUCCESS]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

print_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# Check if running in correct directory
if [ ! -f "artisan" ]; then
    print_error "This script must be run from the Laravel project root directory"
    exit 1
fi

print_status "Starting UI improvements deployment..."
echo ""

# Step 1: Git Pull
print_status "Step 1/5: Pulling latest changes from GitHub..."
git pull origin main
if [ $? -eq 0 ]; then
    print_success "Git pull completed"
else
    print_error "Git pull failed"
    exit 1
fi
echo ""

# Step 2: Clear View Cache
print_status "Step 2/5: Clearing view cache..."
php artisan view:clear
if [ $? -eq 0 ]; then
    print_success "View cache cleared"
else
    print_warning "View cache clear failed (non-critical)"
fi
echo ""

# Step 3: Clear Application Cache
print_status "Step 3/5: Clearing application cache..."
php artisan cache:clear
if [ $? -eq 0 ]; then
    print_success "Application cache cleared"
else
    print_warning "Application cache clear failed (non-critical)"
fi
echo ""

# Step 4: Clear Config Cache
print_status "Step 4/5: Clearing config cache..."
php artisan config:clear
if [ $? -eq 0 ]; then
    print_success "Config cache cleared"
else
    print_warning "Config cache clear failed (non-critical)"
fi
echo ""

# Step 5: Optimize (optional)
print_status "Step 5/5: Optimizing application..."
php artisan optimize
if [ $? -eq 0 ]; then
    print_success "Application optimized"
else
    print_warning "Optimization failed (non-critical)"
fi
echo ""

# Summary
echo "╔══════════════════════════════════════════════════════════════╗"
echo "║                                                              ║"
echo "║                  ✅ DEPLOYMENT COMPLETE ✅                   ║"
echo "║                                                              ║"
echo "╚══════════════════════════════════════════════════════════════╝"
echo ""

print_success "UI improvements have been deployed successfully!"
echo ""

echo "📋 What was deployed:"
echo "  ✓ Enhanced post card design with urgency indicators"
echo "  ✓ Quick Apply floating button for job posts"
echo "  ✓ Improved post detail page layout"
echo "  ✓ Toast notification system"
echo "  ✓ Back to top button"
echo "  ✓ Loading skeleton components"
echo ""

echo "🧪 Testing checklist:"
echo "  1. Visit homepage and check post cards"
echo "  2. Open a job post and verify quick apply button"
echo "  3. Test back to top button (scroll down first)"
echo "  4. Check mobile responsiveness"
echo "  5. Verify all links and buttons work"
echo ""

echo "📖 For more details, see: UI_IMPROVEMENTS_SUMMARY.md"
echo ""

print_success "Deployment completed at $(date)"
