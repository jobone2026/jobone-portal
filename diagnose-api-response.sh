#!/bin/bash

TOKEN="jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a"
BASE_URL="https://jobone.in/api"

echo "=========================================="
echo "API Response Diagnostics"
echo "=========================================="
echo ""

echo "Test 1: GET /api/categories (RAW RESPONSE)"
echo "=========================================="
RESPONSE=$(curl -s -i -H "Authorization: Bearer $TOKEN" "$BASE_URL/categories")
echo "$RESPONSE"
echo ""
echo "First 500 chars of body:"
echo "$RESPONSE" | tail -n +$(echo "$RESPONSE" | grep -n "^$" | head -1 | cut -d: -f1) | head -c 500
echo ""
echo ""

echo "Test 2: GET /api/states (RAW RESPONSE)"
echo "=========================================="
RESPONSE=$(curl -s -i -H "Authorization: Bearer $TOKEN" "$BASE_URL/states")
echo "$RESPONSE"
echo ""
echo "First 500 chars of body:"
echo "$RESPONSE" | tail -n +$(echo "$RESPONSE" | grep -n "^$" | head -1 | cut -d: -f1) | head -c 500
echo ""
echo ""

echo "Test 3: GET /api/posts (RAW RESPONSE)"
echo "=========================================="
RESPONSE=$(curl -s -i -H "Authorization: Bearer $TOKEN" "$BASE_URL/posts?limit=2")
echo "$RESPONSE"
echo ""
echo "First 500 chars of body:"
echo "$RESPONSE" | tail -n +$(echo "$RESPONSE" | grep -n "^$" | head -1 | cut -d: -f1) | head -c 500
echo ""

echo "=========================================="
echo "✅ Diagnostics Complete"
echo "=========================================="
