#!/bin/bash

echo "Fixing nginx cache headers for jobone.in..."

# Create a temporary file with the cache configuration
cat > /tmp/cache-config.txt << 'EOF'

    # Cache static assets for 1 year
    location ~* \.(css|js|woff|woff2|ttf|eot|otf)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
        access_log off;
    }

    # Cache build assets (Vite compiled files) for 1 year
    location ~* ^/build/.*\.(css|js|map)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
        access_log off;
    }

    # Cache images for 1 month
    location ~* \.(jpg|jpeg|png|gif|svg|webp|ico)$ {
        expires 1M;
        add_header Cache-Control "public, max-age=2592000";
        access_log off;
    }

    # Don't cache HTML files
    location ~* \.html$ {
        expires -1;
        add_header Cache-Control "no-cache, no-store, must-revalidate";
    }
EOF

echo ""
echo "Please manually add the following to /etc/nginx/sites-available/jobone.in"
echo "Add it INSIDE the server block, BEFORE the 'location /' block:"
echo ""
cat /tmp/cache-config.txt
echo ""
echo "Then run:"
echo "  sudo nginx -t"
echo "  sudo systemctl reload nginx"
echo ""
echo "Or run this command to edit the file:"
echo "  sudo nano /etc/nginx/sites-available/jobone.in"
