#!/bin/bash

# Domain State Filtering Setup Script
# This script helps configure domain-based state filtering

echo "==================================="
echo "Domain State Filtering Setup"
echo "==================================="
echo ""

# Check if .env exists
if [ ! -f .env ]; then
    echo "Error: .env file not found!"
    echo "Please copy .env.example to .env first"
    exit 1
fi

# Check if DOMAIN_STATE_MAP already exists
if grep -q "DOMAIN_STATE_MAP=" .env; then
    echo "DOMAIN_STATE_MAP already exists in .env"
    echo "Current value:"
    grep "DOMAIN_STATE_MAP=" .env
    echo ""
    read -p "Do you want to update it? (y/n): " update
    if [ "$update" != "y" ]; then
        echo "Skipping update"
        exit 0
    fi
    # Remove existing line
    sed -i '/DOMAIN_STATE_MAP=/d' .env
fi

# Get domain and state from user
echo ""
echo "Enter domain-to-state mappings"
echo "Format: domain:state_slug"
echo "Example: karnatakajob.online:karnataka"
echo ""
read -p "Enter domain: " domain
read -p "Enter state slug: " state_slug

# Add to .env
echo "" >> .env
echo "# Domain-specific state filtering" >> .env
echo "DOMAIN_STATE_MAP=$domain:$state_slug" >> .env

echo ""
echo "✓ Configuration added to .env"
echo ""

# Ask if user wants to add www version
read -p "Add www.$domain as well? (y/n): " add_www
if [ "$add_www" = "y" ]; then
    sed -i "s|DOMAIN_STATE_MAP=$domain:$state_slug|DOMAIN_STATE_MAP=$domain:$state_slug,www.$domain:$state_slug|" .env
    echo "✓ Added www.$domain"
fi

echo ""
echo "==================================="
echo "Setup Complete!"
echo "==================================="
echo ""
echo "Next steps:"
echo "1. Clear cache: php artisan config:clear && php artisan cache:clear"
echo "2. Restart PHP-FPM: sudo systemctl restart php8.2-fpm"
echo "3. Point your domain DNS to this server"
echo ""
echo "Current configuration:"
grep "DOMAIN_STATE_MAP=" .env
echo ""
