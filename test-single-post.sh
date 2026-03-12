#!/bin/bash

TOKEN="jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a"
BASE_URL="https://jobone.in/api"

echo "=========================================="
echo "Testing Single Post Creation"
echo "=========================================="

echo ""
echo "Creating a new job post..."
echo "=========================================="

curl -X POST -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Test Government Job Post 2026",
    "type": "job",
    "short_description": "This is a test job posting created via API to verify functionality",
    "content": "<h2>Job Details</h2><p>This is a comprehensive test post to validate the API endpoint.</p><ul><li>Test item 1</li><li>Test item 2</li><li>Test item 3</li></ul>",
    "category_id": 1,
    "state_id": 11,
    "total_posts": 100,
    "last_date": "2026-04-30",
    "notification_date": "2026-03-12",
    "is_featured": true,
    "meta_title": "Test Government Job Post 2026",
    "meta_description": "This is a test job posting created via API",
    "meta_keywords": "test, government job, api, 2026"
  }' \
  "$BASE_URL/posts" | jq '.'

echo ""
echo "=========================================="
echo "✅ Test Complete"
echo "=========================================="
