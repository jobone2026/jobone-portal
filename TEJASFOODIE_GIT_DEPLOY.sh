#!/bin/bash

# Tejas Foodie - Git Push and Server Deploy Script
# Run this from your local machine

set -e

echo "╔════════════════════════════════════════════════════════════╗"
echo "║     TEJAS FOODIE - GIT PUSH & DEPLOY                       ║"
echo "╚════════════════════════════════════════════════════════════╝"
echo ""

# Colors
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# Step 1: Check Git status
echo -e "${YELLOW}Step 1: Checking Git status...${NC}"
git status
echo ""

# Step 2: Add all tejasfoodie files
echo -e "${YELLOW}Step 2: Adding files to Git...${NC}"
git add app/Http/Middleware/TejasFoodieMiddleware.php
git add public/tejasfoodie.html
git add tejasfoodie-nginx.conf
git add setup-tejasfoodie.sh
git add bootstrap/app.php
git add TEJASFOODIE_SETUP.md
git add TEJASFOODIE_QUICK_START.txt
git add TEJASFOODIE_IMPLEMENTATION.md
git add DEPLOY_TEJASFOODIE.txt
git add TEJASFOODIE_GIT_DEPLOY.sh
echo -e "${GREEN}✓ Files added${NC}"
echo ""

# Step 3: Commit changes
echo -e "${YELLOW}Step 3: Committing changes...${NC}"
git commit -m "Add tejasfoodie.store domain with landing page and SSL setup

- Added TejasFoodieMiddleware for domain handling
- Created standalone HTML landing page
- Added Nginx configuration with SSL
- Included automated setup script
- Added comprehensive documentation
- 100% independent from job portal domains"
echo -e "${GREEN}✓ Changes committed${NC}"
echo ""

# Step 4: Push to GitHub
echo -e "${YELLOW}Step 4: Pushing to GitHub...${NC}"
git push origin main
echo -e "${GREEN}✓ Pushed to GitHub${NC}"
echo ""

echo "╔════════════════════════════════════════════════════════════╗"
echo "║     LOCAL PUSH COMPLETE!                                   ║"
echo "╚════════════════════════════════════════════════════════════╝"
echo ""
echo -e "${BLUE}Next: Deploy on server${NC}"
echo ""
echo "Copy and run these commands on your server:"
echo ""
echo -e "${YELLOW}──────────────────────────────────────────────────────────${NC}"
echo "ssh your-server"
echo "cd /var/www/govt-job-portal-new"
echo "git pull origin main"
echo "sudo bash setup-tejasfoodie.sh"
echo -e "${YELLOW}──────────────────────────────────────────────────────────${NC}"
echo ""
