# API Field Mapping Guide - Frontend to API

## Overview
This guide shows you exactly what data fields are available in the frontend post form and how to provide them through the API for external job posting.

---

## Frontend Form Fields vs API Fields

### Frontend Post Form (What you see in admin panel)

When you create a post in the admin panel at `https://jobone.in/admin/posts/create`, you see these fields:

```
Title *
Type * (Select: Job, Admit Card, Syllabus, Result, Answer Key, Blog)
Category * (Select: Banking, Railways, SSC, UPSC, Defence, Police, Teaching, PSU, State Govt, Central Govt, Court, Medical, Engineering, Agriculture, Post Office)
State (Select: Andhra Pradesh, Arunachal Pradesh, ... All India)
Content *
Meta Title (max 60 chars)
Meta Description (max 160 chars)
Meta Keywords
Featured Post (Checkbox)
Published (Checkbox)
```

### API Request Fields (What you send through API)

When you post through the API at `POST https://jobone.in/api/posts/create`, you send:

```json
{
  "title": "string (required)",
  "type": "string (required)",
  "short_description": "string (required)",
  "content": "string (required)",
  "category_id": "integer (required)",
  "state_id": "integer (optional)",
  "last_date": "date (optional)",
  "notification_date": "date (optional)",
  "total_posts": "integer (optional)",
  "meta_title": "string (optional)",
  "meta_description": "string (optional)",
  "meta_keywords": "string (optional)",
  "is_featured": "boolean (optional)",
  "important_links": "object (optional)"
}
```

---

## Field-by-Field Mapping

| Frontend Field | API Field | Type | Required | Notes |
|---|---|---|---|---|
| Title | `title` | string | ✅ Yes | Max 255 characters |
| Type | `type` | string | ✅ Yes | job, admit_card, result, answer_key, syllabus, blog |
| Category | `category_id` | integer | ✅ Yes | Get ID from `/api/categories` |
| State | `state_id` | integer | ❌ No | Get ID from `/api/states` |
| Content | `content` | string | ✅ Yes | HTML allowed |
| Meta Title | `meta_title` | string | ❌ No | Max 60 characters for SEO |
| Meta Description | `meta_description` | string | ❌ No | Max 160 characters for SEO |
| Meta Keywords | `meta_keywords` | string | ❌ No | Comma-separated keywords |
| Featured Post | `is_featured` | boolean | ❌ No | true or false |
| Published | Auto | - | - | Posts are auto-published via API |
| - | `short_description` | string | ✅ Yes | Brief summary (1-2 sentences) |
| - | `last_date` | date | ❌ No | Format: YYYY-MM-DD |
| - | `notification_date` | date | ❌ No | Format: YYYY-MM-DD |
| - | `total_posts` | integer | ❌ No | Number of vacancies |
| - | `important_links` | object | ❌ No | External links (see below) |

---

## Important Links Format

The `important_links` field allows you to add external links like official notification, apply online, admit card, etc.

### Format:
```json
{
  "important_links": {
    "official_website": "https://sbi.co.in",
    "apply_online": "https://sbi.co.in/apply",
    "notification": "https://sbi.co.in/notification.pdf",
    "admit_card": "https://sbi.co.in/admit-card"
  }
}
```

### Or as array:
```json
{
  "important_links": [
    {
      "label": "Official Website",
      "url": "https://sbi.co.in"
    },
    {
      "label": "Apply Online",
      "url": "https://sbi.co.in/apply"
    }
  ]
}
```

---

## Complete API Request Example

Here's a complete example showing all available fields:

```json
{
  "title": "SBI Clerk Recruitment 2026 - 5000 Posts",
  "type": "job",
  "short_description": "State Bank of India is recruiting 5000 Clerk positions across India. Eligibility: 12th Pass. Salary: Rs 20,000-30,000",
  "content": "<h2>SBI Clerk Recruitment 2026</h2><p><strong>Eligibility:</strong> 12th Pass</p><p><strong>Salary:</strong> Rs 20,000-30,000</p><p><strong>Age Limit:</strong> 18-28 years</p><p><strong>Selection Process:</strong> Prelims, Mains, Interview</p>",
  "category_id": 1,
  "state_id": 37,
  "last_date": "2026-04-15",
  "notification_date": "2026-03-09",
  "total_posts": 5000,
  "meta_title": "SBI Clerk Recruitment 2026 - 5000 Posts",
  "meta_description": "Apply for SBI Clerk 2026. 5000 vacancies. Last date 15 Apr 2026. Eligibility: 12th Pass.",
  "meta_keywords": "SBI Clerk, Recruitment 2026, Banking Jobs, Government Jobs",
  "is_featured": true,
  "important_links": {
    "official_website": "https://sbi.co.in",
    "apply_online": "https://sbi.co.in/apply",
    "notification": "https://sbi.co.in/notification.pdf",
    "admit_card": "https://sbi.co.in/admit-card"
  }
}
```

---

## Minimal API Request Example

If you only want to provide required fields:

