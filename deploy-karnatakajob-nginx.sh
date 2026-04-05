#!/bin/bash
# Deploy optimized Nginx config for karnatakajob.online

echo "=== Deploying Nginx Config for karnatakajob.online ==="

# Backup current config
sudo cp /etc/nginx/sites-available/karnatakajob.online /etc/nginx/sites-available/karnatakajob.online.backup.$(date +%Y%m%d_%H%M%S)

# Copy the optimized config
sudo cp karnatakajob-nginx-optimized.conf /etc/nginx/sites-available/karnatakajob.online

# Test Nginx config
echo "Testing Nginx configuration..."
sudo nginx -t

if [ $? -eq 0 ]; then
    echo "✓ Nginx config test passed"
    
    # Reload Nginx
    echo "Reloading Nginx..."
    sudo service nginx reload
    
    echo "✓ Nginx reloaded successfully"
    
    # Verify headers
    echo ""
    echo "=== Verifying Cache Headers ==="
    curl -I https://karnatakajob.online/images/jobone-logo.webp 2>/dev/null | grep -i "cache-control\|expires"
    
    echo ""
    echo "=== Verifying Security Headers ==="
    curl -I https://karnatakajob.online/ 2>/dev/null | grep -i "x-frame-options\|x-content-type"
    
    echo ""
    echo "✓ Deployment complete!"
    echo "Test at: https://pagespeed.web.dev/analysis?url=https://karnatakajob.online/"
else
    echo "✗ Nginx config test failed - config NOT applied"
    exit 1
fi
