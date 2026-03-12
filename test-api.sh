#!/bin/bash

echo "=========================================="
echo "API Token Verification & Test"
echo "=========================================="

# Check current API token in .env
echo "📋 Current API Token in .env:"
grep "API_TOKEN=" .env

echo ""
echo "=========================================="
echo "Testing API Endpoints"
echo "=========================================="

# Get the token from .env
TOKEN=$(grep "API_TOKEN=" .env | cut -d '=' -f2)

echo "Using token: $TOKEN"
echo ""

# Test 1: Get Categories
echo "Test 1: GET /api/categories"
curl -s -X GET "https://jobone.in/api/categories" \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json" | jq '.'

echo ""
echo "=========================================="

# Test 2: Get States
echo "Test 2: GET /api/states"
curl -s -X GET "https://jobone.in/api/states" \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json" | jq '.'

echo ""
echo "=========================================="

# Test 3: List Posts
echo "Test 3: GET /api/posts"
curl -s -X GET "https://jobone.in/api/posts?limit=5" \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json" | jq '.'

echo ""
echo "=========================================="

# Test 4: Create Sample Post
echo "Test 4: POST /api/posts (Create Sample Post)"
curl -s -X POST "https://jobone.in/api/posts" \
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
  }' | jq '.'

echo ""
echo "=========================================="
echo "✅ API Tests Complete"
echo "=========================================="
