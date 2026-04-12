#!/bin/bash
# Automated deployment script for JobOne
# This ensures cache is always cleared after file uploads

echo "=========================================="
echo "JobOne Production Deployment"
echo "=========================================="
echo ""

SERVER="ubuntu@3.108.161.67"
KEY="govt-job-portal-new/.ssh/jobone2026.pem"
REMOTE_PATH="/var/www/jobone"

# Function to deploy files
deploy_files() {
    echo "📤 Uploading files to production..."
    
    # Upload specific files if provided as arguments
    if [ $# -gt 0 ]; then
        for file in "$@"; do
            echo "  → Uploading $file"
            scp -i "$KEY" -o StrictHostKeyChecking=no "$file" "$SERVER:/tmp/"
        done
    fi
}

# Function to fix permissions and clear cache
post_deploy() {
    echo ""
    echo "🔧 Running post-deployment tasks..."
    
    ssh -i "$KEY" -o StrictHostKeyChecking=no "$SERVER" << 'ENDSSH'
        cd /var/www/jobone
        
        # Fix ownership
        echo "  → Fixing file ownership..."
        sudo chown -R www-data:www-data storage bootstrap/cache resources/views public/jobscrap
        
        # Fix permissions
        echo "  → Setting correct permissions..."
        sudo chmod -R 775 storage bootstrap/cache
        sudo chmod -R 644 resources/views/**/*.blade.php
        sudo chmod -R 644 public/jobscrap/*.php
        
        # Clear ALL caches
        echo "  → Clearing all caches..."
        sudo rm -rf storage/framework/cache/data/*
        sudo -u www-data php artisan optimize:clear
        sudo -u www-data php artisan config:clear
        sudo -u www-data php artisan view:clear
        sudo -u www-data php artisan route:clear
        
        # Rebuild caches
        echo "  → Rebuilding caches..."
        sudo -u www-data php artisan config:cache
        sudo -u www-data php artisan route:cache
        sudo -u www-data php artisan view:cache
        
        # Restart PHP-FPM
        echo "  → Restarting PHP-FPM..."
        sudo systemctl restart php8.2-fpm
        
        echo ""
        echo "✅ Post-deployment tasks completed!"
ENDSSH
}

# Function to verify deployment
verify_deployment() {
    echo ""
    echo "🔍 Verifying deployment..."
    
    # Check jobone.in
    HTTP_CODE=$(curl -s -o /dev/null -w "%{http_code}" https://jobone.in)
    if [ "$HTTP_CODE" = "200" ]; then
        echo "  ✅ jobone.in is UP (HTTP $HTTP_CODE)"
    else
        echo "  ❌ jobone.in has issues (HTTP $HTTP_CODE)"
    fi
    
    # Check karnatakajob.online
    HTTP_CODE=$(curl -s -o /dev/null -w "%{http_code}" https://karnatakajob.online)
    if [ "$HTTP_CODE" = "200" ]; then
        echo "  ✅ karnatakajob.online is UP (HTTP $HTTP_CODE)"
    else
        echo "  ❌ karnatakajob.online has issues (HTTP $HTTP_CODE)"
    fi
    
    # Verify Karnataka filter
    echo ""
    echo "  🔍 Testing Karnataka domain filter..."
    ssh -i "$KEY" -o StrictHostKeyChecking=no "$SERVER" "sudo php /tmp/test-domain-filter.php" | grep "Domain filter is"
}

# Main execution
if [ "$1" = "verify-only" ]; then
    verify_deployment
elif [ "$1" = "cache-only" ]; then
    post_deploy
else
    deploy_files "$@"
    post_deploy
    verify_deployment
fi

echo ""
echo "=========================================="
echo "Deployment Complete!"
echo "=========================================="
