#!/bin/bash

TOKEN="jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a"
BASE_URL="https://jobone.in/api"

echo "=========================================="
echo "Testing API Endpoints"
echo "=========================================="
echo "Using token: ${TOKEN:0:20}..."
echo ""

echo "=========================================="
echo "Test 1: GET /api/categories"
echo "=========================================="
curl -s -H "Authorization: Bearer $TOKEN" "$BASE_URL/categories"
echo ""

echo ""
echo "=========================================="
echo "Test 2: GET /api/states"
echo "=========================================="
curl -s -H "Authorization: Bearer $TOKEN" "$BASE_URL/states"
echo ""

echo ""
echo "=========================================="
echo "Test 3: GET /api/posts"
echo "=========================================="
curl -s -H "Authorization: Bearer $TOKEN" "$BASE_URL/posts?limit=2"
echo ""

echo ""
echo "=========================================="
echo "Test 4: POST /api/posts (Create Sample Post)"
echo "=========================================="
curl -s -X POST -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "API Test Post",
    "type": "job",
    "short_description": "This is a test post created via API",
    "content": "Test content for API validation",
    "category_id": 1,
    "state_id": 1
  }' \
  "$BASE_URL/posts"
echo ""

echo ""
echo "=========================================="
echo "✅ API Tests Complete"
echo "=========================================="
