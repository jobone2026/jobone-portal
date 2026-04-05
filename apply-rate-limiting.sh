#!/bin/bash
# Apply rate limiting to jobone.in and karnatakajob.online

echo "=== Applying Rate Limiting Configuration ==="

# Backup nginx.conf
sudo cp /etc/nginx/nginx.conf /etc/nginx/nginx.conf.backup.$(date +%Y%m%d_%H%M%S)

# Check if rate limiting already exists
if grep -q "limit_req_zone" /etc/nginx/nginx.conf; then
    echo "⚠ Rate limiting zones already exist in nginx.conf"
    echo "Skipping nginx.conf modification"
else
    echo "Adding rate limiting zones to nginx.conf..."
    
    # Add rate limiting zones before the last closing brace
    sudo sed -i '/^}$/i \
    # Rate Limiting Zones\
    limit_req_zone $binary_remote_addr zone=public:10m rate=10r/s;\
    limit_req_zone $binary_remote_addr zone=search:10m rate=5r/s;\
    limit_req_zone $binary_remote_addr zone=api:10m rate=5r/s;\
    limit_req_zone $binary_remote_addr zone=admin:10m rate=2r/s;\
    limit_conn_zone $binary_remote_addr zone=addr:10m;\
' /etc/nginx/nginx.conf

    echo "✓ Rate limiting zones added to nginx.conf"
fi

# Function to add rate limiting to a site config
add_rate_limiting() {
    local site_config=$1
    local site_name=$2
    
    echo ""
    echo "Processing $site_name..."
    
    # Backup site config
    sudo cp "$site_config" "${site_config}.backup.$(date +%Y%m%d_%H%M%S)"
    
    # Check if rate limiting already exists
    if grep -q "limit_req zone=public" "$site_config"; then
        echo "⚠ Rate limiting already exists in $site_name"
    else
        echo "Adding rate limiting to $site_name..."
        
        # Add general rate limiting after server_name line
        sudo sed -i '/server_name.*'$site_name'/a \
\
    # Rate Limiting\
    limit_req zone=public burst=20 nodelay;\
    limit_conn addr 15;' "$site_config"
        
        # Add search rate limiting
        if grep -q "location /search" "$site_config"; then
            sudo sed -i '/location \/search/a \
        limit_req zone=search burst=10 nodelay;' "$site_config"
        fi
        
        # Add API rate limiting
        if grep -q "location /api/" "$site_config"; then
            sudo sed -i '/location \/api\//a \
        limit_req zone=api burst=10 nodelay;' "$site_config"
        else
            # Add API location block before the main location /
            sudo sed -i '/location \/ {/i \
    # API Rate Limiting\
    location /api/ {\
        limit_req zone=api burst=10 nodelay;\
        try_files $uri $uri/ /index.php?$query_string;\
    }\
' "$site_config"
        fi
        
        # Add admin rate limiting
        if grep -q "location /admin/" "$site_config"; then
            sudo sed -i '/location \/admin\//a \
        limit_req zone=admin burst=5 nodelay;' "$site_config"
        else
            # Add admin location block
            sudo sed -i '/location \/ {/i \
    # Admin Rate Limiting\
    location /admin/ {\
        limit_req zone=admin burst=5 nodelay;\
        try_files $uri $uri/ /index.php?$query_string;\
    }\
' "$site_config"
        fi
        
        echo "✓ Rate limiting added to $site_name"
    fi
}

# Apply to both sites
add_rate_limiting "/etc/nginx/sites-available/jobone.in" "jobone.in"
add_rate_limiting "/etc/nginx/sites-available/karnatakajob.online" "karnatakajob.online"

echo ""
echo "=== Testing Nginx Configuration ==="
sudo nginx -t

if [ $? -eq 0 ]; then
    echo ""
    echo "✓ Nginx config test passed"
    echo ""
    read -p "Reload Nginx to apply changes? (y/n) " -n 1 -r
    echo
    if [[ $REPLY =~ ^[Yy]$ ]]; then
        sudo service nginx reload
        echo "✓ Nginx reloaded successfully"
        echo ""
        echo "=== Rate Limiting Active ==="
        echo "Public pages: 10 req/sec (burst 20)"
        echo "Search: 5 req/sec (burst 10)"
        echo "API: 5 req/sec (burst 10)"
        echo "Admin: 2 req/sec (burst 5)"
        echo "Max connections per IP: 15"
        echo ""
        echo "Test with: ab -n 100 -c 10 https://jobone.in/"
        echo "Monitor: sudo tail -f /var/log/nginx/error.log | grep limiting"
    fi
else
    echo "✗ Nginx config test failed"
    echo "Restoring backups..."
    sudo cp /etc/nginx/nginx.conf.backup.* /etc/nginx/nginx.conf
    exit 1
fi