```json
{
  "title": "Railway Group D 2026",
  "type": "job",
  "short_description": "Indian Railways is recruiting 10000 Group D positions",
  "content": "<h2>Railway Group D 2026</h2><p>Full job details here...</p>",
  "category_id": 2,
  "state_id": 1
}
```

---

## Step-by-Step Guide to Post via API

### Step 1: Get Your API Token
```
API Token: jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a
```

### Step 2: Get Category IDs
```bash
curl -X GET https://jobone.in/api/categories \
  -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a"
```

Response:
```json
[
  {"id": 1, "name": "Banking"},
  {"id": 2, "name": "Railways"},
  {"id": 3, "name": "SSC"},
  {"id": 4, "name": "UPSC"},
  {"id": 5, "name": "Defence"},
  {"id": 6, "name": "Police"},
  {"id": 7, "name": "Teaching"},
  {"id": 8, "name": "PSU"},
  {"id": 9, "name": "State Govt"},
  {"id": 10, "name": "Central Govt"},
  {"id": 11, "name": "Court"},
  {"id": 12, "name": "Medical"},
  {"id": 13, "name": "Engineering"},
  {"id": 14, "name": "Agriculture"},
  {"id": 15, "name": "Post Office"}
]
```

### Step 3: Get State IDs
```bash
curl -X GET https://jobone.in/api/states \
  -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a"
```

Response:
```json
[
  {"id": 1, "name": "Andhra Pradesh"},
  {"id": 2, "name": "Arunachal Pradesh"},
  {"id": 3, "name": "Assam"},
  ...
  {"id": 37, "name": "All India"}
]
```

### Step 4: Create Job Post
```bash
curl -X POST https://jobone.in/api/posts/create \
  -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "SBI Clerk Recruitment 2026 - 5000 Posts",
    "type": "job",
    "short_description": "State Bank of India is recruiting 5000 Clerk positions",
    "content": "<h2>SBI Clerk Recruitment 2026</h2><p>Details here...</p>",
    "category_id": 1,
    "state_id": 37,
    "last_date": "2026-04-15",
    "total_posts": 5000,
    "meta_title": "SBI Clerk Recruitment 2026 - 5000 Posts",
    "meta_description": "Apply for SBI Clerk 2026. 5000 vacancies.",
    "meta_keywords": "SBI Clerk, Banking Jobs",
    "is_featured": true
  }'
```

Response:
```json
{
  "success": true,
  "message": "Post created successfully",
  "post": {
    "id": 123,
    "title": "SBI Clerk Recruitment 2026 - 5000 Posts",
    "slug": "sbi-clerk-recruitment-2026-5000-posts",
    "url": "https://jobone.in/job/sbi-clerk-recruitment-2026-5000-posts"
  }
}
```

---

## Python Script Example

```python
import requests
import json

API_TOKEN = "jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a"
BASE_URL = "https://jobone.in/api"

headers = {
    "Authorization": f"Bearer {API_TOKEN}",
    "Content-Type": "application/json"
}

# Step 1: Get categories
print("Fetching categories...")
response = requests.get(f"{BASE_URL}/categories", headers=headers)
categories = {cat['name']: cat['id'] for cat in response.json()}
print(f"Categories: {categories}")

# Step 2: Get states
print("\nFetching states...")
response = requests.get(f"{BASE_URL}/states", headers=headers)
states = {state['name']: state['id'] for state in response.json()}
print(f"States: {states}")

# Step 3: Create job post
print("\nCreating job post...")
job_data = {
    "title": "SBI Clerk Recruitment 2026 - 5000 Posts",
    "type": "job",
    "short_description": "State Bank of India is recruiting 5000 Clerk positions across India",
    "content": "<h2>SBI Clerk Recruitment 2026</h2><p><strong>Eligibility:</strong> 12th Pass</p><p><strong>Salary:</strong> Rs 20,000-30,000</p>",
    "category_id": categories['Banking'],
    "state_id": states['All India'],
    "last_date": "2026-04-15",
    "notification_date": "2026-03-09",
    "total_posts": 5000,
    "meta_title": "SBI Clerk Recruitment 2026 - 5000 Posts",
    "meta_description": "Apply for SBI Clerk 2026. 5000 vacancies. Last date 15 Apr 2026.",
    "meta_keywords": "SBI Clerk, Recruitment 2026, Banking Jobs",
    "is_featured": True,
    "important_links": {
        "official_website": "https://sbi.co.in",
        "apply_online": "https://sbi.co.in/apply",
        "notification": "https://sbi.co.in/notification.pdf"
    }
}

response = requests.post(f"{BASE_URL}/posts/create", headers=headers, json=job_data)
result = response.json()

if result.get('success'):
    print(f"✅ Post created successfully!")
    print(f"Post URL: {result['post']['url']}")
else:
    print(f"❌ Error: {result.get('error')}")
    print(f"Message: {result.get('message')}")
```

---

## Bulk Posting Script

