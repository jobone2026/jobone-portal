# Complete API Documentation - Government Job Portal

## 📋 Overview
This API allows you to manage job posts, admit cards, results, and other content programmatically.

**Base URL:** `https://jobone.in/api` or `https://karnatakajob.one/api`

---

## 🔐 Authentication

All endpoints (except categories and states) require Bearer token authentication.

### Your API Token
```
jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a
```

### Headers Required
```http
Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a
Content-Type: application/json
```

---

## 📚 API Endpoints

### 1. GET - List All Posts (with Pagination)

Retrieve a paginated list of posts with optional filtering.

**Endpoint:** `GET /api/posts`

**Authentication:** Required ✅

**Query Parameters:**
| Parameter | Type | Required | Default | Description |
|-----------|------|----------|---------|-------------|
| page | integer | No | 1 | Page number |
| limit | integer | No | 15 | Posts per page (max 100) |
| type | string | No | - | Filter by type: `job`, `admit_card`, `result`, `answer_key`, `syllabus`, `blog` |
| category_id | integer | No | - | Filter by category ID |
| state_id | integer | No | - | Filter by state ID |

**Example Request:**
```bash
curl -X GET "https://jobone.in/api/posts?page=1&limit=20&type=job" \
  -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a" \
  -H "Content-Type: application/json"
```

**Success Response (200):**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "title": "SSC CGL 2024 Notification",
      "slug": "ssc-cgl-2024-notification",
      "type": "job",
      "short_description": "SSC Combined Graduate Level Exam 2024",
      "content": "<p>Full job description...</p>",
      "category_id": 1,
      "state_id": null,
      "last_date": "2024-12-31",
      "notification_date": "2024-11-01",
      "total_posts": 5000,
      "important_links": [
        {
          "title": "Apply Online",
          "url": "https://ssc.nic.in"
        }
      ],
      "is_featured": true,
      "meta_title": "SSC CGL 2024 Notification",
      "meta_description": "Apply for SSC CGL 2024...",
      "meta_keywords": "ssc,cgl,2024,jobs",
      "created_at": "2024-11-01T10:00:00.000000Z",
      "updated_at": "2024-11-01T10:00:00.000000Z"
    }
  ],
  "pagination": {
    "total": 150,
    "per_page": 20,
    "current_page": 1,
    "last_page": 8
  }
}
```

---

### 2. GET - Single Post by ID

Retrieve a specific post by its ID.

**Endpoint:** `GET /api/posts/{id}`

**Authentication:** Required ✅

**Path Parameters:**
| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| id | integer | Yes | Post ID |

**Example Request:**
```bash
curl -X GET "https://jobone.in/api/posts/123" \
  -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a" \
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
    "content": "<p>Full job description...</p>",
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

**Error Response (404):**
```json
{
  "error": "Post not found"
}
```

---

### 3. POST - Create New Post

Create a new job post, admit card, result, etc.

**Endpoint:** `POST /api/posts`

**Authentication:** Required ✅

**Request Body:**
```json
{
  "title": "UPSC Civil Services 2024",
  "type": "job",
  "short_description": "UPSC is conducting Civil Services Examination 2024",
  "content": "<h2>About UPSC CSE 2024</h2><p>Full description here...</p>",
  "category_id": 3,
  "state_id": null,
  "last_date": "2024-12-31",
  "notification_date": "2024-11-15",
  "total_posts": 1000,
  "important_links": [
    {
      "title": "Official Notification",
      "url": "https://upsc.gov.in/notification"
    },
    {
      "title": "Apply Online",
      "url": "https://upsc.gov.in/apply"
    }
  ],
  "is_featured": true,
  "meta_title": "UPSC Civil Services 2024 Notification",
  "meta_description": "Apply for UPSC CSE 2024. 1000 vacancies available.",
  "meta_keywords": "upsc,civil services,ias,ips,2024"
}
```

