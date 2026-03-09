#!/bin/bash

# JobOne.in Deployment Script
# This script automates the deployment process on AWS Ubuntu server

set -e

echo "🚀 Starting JobOne.in Deployment..."

# Colors for output
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# Configuration
APP_DIR="/var/www/jobone"
BRANCH="main"

# Check if running as root
if [ "$EUID" -eq 0 ]; then 
   echo -e "${RED}❌ Please do not run as root${NC}"
   exit 1
fi

echo -e "${YELLOW}📦 Pulling latest changes...${NC}"
cd $APP_DIR
git pull origin $BRANCH

echo -e "${YELLOW}📚 Installing Composer dependencies...${NC}"
composer install --optimize-autoloader --no-dev

echo -e "${YELLOW}📦 Installing NPM dependencies...${NC}"
npm install

echo -e "${YELLOW}🏗️  Building assets...${NC}"
npm run build

echo -e "${YELLOW}🗄️  Running migrations...${NC}"
php artisan migrate --force

echo -e "${YELLOW}🔗 Creating storage link...${NC}"
php artisan storage:link

echo -e "${YELLOW}⚡ Optimizing application...${NC}"
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo -e "${YELLOW}🗺️  Generating sitemap...${NC}"
php artisan sitemap:generate

echo -e "${YELLOW}🔄 Restarting services...${NC}"
sudo systemctl reload nginx
sudo systemctl restart php8.2-fpm
sudo supervisorctl restart jobone-worker:*

echo -e "${GREEN}✅ Deployment completed successfully!${NC}"
echo -e "${GREEN}🌐 Visit your site to verify the deployment${NC}"
