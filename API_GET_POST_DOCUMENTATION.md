# API Get Post Documentation

## Overview
This document describes the API endpoints for retrieving posts from the Government Job Portal.

## Base URL
```
https://your-domain.com/api
```

## Authentication
All endpoints (except categories and states) require Bearer token authentication.

### Headers
```
Authorization: Bearer {your_api_token}
Content-Type: application/json
```

The API token is stored in the `.env` file as `API_TOKEN`.

---

## Endpoints

### 1. Get Single Post by ID

Retrieve a specific post by its ID.

**Endpoint:** `GET /api/posts/{id}`

**Authentication:** Required

**Parameters:**
- `id` (path parameter) - The post ID

**Example Request:**
```bash
curl -X GET "https://your-domain.com/api/posts/123" \
  -H "Authorization: Bearer jobone_sk_live_your_token_here" \
  -H "Content-Type: application/json"
```

**Success Response (200):**
```json
{
  "success": true,
  "data": {
    "id": 123,
    "title": "Railway Recruitment 2024",
    "slug": "railway-recruitment-2024",
    "type": "job",
    "short_description": "Railway is hiring for various positions",
    "content": "Full job description...",
    "category_id": 5,
    "state_id": 12,
    "last_date": "2024-12-31",
    "notification_date": "2024-11-01",
    "total_posts": 500,
    "important_links": [
      {
        "title": "Apply Online",
        "url": "https://example.com/apply"
      }
    ],
    "is_featured": true,
    "meta_title": "Railway Recruitment 2024",
    "meta_description": "Apply for Railway jobs...",
    "meta_keywords": "railway,jobs,recruitment",
    "created_at": "2024-11-01T10:00:00.000000Z",
    "updated_at": "2024-11-01T10:00:00.000000Z"
  }
}
```

**Error Responses:**

401 Unauthorized:
```json
{
  "error": "Unauthorized"
}
```

404 Not Found:
```json
{
  "error": "Post not found"
}
```

---

### 2. List All Posts (with Pagination)

Retrieve a paginated list of posts with optional filtering.

**Endpoint:** `GET /api/posts`

**Authentication:** Required

**Query Parameters:**
- `page` (optional, default: 1) - Page number
- `limit` (optional, default: 15) - Number of posts per page
- `type` (optional) - Filter by post type: `job`, `admit_card`, `result`, `answer_key`, `syllabus`, `blog`
- `category_id` (optional) - Filter by category ID
- `state_id` (optional) - Filter by state ID

**Example Requests:**

Basic request:
```bash
curl -X GET "https://your-domain.com/api/posts" \
  -H "Authorization: Bearer jobone_sk_live_your_token_here" \
  -H "Content-Type: application/json"
```

With filters:
```bash
curl -X GET "https://your-domain.com/api/posts?page=2&limit=20&type=job&category_id=5" \
  -H "Authorization: Bearer jobone_sk_live_your_token_here" \
  -H "Content-Type: application/json"
```

**Success Response (200):**
```json
{
  "success": true,
  "data": [
    {
      "id": 123,
      "title": "Railway Recruitment 2024",
      "slug": "railway-recruitment-2024",
      "type": "job",
      "short_description": "Railway is hiring...",
      "content": "Full description...",
      "category_id": 5,
      "state_id": 12,
      "last_date": "2024-12-31",
      "notification_date": "2024-11-01",
      "total_posts": 500,
      "important_links": [],
      "is_featured": true,
      "meta_title": "Railway Recruitment 2024",
      "meta_description": "Apply for Railway jobs...",
      "meta_keywords": "railway,jobs,recruitment",
      "created_at": "2024-11-01T10:00:00.000000Z",
      "updated_at": "2024-11-01T10:00:00.000000Z"
    }
  ],
  "pagination": {
    "total": 150,
    "per_page": 15,
    "current_page": 1,
    "last_page": 10
  }
}
```

**Error Response:**

401 Unauthorized:
```json
{
  "error": "Unauthorized"
}
```

---

### 3. Get All Categories (Public)

Retrieve all available categories. No authentication required.

**Endpoint:** `GET /api/categories`

**Authentication:** Not required

**Example Request:**
```bash
curl -X GET "https://your-domain.com/api/categories" \
  -H "Content-Type: application/json"
```

**Success Response (200):**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "Banking",
      "slug": "banking"
    },
    {
      "id": 2,
      "name": "Railway",
      "slug": "railway"
    }
  ]
}
```

---

### 4. Get All States (Public)

Retrieve all available states. No authentication required.

**Endpoint:** `GET /api/states`

**Authentication:** Not required

**Example Request:**
```bash
curl -X GET "https://your-domain.com/api/states" \
  -H "Content-Type: application/json"
