#!/bin/bash

echo "=========================================="
echo "API Token & Test"
echo "=========================================="

# Check current API token in .env
echo "📋 Checking API Token in .env:"
grep "API_TOKEN=" .env

echo ""

# Get the token from .env
TOKEN=$(grep "API_TOKEN=" .env | cut -d '=' -f2)

if [ -z "$TOKEN" ]; then
    echo "❌ ERROR: API_TOKEN is empty!"
    echo ""
    echo "Adding API token to .env..."
    
    if grep -q "API_TOKEN=" .env; then
        sudo sed -i 's/API_TOKEN=.*/API_TOKEN=jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a/' .env
    else
        echo "" | sudo tee -a .env
        echo "# API Token for external job posting" | sudo tee -a .env
        echo "API_TOKEN=jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a" | sudo tee -a .env
    fi
    
    echo "✅ API token added"
    echo ""
    echo "Restarting PHP-FPM..."
    sudo systemctl restart php8.2-fpm
    echo "✅ PHP-FPM restarted"
    echo ""
    
    TOKEN=$(grep "API_TOKEN=" .env | cut -d '=' -f2)
fi

echo "=========================================="
echo "Testing API Endpoints"
echo "=========================================="
echo "Token: $TOKEN"
echo ""

# Test 1: Get Categories
echo "Test 1: GET /api/categories"
echo "---"
curl -X GET "https://jobone.in/api/categories" \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json"

echo ""
echo ""

# Test 2: Get States  
echo "Test 2: GET /api/states"
echo "---"
curl -X GET "https://jobone.in/api/states" \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json"

echo ""
echo ""

# Test 3: List Posts
echo "Test 3: GET /api/posts"
echo "---"
curl -X GET "https://jobone.in/api/posts?limit=3" \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json"

echo ""
echo ""

# Test 4: Create Sample Post
echo "Test 4: POST /api/posts (Create Sample Post)"
echo "---"
curl -X POST "https://jobone.in/api/posts" \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "API Test Post - SBI Clerk 2026",
    "type": "job",
    "short_description": "This is a test post created via API to verify functionality",
    "content": "<h2>API Test Post</h2><p>This post was created to test the API endpoints.</p>",
    "category_id": 1,
    "state_id": 37,
    "total_posts": 100,
    "is_featured": false
  }'

echo ""
echo ""
echo "=========================================="
echo "✅ API Tests Complete"
echo "=========================================="