Create `jobs.json`:
```json
[
  {
    "title": "SBI Clerk Recruitment 2026 - 5000 Posts",
    "type": "job",
    "short_description": "State Bank of India is recruiting 5000 Clerk positions",
    "content": "<h2>SBI Clerk Recruitment 2026</h2><p>Details...</p>",
    "category_id": 1,
    "state_id": 37,
    "total_posts": 5000,
    "is_featured": true
  },
  {
    "title": "Railway Group D 2026 - 10000 Posts",
    "type": "job",
    "short_description": "Indian Railways is recruiting 10000 Group D positions",
    "content": "<h2>Railway Group D 2026</h2><p>Details...</p>",
    "category_id": 2,
    "state_id": 37,
    "total_posts": 10000,
    "is_featured": true
  }
]
```

Create `post_jobs.sh`:
```bash
#!/bin/bash

API_TOKEN="jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a"
API_URL="https://jobone.in/api/posts/create"

echo "Starting bulk job posting..."

jq -c '.[]' jobs.json | while read job; do
  echo "Posting: $(echo $job | jq -r '.title')"
  
  response=$(curl -s -X POST "$API_URL" \
    -H "Authorization: Bearer $API_TOKEN" \
    -H "Content-Type: application/json" \
    -d "$job")
  
  if echo "$response" | jq -e '.success' > /dev/null 2>&1; then
    echo "✅ Posted successfully"
    echo "URL: $(echo $response | jq -r '.post.url')"
  else
    echo "❌ Failed: $(echo $response | jq -r '.error')"
  fi
  
  echo "---"
  sleep 2
done

echo "Bulk posting complete!"
```

Run:
```bash
chmod +x post_jobs.sh
./post_jobs.sh
```

---

## Field Validation Rules

| Field | Rule | Example |
|---|---|---|
| `title` | Max 255 chars | "SBI Clerk Recruitment 2026 - 5000 Posts" |
| `type` | Must be one of: job, admit_card, result, answer_key, syllabus, blog | "job" |
| `short_description` | Any length | "State Bank of India is recruiting..." |
| `content` | HTML allowed | "<h2>Title</h2><p>Details</p>" |
| `category_id` | Must exist in categories | 1 (Banking) |
| `state_id` | Must exist in states or null | 37 (All India) |
| `last_date` | YYYY-MM-DD format | "2026-04-15" |
| `notification_date` | YYYY-MM-DD format | "2026-03-09" |
| `total_posts` | Integer | 5000 |
| `meta_title` | Max 60 chars | "SBI Clerk Recruitment 2026 - 5000 Posts" |
| `meta_description` | Max 160 chars | "Apply for SBI Clerk 2026. 5000 vacancies..." |
| `meta_keywords` | Comma-separated | "SBI Clerk, Banking Jobs, Government Jobs" |
| `is_featured` | true or false | true |

---

## Common Errors & Solutions

### Error: "Unauthorized"
```json
{"error": "Unauthorized"}
```
**Solution:** Check your API token is correct in the Authorization header

### Error: "Validation Error"
```json
{"error": "Failed to create post", "message": "The given data was invalid"}
```
**Solution:** Check all required fields are provided:
- title (required)
- type (required)
- short_description (required)
- content (required)
- category_id (required)

### Error: "Category not found"
```json
{"error": "Failed to create post", "message": "..."}
```
**Solution:** Get valid category IDs from `/api/categories` endpoint

### Error: "State not found"
```json
{"error": "Failed to create post", "message": "..."}
```
**Solution:** Get valid state IDs from `/api/states` endpoint or use null for state_id

---

## Testing Your API Integration

### Using Postman:
1. Create new POST request
2. URL: `https://jobone.in/api/posts/create`
3. Headers tab:
   - Key: `Authorization`
   - Value: `Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a`
   - Key: `Content-Type`
   - Value: `application/json`
4. Body tab (raw, JSON):
   ```json
   {
     "title": "Test Job Post",
     "type": "job",
     "short_description": "Test description",
     "content": "<p>Test content</p>",
     "category_id": 1,
     "state_id": 37
   }
   ```
5. Click Send

### Using cURL:
```bash
curl -X POST https://jobone.in/api/posts/create \
  -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Test Job Post",
    "type": "job",
    "short_description": "Test description",
    "content": "<p>Test content</p>",
    "category_id": 1,
    "state_id": 37
  }'
```

---

## Summary

**To post a job externally through the API:**

1. ✅ Get your API token: `jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a`
2. ✅ Get category IDs from `/api/categories`
3. ✅ Get state IDs from `/api/states`
4. ✅ Prepare your job data with required fields
5. ✅ Send POST request to `/api/posts/create` with Bearer token
6. ✅ Job post will be created and published automatically

**Required fields:**
- title
- type
- short_description
- content
- category_id

**Optional fields:**
- state_id
- last_date
- notification_date
- total_posts
- meta_title
- meta_description
- meta_keywords
- is_featured
- important_links

---

**API Version:** 1.0  
**Last Updated:** March 12, 2026  
**Status:** ✅ Production Ready
