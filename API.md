# JobOne.in Complete API Reference

## Authentication

All API endpoints require Bearer token authentication:

```
Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a
Content-Type: application/json
```

---

## Endpoints

### 1. List Posts
**GET** `/api/posts`

List all posts with pagination and filtering.

**Query Parameters:**
- `page` (int) - Page number (default: 1)
- `limit` (int) - Items per page (default: 15)
- `type` (string) - Filter by type (job, admit_card, result, etc.)
- `category_id` (int) - Filter by category
- `state_id` (int) - Filter by state

**Example:**
```bash
curl -X GET "https://jobone.in/api/posts?page=1&limit=10&type=job&category_id=1" \
  -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a"
```

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "title": "SBI Clerk Recruitment 2026",
      "type": "job",
      "category_id": 1,
      "state_id": 37,
      "total_posts": 5000,
      "is_featured": true,
      "created_at": "2026-03-12T10:00:00Z"
    }
  ],
  "pagination": {
    "total": 100,
    "per_page": 10,
    "current_page": 1,
    "last_page": 10
  }
}
```

---

### 2. Get Single Post
**GET** `/api/posts/{id}`

Get details of a specific post.

**Example:**
```bash
curl -X GET "https://jobone.in/api/posts/1" \
  -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a"
```

**Response:**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "title": "SBI Clerk Recruitment 2026 - 5000 Posts",
    "type": "job",
    "short_description": "State Bank of India is recruiting 5000 Clerk positions",
    "content": "<h2>SBI Clerk Recruitment 2026</h2>...",
    "category_id": 1,
    "state_id": 37,
    "last_date": "2026-04-15",
    "notification_date": "2026-03-09",
    "total_posts": 5000,
    "is_featured": true,
    "meta_title": "SBI Clerk Recruitment 2026 - 5000 Posts",
    "meta_description": "Apply for SBI Clerk 2026. 5000 vacancies.",
    "meta_keywords": "SBI Clerk, Banking Jobs",
    "important_links": {},
    "created_at": "2026-03-12T10:00:00Z",
    "updated_at": "2026-03-12T10:00:00Z"
  }
}
```

---

### 3. Create Post
**POST** `/api/posts`

Create a new job post.

**Request Body:**
```json
{
  "title": "SBI Clerk Recruitment 2026 - 5000 Posts",
  "type": "job",
  "short_description": "State Bank of India is recruiting 5000 Clerk positions",
  "content": "<h2>SBI Clerk Recruitment 2026</h2><p>Details...</p>",
  "category_id": 1,
  "state_id": 37,
  "last_date": "2026-04-15",
  "notification_date": "2026-03-09",
  "total_posts": 5000,
  "is_featured": true,
  "meta_title": "SBI Clerk Recruitment 2026 - 5000 Posts",
  "meta_description": "Apply for SBI Clerk 2026. 5000 vacancies.",
  "meta_keywords": "SBI Clerk, Banking Jobs",
  "important_links": {
    "apply_online": "https://sbi.co.in/apply",
    "official_website": "https://sbi.co.in"
  }
}
```

**Example:**
```bash
curl -X POST "https://jobone.in/api/posts" \
  -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "SBI Clerk Recruitment 2026 - 5000 Posts",
    "type": "job",
    "short_description": "State Bank of India is recruiting 5000 Clerk positions",
    "content": "<h2>SBI Clerk Recruitment 2026</h2><p>Details...</p>",
    "category_id": 1,
    "state_id": 37,
    "total_posts": 5000,
    "is_featured": true
  }'
```

**Response (201):**
```json
{
  "success": true,
  "message": "Post created successfully",
  "data": {
    "id": 123,
    "title": "SBI Clerk Recruitment 2026 - 5000 Posts",
    "type": "job",
    "category_id": 1,
    "state_id": 37,
    "total_posts": 5000,
    "is_featured": true,
    "created_at": "2026-03-12T10:00:00Z"
  }
}
```

---

### 4. Update Post
**PUT** `/api/posts/{id}`

Update an existing post.

**Request Body (all fields optional):**
```json
{
  "title": "Updated Title",
  "type": "job",
  "short_description": "Updated description",
  "content": "<h2>Updated Content</h2>",
  "category_id": 1,
  "state_id": 37,
  "last_date": "2026-04-15",
  "total_posts": 5000,
  "is_featured": true,
  "meta_title": "Updated Title",
  "meta_description": "Updated description",
  "meta_keywords": "updated, keywords"
}
```

**Example:**
```bash
curl -X PUT "https://jobone.in/api/posts/1" \
  -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Updated Title",
    "total_posts": 6000
  }'
```

**Response:**
```json
{
  "success": true,
  "message": "Post updated successfully",
  "data": {
    "id": 1,
    "title": "Updated Title",
    "total_posts": 6000,
    "updated_at": "2026-03-12T11:00:00Z"
  }
}
```

---

### 5. Delete Post
**DELETE** `/api/posts/{id}`

Delete a post.

**Example:**
```bash
curl -X DELETE "https://jobone.in/api/posts/1" \
  -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a"
```

**Response:**
```json
{
  "success": true,
  "message": "Post deleted successfully"
}
```

---

### 6. Get Categories
**GET** `/api/categories`

Get all job categories.

**Example:**
```bash
curl -X GET "https://jobone.in/api/categories" \
  -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a"
```

**Response:**
```json
{
  "success": true,
  "data": [
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
}
```

---

### 7. Get States
**GET** `/api/states`

Get all states and union territories.

**Example:**
```bash
curl -X GET "https://jobone.in/api/states" \
  -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a"
```