**Field Validation:**
| Field | Type | Required | Max Length | Description |
|-------|------|----------|------------|-------------|
| title | string | Yes | 255 | Post title |
| type | string | Yes | - | Must be: `job`, `admit_card`, `result`, `answer_key`, `syllabus`, `blog` |
| short_description | string | Yes | - | Brief description |
| content | string | Yes | - | Full content (HTML allowed) |
| category_id | integer | Yes | - | Must exist in categories table |
| state_id | integer | No | - | Must exist in states table (null for all-India) |
| last_date | date | No | - | Format: YYYY-MM-DD |
| notification_date | date | No | - | Format: YYYY-MM-DD |
| total_posts | integer | No | - | Number of vacancies |
| important_links | array | No | - | Array of {title, url} objects |
| is_featured | boolean | No | - | Default: false |
| meta_title | string | No | 60 | SEO title |
| meta_description | string | No | 160 | SEO description |
| meta_keywords | string | No | - | Comma-separated keywords |

**Example Request:**
```bash
curl -X POST "https://jobone.in/api/posts" \
  -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "UPSC Civil Services 2024",
    "type": "job",
    "short_description": "UPSC is conducting Civil Services Examination 2024",
    "content": "<h2>About UPSC CSE 2024</h2><p>Full description...</p>",
    "category_id": 3,
    "last_date": "2024-12-31",
    "notification_date": "2024-11-15",
    "total_posts": 1000,
    "important_links": [
      {"title": "Apply Online", "url": "https://upsc.gov.in/apply"}
    ],
    "is_featured": true
  }'
```

**Success Response (201):**
```json
{
  "success": true,
  "message": "Post created successfully",
  "data": {
    "id": 456,
    "title": "UPSC Civil Services 2024",
    "slug": "upsc-civil-services-2024",
    "type": "job",
    "short_description": "UPSC is conducting Civil Services Examination 2024",
    "content": "<h2>About UPSC CSE 2024</h2><p>Full description...</p>",
    "category_id": 3,
    "state_id": null,
    "last_date": "2024-12-31",
    "notification_date": "2024-11-15",
    "total_posts": 1000,
    "important_links": [
      {"title": "Apply Online", "url": "https://upsc.gov.in/apply"}
    ],
    "is_featured": true,
    "meta_title": "UPSC Civil Services 2024",
    "meta_description": "UPSC is conducting Civil Services Examination 2024",
    "meta_keywords": "UPSC,Civil,Services,2024",
    "created_at": "2024-11-15T10:30:00.000000Z",
    "updated_at": "2024-11-15T10:30:00.000000Z"
  }
}
```

**Error Response (422):**
```json
{
  "message": "The title field is required.",
  "errors": {
    "title": ["The title field is required."],
    "type": ["The type field is required."]
  }
}
```

---

### 4. PUT - Update Post

Update an existing post.

**Endpoint:** `PUT /api/posts/{id}`

**Authentication:** Required ✅

**Path Parameters:**
| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| id | integer | Yes | Post ID to update |

**Request Body:** (All fields are optional, only send fields you want to update)
```json
{
  "title": "Updated Title",
  "last_date": "2025-01-31",
  "is_featured": false
}
```

**Example Request:**
```bash
curl -X PUT "https://jobone.in/api/posts/456" \
  -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a" \
  -H "Content-Type: application/json" \
  -d '{
    "last_date": "2025-01-31",
    "is_featured": false
  }'
```

**Success Response (200):**
```json
{
  "success": true,
  "message": "Post updated successfully",
  "data": {
    "id": 456,
    "title": "UPSC Civil Services 2024",
    "last_date": "2025-01-31",
    "is_featured": false,
    "updated_at": "2024-11-16T14:20:00.000000Z"
  }
}
```

---

### 5. DELETE - Delete Post

Delete a post permanently.

**Endpoint:** `DELETE /api/posts/{id}`

**Authentication:** Required ✅

**Path Parameters:**
| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| id | integer | Yes | Post ID to delete |

**Example Request:**
```bash
curl -X DELETE "https://jobone.in/api/posts/456" \
  -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a" \
  -H "Content-Type: application/json"
```

**Success Response (200):**
```json
{
  "success": true,
  "message": "Post deleted successfully"
}
```

**Error Response (404):**
```json
{
  "error": "Post not found"
}
```

---

