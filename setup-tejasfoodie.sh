#!/bin/bash

# Tejas Foodie Domain Setup Script
# This script sets up tejasfoodie.store with SSL

set -e

echo "=========================================="
echo "Tejas Foodie Domain Setup"
echo "=========================================="
echo ""

# Colors
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# Check if running as root
if [ "$EUID" -ne 0 ]; then 
    echo -e "${RED}Please run as root (use sudo)${NC}"
    exit 1
fi

# Get the project directory
PROJECT_DIR=$(pwd)

echo -e "${YELLOW}Step 1: Installing Certbot (if needed)${NC}"
apt update
apt install certbot python3-certbot-nginx -y
echo -e "${GREEN}✓ Certbot installed${NC}"
echo ""

echo -e "${YELLOW}Step 2: Copying Nginx configuration${NC}"
cp tejasfoodie-nginx.conf /etc/nginx/sites-available/tejasfoodie.store
ln -sf /etc/nginx/sites-available/tejasfoodie.store /etc/nginx/sites-enabled/
echo -e "${GREEN}✓ Nginx config copied${NC}"
echo ""

echo -e "${YELLOW}Step 3: Testing Nginx configuration${NC}"
nginx -t
echo -e "${GREEN}✓ Nginx config is valid${NC}"
echo ""

echo -e "${YELLOW}Step 4: Reloading Nginx${NC}"
systemctl reload nginx
echo -e "${GREEN}✓ Nginx reloaded${NC}"
echo ""

echo -e "${YELLOW}Step 5: Obtaining SSL Certificate${NC}"
echo "This will prompt you for:"
echo "  - Email address"
echo "  - Agreement to terms"
echo "  - HTTPS redirect (choose Yes)"
echo ""
read -p "Press Enter to continue with SSL setup..."

certbot --nginx -d tejasfoodie.store -d www.tejasfoodie.store

echo ""
echo -e "${GREEN}✓ SSL certificate obtained${NC}"
echo ""

echo -e "${YELLOW}Step 6: Final Nginx reload${NC}"
systemctl reload nginx
echo -e "${GREEN}✓ Nginx reloaded with SSL${NC}"
echo ""

echo -e "${YELLOW}Step 7: Testing auto-renewal${NC}"
certbot renew --dry-run
echo -e "${GREEN}✓ Auto-renewal is configured${NC}"
echo ""

echo "=========================================="
echo -e "${GREEN}Setup Complete!${NC}"
echo "=========================================="
echo ""
echo "Your site is now live at:"
echo "  - https://tejasfoodie.store"
echo "  - https://www.tejasfoodie.store"
echo ""
echo "To customize the landing page, edit:"
echo "  $PROJECT_DIR/public/tejasfoodie.html"
echo ""
echo "SSL certificate will auto-renew every 90 days."
echo ""
