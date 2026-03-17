#!/bin/bash

# Test API - Create a job post
API_URL="https://jobone.in/api/posts"
API_TOKEN="jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a"

echo "Testing API - Creating a job post..."
echo ""

curl -X POST "$API_URL" \
  -H "Authorization: Bearer $API_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "UPSC Civil Services 2024 - Test Job",
    "type": "job",
    "short_description": "Union Public Service Commission invites applications for Civil Services Examination 2024",
    "content": "<p>This is a test job posting. Apply now to secure your future in government service.</p>",
    "category_id": 4,
    "state_id": 29,
    "total_posts": 1000,
    "last_date": "2026-06-30",
    "notification_date": "2026-03-16",
    "is_featured": true,
    "is_published": true,
    "meta_title": "UPSC Civil Services 2024",
    "meta_description": "Apply for UPSC Civil Services Examination 2024",
    "meta_keywords": "UPSC,Civil Services,Government Job"
  }' | jq .

echo ""
echo "Test complete!"
