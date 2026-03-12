#!/bin/bash

echo "=========================================="
echo "Deploy API Changes to Server"
echo "=========================================="

# Pull latest changes
echo "📥 Pulling latest changes from GitHub..."
sudo git pull origin main

# Clear caches
echo "🗑️ Clearing Laravel caches..."
sudo php artisan cache:clear
sudo php artisan config:clear
sudo php artisan route:clear
sudo php artisan view:clear

# Restart PHP-FPM
echo "🔄 Restarting PHP-FPM..."
sudo systemctl restart php8.2-fpm

echo "=========================================="
echo "✅ API Deployment Complete!"
echo "=========================================="
echo ""
echo "API Endpoints Available:"
echo "  GET    /api/posts              - List posts"
echo "  GET    /api/posts/{id}         - Get post"
echo "  POST   /api/posts              - Create post"
echo "  PUT    /api/posts/{id}         - Update post"
echo "  DELETE /api/posts/{id}         - Delete post"
echo "  GET    /api/categories         - Get categories"
echo "  GET    /api/states             - Get states"
echo "  GET    /api/token              - Get token info"
echo "  POST   /api/token/generate     - Generate new token"
echo ""
echo "Test API:"
echo "  curl -X GET \"https://jobone.in/api/posts\" \\"
echo "    -H \"Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a\""
echo ""
