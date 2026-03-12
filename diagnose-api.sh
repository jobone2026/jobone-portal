#!/bin/bash

TOKEN="jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a"
BASE_URL="https://jobone.in/api"

echo "=========================================="
echo "API Diagnostics"
echo "=========================================="

echo ""
echo "Test 1: GET /api/categories (raw response)"
echo "=========================================="
curl -v -H "Authorization: Bearer $TOKEN" "$BASE_URL/categories" 2>&1

echo ""
echo ""
echo "=========================================="
echo "Checking Laravel logs..."
echo "=========================================="
tail -100 /var/www/jobone/storage/logs/laravel.log

echo ""
echo "=========================================="
echo "Checking PHP-FPM error log..."
echo "=========================================="
sudo tail -50 /var/log/php8.2-fpm.log

echo ""
echo "=========================================="
echo "Checking Nginx error log..."
echo "=========================================="
sudo tail -50 /var/log/nginx/error.log