**Response:**
```json
{
  "success": true,
  "data": [
    {"id": 1, "name": "Andhra Pradesh"},
    {"id": 2, "name": "Arunachal Pradesh"},
    {"id": 3, "name": "Assam"},
    ...
    {"id": 37, "name": "All India"}
  ]
}
```

---

### 8. Get Current Token
**GET** `/api/token`

Get information about current API token.

**Example:**
```bash
curl -X GET "https://jobone.in/api/token" \
  -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a"
```

**Response:**
```json
{
  "success": true,
  "token": "jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a",
  "status": "active"
}
```

---

### 9. Generate New Token
**POST** `/api/token/generate`

Generate a new API token (requires current valid token).

**Example:**
```bash
curl -X POST "https://jobone.in/api/token/generate" \
  -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a"
```

**Response:**
```json
{
  "success": true,
  "message": "New API token generated",
  "token": "jobone_sk_live_newtoken1234567890abcdef",
  "note": "Please restart PHP-FPM for changes to take effect"
}
```

---

## Field Reference

| Field | Type | Required | Max Length | Description |
|-------|------|----------|-----------|-------------|
| title | string | Yes | 255 | Post title |
| type | string | Yes | - | job, admit_card, result, answer_key, syllabus, blog |
| short_description | string | Yes | - | Brief summary |
| content | string | Yes | - | Full HTML content |
| category_id | integer | Yes | - | Category ID (1-15) |
| state_id | integer | No | - | State ID (1-37) |
| last_date | date | No | - | YYYY-MM-DD format |
| notification_date | date | No | - | YYYY-MM-DD format |
| total_posts | integer | No | - | Number of vacancies |
| is_featured | boolean | No | - | true or false |
| meta_title | string | No | 60 | SEO title |
| meta_description | string | No | 160 | SEO description |
| meta_keywords | string | No | - | Comma-separated keywords |
| important_links | object | No | - | External links |

---

## Error Responses

### 401 Unauthorized
```json
{"error": "Unauthorized"}
```

### 404 Not Found
```json
{"error": "Post not found"}
```

### 422 Validation Error
```json
{
  "error": "Failed to create post",
  "message": "The given data was invalid"
}
```

### 500 Server Error
```json
{
  "error": "Failed to create post",
  "message": "Error details"
}
```

---

## Post Types

- `job` - Job notification
- `admit_card` - Admit card
- `result` - Exam result
- `answer_key` - Answer key
- `syllabus` - Exam syllabus
- `blog` - Blog post

---

## Categories (15 Total)

1. Banking
2. Railways
3. SSC
4. UPSC
5. Defence
6. Police
7. Teaching
8. PSU
9. State Govt
10. Central Govt
11. Court
12. Medical
13. Engineering
14. Agriculture
15. Post Office

---

## States (37 Total)

1-28: States (Andhra Pradesh, Arunachal Pradesh, Assam, Bihar, Chhattisgarh, Goa, Gujarat, Haryana, Himachal Pradesh, Jharkhand, Karnataka, Kerala, Madhya Pradesh, Maharashtra, Manipur, Meghalaya, Mizoram, Nagaland, Odisha, Punjab, Rajasthan, Sikkim, Tamil Nadu, Telangana, Tripura, Uttar Pradesh, Uttarakhand, West Bengal)

29-36: Union Territories (Andaman and Nicobar Islands, Chandigarh, Dadra and Nagar Haveli and Daman and Diu, Delhi, Jammu and Kashmir, Ladakh, Lakshadweep, Puducherry)

37: All India

---

## API Token

**Current Token:**
```
jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a
```

**Location:** `.env` file
```
API_TOKEN=jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a
```

---

## Examples

### Python - List Posts
```python
import requests

API_TOKEN = "jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a"
headers = {
    "Authorization": f"Bearer {API_TOKEN}",
    "Content-Type": "application/json"
}

response = requests.get(
    "https://jobone.in/api/posts?page=1&limit=10",
    headers=headers
)
print(response.json())
```

### Python - Create Post
```python
import requests

API_TOKEN = "jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a"
headers = {
    "Authorization": f"Bearer {API_TOKEN}",
    "Content-Type": "application/json"
}

data = {
    "title": "SBI Clerk Recruitment 2026 - 5000 Posts",
    "type": "job",
    "short_description": "State Bank of India is recruiting 5000 Clerk positions",
    "content": "<h2>SBI Clerk Recruitment 2026</h2><p>Details...</p>",
    "category_id": 1,
    "state_id": 37,
    "total_posts": 5000,
    "is_featured": True
}

response = requests.post(
    "https://jobone.in/api/posts",
    headers=headers,
    json=data
)
print(response.json())
```

### Python - Update Post
```python
import requests

API_TOKEN = "jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a"
headers = {
    "Authorization": f"Bearer {API_TOKEN}",
    "Content-Type": "application/json"
}

data = {
    "title": "Updated Title",
    "total_posts": 6000
}

response = requests.put(
    "https://jobone.in/api/posts/1",
    headers=headers,
    json=data
)
print(response.json())
```

### Python - Delete Post
```python
import requests

API_TOKEN = "jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a"
headers = {
    "Authorization": f"Bearer {API_TOKEN}",
    "Content-Type": "application/json"
}

response = requests.delete(
    "https://jobone.in/api/posts/1",
    headers=headers
)
print(response.json())
```

---

## Best Practices

1. Always use HTTPS
2. Keep API token secure
3. Validate data before sending
4. Implement error handling
5. Add rate limiting (1-2 seconds between requests)
6. Test with single request first
7. Monitor API responses
8. Rotate token every 90 days

---

**API Version:** 2.0  
**Last Updated:** March 12, 2026  
**Status:** ✅ Production Ready
