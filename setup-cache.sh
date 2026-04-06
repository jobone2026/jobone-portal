#!/bin/bash

# Script to add cache headers to nginx configuration

echo "Adding cache headers to nginx configuration..."

# Backup current nginx config
sudo cp /etc/nginx/sites-available/jobone.in /etc/nginx/sites-available/jobone.in.backup

# Add cache configuration before the closing brace of server block
sudo sed -i '/^}/i \
    # Cache static assets for 1 year\
    location ~* \\.(css|js|jpg|jpeg|png|gif|ico|svg|webp|woff|woff2|ttf|eot|otf)$ {\
        expires 1y;\
        add_header Cache-Control "public, immutable";\
        access_log off;\
    }\
\
    # Cache build assets (Vite compiled files) for 1 year\
    location ~* ^/build/.*\\.(css|js|map)$ {\
        expires 1y;\
        add_header Cache-Control "public, immutable";\
        access_log off;\
    }\
\
    # Cache images for 1 month\
    location ~* ^/images/.*\\.(jpg|jpeg|png|gif|svg|webp|ico)$ {\
        expires 1M;\
        add_header Cache-Control "public";\
        access_log off;\
    }\
\
    # Don'\''t cache HTML files\
    location ~* \\.html$ {\
        expires -1;\
        add_header Cache-Control "no-cache, no-store, must-revalidate";\
    }' /etc/nginx/sites-available/jobone.in

# Test nginx configuration
echo "Testing nginx configuration..."
sudo nginx -t

if [ $? -eq 0 ]; then
    echo "Configuration is valid. Reloading nginx..."
    sudo systemctl reload nginx
    echo "✓ Cache headers added successfully!"
    echo "✓ Static assets will now be cached for 1 year"
    echo "✓ Images will be cached for 1 month"
else
    echo "✗ Configuration error. Restoring backup..."
    sudo cp /etc/nginx/sites-available/jobone.in.backup /etc/nginx/sites-available/jobone.in
    echo "Backup restored. Please check the configuration manually."
fi