```

**Success Response (200):**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "Karnataka",
      "slug": "karnataka"
    },
    {
      "id": 2,
      "name": "Maharashtra",
      "slug": "maharashtra"
    }
  ]
}
```

---

## Post Types

The following post types are available:
- `job` - Job notifications
- `admit_card` - Admit card releases
- `result` - Result announcements
- `answer_key` - Answer key publications
- `syllabus` - Syllabus information
- `blog` - Blog posts

---

## Data Model

### Post Object Structure

| Field | Type | Description |
|-------|------|-------------|
| id | integer | Unique post identifier |
| title | string | Post title (max 255 chars) |
| slug | string | URL-friendly version of title |
| type | string | Post type (job, admit_card, etc.) |
| short_description | string | Brief description |
| content | text | Full post content (HTML) |
| category_id | integer | Associated category ID |
| state_id | integer/null | Associated state ID (optional) |
| last_date | date/null | Application deadline |
| notification_date | date/null | Notification release date |
| total_posts | integer/null | Number of vacancies |
| important_links | array | Array of link objects |
| is_featured | boolean | Featured post flag |
| meta_title | string | SEO title (max 60 chars) |
| meta_description | string | SEO description (max 160 chars) |
| meta_keywords | string | SEO keywords |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Last update timestamp |

### Important Links Structure

```json
{
  "title": "Link Title",
  "url": "https://example.com"
}
```

---

## Error Handling

All endpoints return appropriate HTTP status codes:

- `200` - Success
- `201` - Created (for POST requests)
- `401` - Unauthorized (invalid or missing token)
- `404` - Not Found (resource doesn't exist)
- `422` - Validation Error (invalid input)
- `500` - Server Error

---

## Rate Limiting

Currently, no rate limiting is implemented. Consider implementing rate limiting for production use.

---

## Token Management

### Get Current Token Info

**Endpoint:** `GET /api/token`

**Authentication:** Required

Returns information about the current API token.

### Generate New Token

**Endpoint:** `POST /api/token/generate`

**Authentication:** Required (using current token)

Generates a new API token and updates the `.env` file. Requires PHP-FPM restart to take effect.

---

## Examples

### JavaScript (Fetch API)

```javascript
// Get single post
async function getPost(postId) {
  const response = await fetch(`https://your-domain.com/api/posts/${postId}`, {
    headers: {
      'Authorization': 'Bearer jobone_sk_live_your_token_here',
      'Content-Type': 'application/json'
    }
  });
  
  const data = await response.json();
  return data;
}

// List posts with filters
async function listPosts(filters = {}) {
  const params = new URLSearchParams(filters);
  const response = await fetch(`https://your-domain.com/api/posts?${params}`, {
    headers: {
      'Authorization': 'Bearer jobone_sk_live_your_token_here',
      'Content-Type': 'application/json'
    }
  });
  
  const data = await response.json();
  return data;
}

// Usage
const post = await getPost(123);
const jobs = await listPosts({ type: 'job', page: 1, limit: 20 });
```

### PHP (cURL)

```php
<?php

function getPost($postId, $token) {
    $ch = curl_init();
    
    curl_setopt($ch, CURLOPT_URL, "https://your-domain.com/api/posts/{$postId}");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer {$token}",
        "Content-Type: application/json"
    ]);
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    return json_decode($response, true);
}

// Usage
$token = 'jobone_sk_live_your_token_here';
$post = getPost(123, $token);
```

### Python (Requests)

```python
import requests

def get_post(post_id, token):
    url = f"https://your-domain.com/api/posts/{post_id}"
    headers = {
        "Authorization": f"Bearer {token}",
        "Content-Type": "application/json"
    }
    
    response = requests.get(url, headers=headers)
    return response.json()

def list_posts(token, filters=None):
    url = "https://your-domain.com/api/posts"
    headers = {
        "Authorization": f"Bearer {token}",
        "Content-Type": "application/json"
    }
    
    response = requests.get(url, headers=headers, params=filters)
    return response.json()

# Usage
token = "jobone_sk_live_your_token_here"
post = get_post(123, token)
jobs = list_posts(token, {"type": "job", "page": 1, "limit": 20})
```

---

## Security Notes

1. Always use HTTPS in production
2. Keep your API token secure and never commit it to version control
3. Rotate tokens periodically using the token generation endpoint
4. Consider implementing rate limiting to prevent abuse
5. Monitor API usage for suspicious activity

---

## Support

For issues or questions, please contact the development team.