### 6. GET - All Categories (Public)

Get all available categories. No authentication required.

**Endpoint:** `GET /api/categories`

**Authentication:** Not Required ❌

**Example Request:**
```bash
curl -X GET "https://jobone.in/api/categories" \
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
    },
    {
      "id": 3,
      "name": "UPSC",
      "slug": "upsc"
    },
    {
      "id": 4,
      "name": "SSC",
      "slug": "ssc"
    }
  ]
}
```

---

### 7. GET - All States (Public)

Get all available states. No authentication required.

**Endpoint:** `GET /api/states`

**Authentication:** Not Required ❌

**Example Request:**
```bash
curl -X GET "https://jobone.in/api/states" \
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
    },
    {
      "id": 3,
      "name": "Tamil Nadu",
      "slug": "tamil-nadu"
    }
  ]
}
```

---

### 8. GET - Token Info

Get information about your current API token.

**Endpoint:** `GET /api/token`

**Authentication:** Required ✅

**Example Request:**
```bash
curl -X GET "https://jobone.in/api/token" \
  -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a" \
  -H "Content-Type: application/json"
```

**Success Response (200):**
```json
{
  "success": true,
  "token": "jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a",
  "status": "active"
}
```

---

### 9. POST - Generate New Token

Generate a new API token (invalidates the old one).

**Endpoint:** `POST /api/token/generate`

**Authentication:** Required ✅ (using current token)

**Example Request:**
```bash
curl -X POST "https://jobone.in/api/token/generate" \
  -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a" \
  -H "Content-Type: application/json"
```

**Success Response (200):**
```json
{
  "success": true,
  "message": "New API token generated",
  "token": "jobone_sk_live_a1b2c3d4e5f6g7h8i9j0k1l2m3n4o5p6",
  "note": "Please restart PHP-FPM for changes to take effect"
}
```

---

## 📝 Post Types

| Type | Description |
|------|-------------|
| `job` | Job notifications and recruitment |
| `admit_card` | Admit card releases |
| `result` | Result announcements |
| `answer_key` | Answer key publications |
| `syllabus` | Syllabus and exam pattern |
| `blog` | Blog posts and articles |

---

## 🔧 Code Examples

### JavaScript (Fetch API)

```javascript
const API_TOKEN = 'jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a';
const BASE_URL = 'https://jobone.in/api';

// Get all posts
async function getPosts(filters = {}) {
  const params = new URLSearchParams(filters);
  const response = await fetch(`${BASE_URL}/posts?${params}`, {
    headers: {
      'Authorization': `Bearer ${API_TOKEN}`,
      'Content-Type': 'application/json'
    }
  });
  return await response.json();
}

// Create a new post
async function createPost(postData) {
  const response = await fetch(`${BASE_URL}/posts`, {
    method: 'POST',
    headers: {
      'Authorization': `Bearer ${API_TOKEN}`,
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(postData)
  });
  return await response.json();
}

// Update a post
async function updatePost(postId, updates) {
  const response = await fetch(`${BASE_URL}/posts/${postId}`, {
    method: 'PUT',
    headers: {
      'Authorization': `Bearer ${API_TOKEN}`,
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(updates)
  });
  return await response.json();
}

// Delete a post
async function deletePost(postId) {
  const response = await fetch(`${BASE_URL}/posts/${postId}`, {
    method: 'DELETE',
    headers: {
      'Authorization': `Bearer ${API_TOKEN}`,
      'Content-Type': 'application/json'
    }
  });
  return await response.json();
}

// Usage examples
const jobs = await getPosts({ type: 'job', page: 1, limit: 20 });
const newPost = await createPost({
  title: 'New Job Notification',
  type: 'job',
  short_description: 'Description here',
  content: '<p>Full content</p>',
  category_id: 1
});
```

---

### PHP (cURL)

```php
<?php

$API_TOKEN = 'jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a';
$BASE_URL = 'https://jobone.in/api';

// Get all posts
function getPosts($filters = []) {
    global $API_TOKEN, $BASE_URL;
    
    $query = http_build_query($filters);
    $ch = curl_init();
    
    curl_setopt($ch, CURLOPT_URL, "$BASE_URL/posts?$query");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer $API_TOKEN",
        "Content-Type: application/json"
    ]);
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    return json_decode($response, true);
}

// Create a new post
function createPost($postData) {
    global $API_TOKEN, $BASE_URL;
    
    $ch = curl_init();
    
    curl_setopt($ch, CURLOPT_URL, "$BASE_URL/posts");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer $API_TOKEN",
        "Content-Type: application/json"
    ]);
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    return json_decode($response, true);
}

// Update a post
function updatePost($postId, $updates) {
    global $API_TOKEN, $BASE_URL;
    
    $ch = curl_init();
    
    curl_setopt($ch, CURLOPT_URL, "$BASE_URL/posts/$postId");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($updates));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer $API_TOKEN",
        "Content-Type: application/json"
    ]);
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    return json_decode($response, true);
}

// Delete a post
function deletePost($postId) {
    global $API_TOKEN, $BASE_URL;
    
    $ch = curl_init();
    
    curl_setopt($ch, CURLOPT_URL, "$BASE_URL/posts/$postId");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer $API_TOKEN",
        "Content-Type: application/json"
    ]);
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    return json_decode($response, true);
}

// Usage
$jobs = getPosts(['type' => 'job', 'page' => 1, 'limit' => 20]);
$newPost = createPost([
    'title' => 'New Job Notification',
    'type' => 'job',
    'short_description' => 'Description here',
    'content' => '<p>Full content</p>',
    'category_id' => 1
]);
```

---

### Python (Requests)

```python
import requests

API_TOKEN = 'jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a'
BASE_URL = 'https://jobone.in/api'

headers = {
    'Authorization': f'Bearer {API_TOKEN}',
    'Content-Type': 'application/json'
}

# Get all posts
def get_posts(filters=None):
    response = requests.get(f'{BASE_URL}/posts', headers=headers, params=filters)
    return response.json()

# Create a new post
def create_post(post_data):
    response = requests.post(f'{BASE_URL}/posts', headers=headers, json=post_data)
    return response.json()

# Update a post
def update_post(post_id, updates):
    response = requests.put(f'{BASE_URL}/posts/{post_id}', headers=headers, json=updates)
    return response.json()

# Delete a post
def delete_post(post_id):
    response = requests.delete(f'{BASE_URL}/posts/{post_id}', headers=headers)
    return response.json()

# Usage
jobs = get_posts({'type': 'job', 'page': 1, 'limit': 20})
new_post = create_post({
    'title': 'New Job Notification',
    'type': 'job',
    'short_description': 'Description here',
    'content': '<p>Full content</p>',
    'category_id': 1
})
```

---

## ⚠️ Error Codes

| Code | Description |
|------|-------------|
| 200 | Success |
| 201 | Created (POST success) |
| 401 | Unauthorized (invalid/missing token) |
| 404 | Not Found (resource doesn't exist) |
| 422 | Validation Error (invalid input) |
| 500 | Server Error |

---

## 🔒 Security Best Practices

1. ✅ Always use HTTPS in production
2. ✅ Keep your API token secure - never commit to version control
3. ✅ Rotate tokens periodically using `/api/token/generate`
4. ✅ Monitor API usage for suspicious activity
5. ✅ Use environment variables for token storage
6. ✅ Implement rate limiting on your end if making bulk requests

---

## 📞 Support

For API issues or questions:
- Check server logs: `/var/log/nginx/error.log`
- Laravel logs: `storage/logs/laravel.log`
- Contact: Development Team

---

## 🚀 Quick Start

1. **Test Connection:**
```bash
curl -X GET "https://jobone.in/api/categories"
```

2. **Test Authentication:**
```bash
curl -X GET "https://jobone.in/api/token" \
  -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a"
```

3. **Create Your First Post:**
```bash
curl -X POST "https://jobone.in/api/posts" \
  -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Test Job Post",
    "type": "job",
    "short_description": "This is a test",
    "content": "<p>Test content</p>",
    "category_id": 1
  }'
```

---

**Last Updated:** March 19, 2026  
**API Version:** 1.0
