# JobOne.in API - Complete Documentation

## Base URL
```
https://jobone.in/api
```

## Authentication

### Bearer Token Authentication
All endpoints (except `/categories` and `/states`) require Bearer token authentication.

**Current API Token:**
```
jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a
```

**Headers:**
```http
Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a
Content-Type: application/json
Accept: application/json
```

---

## Endpoints Overview

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| GET | `/posts` | ✓ | List all posts with filters |
| GET | `/posts/search` | ✓ | Search posts |
| GET | `/posts/featured` | ✓ | Get featured posts |
| GET | `/posts/scholarships` | ✓ | Get scholarships only |
| GET | `/posts/{id}` | ✓ | Get single post |
| POST | `/posts` | ✓ | Create new post |
| PUT | `/posts/{id}` | ✓ | Update post |
| DELETE | `/posts/{id}` | ✓ | Delete post |
| GET | `/categories` | ✗ | Get all categories |
| GET | `/states` | ✗ | Get all states |
| GET | `/home` | ✓ | Get home page sections |
| GET | `/stats` | ✓ | Get post counts by type |
| GET | `/token` | ✓ | Get token info |
| POST | `/token/generate` | ✓ | Generate new token |
| POST | `/admin/login` | ✗ | Admin login (Sanctum) |
| POST | `/admin/logout` | ✓ | Admin logout (Sanctum) |

---

## 1. List Posts

**Endpoint:** `GET /api/posts`

**Query Parameters:**
- `page` (integer, optional) - Page number (default: 1)
- `limit` (integer, optional) - Items per page (default: 15)
- `type` (string, optional) - Filter by type: `job`, `admit_card`, `result`, `answer_key`, `syllabus`, `blog`, `scholarship`
- `category_id` (integer, optional) - Filter by category ID
- `state_id` (integer, optional) - Filter by state ID
- `is_upcoming` (boolean, optional) - Filter upcoming jobs
- `education` (string, optional) - Filter by education tag

**Example Request:**
```bash
curl -X GET "https://jobone.in/api/posts?page=1&limit=10&type=job&state_id=2" \
  -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a" \
  -H "Accept: application/json"
```

**Example Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "title": "UPSC Civil Services 2026",
      "slug": "upsc-civil-services-2026",
      "type": "job",
      "short_description": "Apply for UPSC Civil Services Examination 2026",
      "category": {
        "id": 1,
        "name": "UPSC",
        "slug": "upsc"
      },
      "state": {
        "id": 1,
        "name": "All India",
        "slug": "all-india"
      },
      "organization": "Union Public Service Commission",
      "notification_date": "2026-04-01",
      "start_date": "2026-04-15",
      "end_date": "2026-05-15",
      "last_date": "2026-05-15",
      "total_posts": 1000,
      "salary": "₹56,100 - ₹2,50,000",
      "online_form": "https://upsc.gov.in/apply",
      "final_result": null,
      "important_links": [
        {
          "title": "Apply Online",
          "url": "https://upsc.gov.in/apply"
        }
      ],
      "tags": ["cutoff", "merit_list"],
      "education": ["graduate", "post_graduate"],
      "is_featured": true,
      "is_upcoming": false,
      "is_published": true,
      "created_at": "2026-04-01T10:00:00.000000Z",
      "updated_at": "2026-04-01T10:00:00.000000Z"
    }
  ],
  "meta": {
    "total": 150,
    "per_page": 10,
    "current_page": 1,
    "last_page": 15
  }
}
```

---

## 2. Search Posts

**Endpoint:** `GET /api/posts/search`

**Query Parameters:**
- `q` (string, required) - Search query
- `page` (integer, optional) - Page number (default: 1)
- `limit` (integer, optional) - Items per page (default: 15)

**Example Request:**
```bash
curl -X GET "https://jobone.in/api/posts/search?q=railway&limit=5" \
  -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a" \
  -H "Accept: application/json"
```

---

## 3. Get Featured Posts

**Endpoint:** `GET /api/posts/featured`

**Query Parameters:**
- `limit` (integer, optional) - Number of posts (default: 10)

**Example Request:**
```bash
curl -X GET "https://jobone.in/api/posts/featured?limit=5" \
  -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a" \
  -H "Accept: application/json"
```

---

## 4. Get Scholarships

**Endpoint:** `GET /api/posts/scholarships`

**Query Parameters:**
- `page` (integer, optional) - Page number (default: 1)
- `limit` (integer, optional) - Items per page (default: 15)
- `state_id` (integer, optional) - Filter by state
- `category_id` (integer, optional) - Filter by category

**Example Request:**
```bash
curl -X GET "https://jobone.in/api/posts/scholarships?limit=10" \
  -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a" \
  -H "Accept: application/json"
```

---

## 5. Get Single Post

**Endpoint:** `GET /api/posts/{id}`

**Example Request:**
```bash
curl -X GET "https://jobone.in/api/posts/123" \
  -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a" \
  -H "Accept: application/json"
```

---

## 6. Create Post

**Endpoint:** `POST /api/posts`

**Required Fields:**
- `title` (string, max 255) - Post title
- `type` (string) - One of: `job`, `admit_card`, `result`, `answer_key`, `syllabus`, `blog`, `scholarship`
- `short_description` (string) - Brief description
- `content` (string) - Full HTML content
- `category_id` (integer) - Category ID

**Optional Fields:**
- `state_id` (integer) - State ID (null for All India)
- `organization` (string, max 255) - Organization name
- `notification_date` (date, YYYY-MM-DD) - Notification release date
- `start_date` (date, YYYY-MM-DD) - Application start date
- `end_date` (date, YYYY-MM-DD) - Application end date
- `last_date` (date, YYYY-MM-DD) - Application deadline
- `total_posts` (integer) - Number of vacancies
- `salary` (string, max 255) - Salary range
- `online_form` (url, max 500) - Online application URL
- `final_result` (url, max 500) - Final result URL
- `important_links` (array) - Array of link objects `[{"title": "...", "url": "..."}]`
- `tags` (array) - Array of tags `["cutoff", "merit_list"]`
- `education` (array) - Array of education qualifications `["graduate", "12th_pass"]`
- `is_featured` (boolean) - Mark as featured (default: false)
- `is_upcoming` (boolean) - Mark as upcoming (default: false)
- `is_published` (boolean) - Publish immediately (default: false)
- `meta_title` (string, max 60) - SEO title
- `meta_description` (string, max 160) - SEO description
- `meta_keywords` (string, max 1000) - SEO keywords

**Example Request:**
```bash
curl -X POST "https://jobone.in/api/posts" \
  -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "title": "UPSC NDA 2026 Notification",
    "type": "job",
    "short_description": "National Defence Academy Exam 2026",
    "content": "<h2>About NDA</h2><p>Full content here...</p>",
    "category_id": 1,
    "state_id": null,
    "organization": "UPSC",
    "notification_date": "2026-04-20",
    "start_date": "2026-04-25",
    "end_date": "2026-05-25",
    "last_date": "2026-05-25",
    "total_posts": 400,
    "salary": "₹15,600 - ₹39,100",
    "online_form": "https://upsc.gov.in/apply",
    "important_links": [
      {
        "title": "Apply Online",
        "url": "https://upsc.gov.in/apply"
      },
      {
        "title": "Download Notification",
        "url": "https://upsc.gov.in/nda-notification.pdf"
      }
    ],
    "tags": ["defence", "nda"],
    "education": ["12th_pass"],
    "is_featured": true,
    "is_upcoming": false,
    "is_published": true,
    "meta_title": "UPSC NDA 2026 - Apply Online for 400 Posts",
    "meta_description": "UPSC NDA 2026 notification released. Apply online for National Defence Academy exam.",
    "meta_keywords": "upsc, nda, 2026, defence, army, navy, air force"
  }'
```

**Example Response:**
```json
{
  "success": true,
  "message": "Post created successfully",
  "data": {
    "id": 456,
    "title": "UPSC NDA 2026 Notification",
    "slug": "upsc-nda-2026-notification",
    "type": "job",
    "created_at": "2026-04-20T10:30:00.000000Z"
  }
}
```

---

## 7. Update Post

**Endpoint:** `PUT /api/posts/{id}`

**Fields:** Same as Create Post (all optional)

**Example Request:**
```bash
curl -X PUT "https://jobone.in/api/posts/456" \
  -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "last_date": "2026-06-20",
    "total_posts": 450,
    "is_featured": false
  }'
```

---

## 8. Delete Post

**Endpoint:** `DELETE /api/posts/{id}`

**Example Request:**
```bash
curl -X DELETE "https://jobone.in/api/posts/456" \
  -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a" \
  -H "Accept: application/json"
```

---

## 9. Get Categories

**Endpoint:** `GET /api/categories` (Public - No Auth Required)

**Example Request:**
```bash
curl -X GET "https://jobone.in/api/categories" \
  -H "Accept: application/json"
```

**Example Response:**
```json
{
  "success": true,
  "total": 15,
  "data": [
    {
      "id": 1,
      "name": "UPSC",
      "slug": "upsc",
      "posts_count": 245
    },
    {
      "id": 2,
      "name": "SSC",
      "slug": "ssc",
      "posts_count": 389
    }
  ]
}
```

---

## 10. Get States

**Endpoint:** `GET /api/states` (Public - No Auth Required)

**Example Request:**
```bash
curl -X GET "https://jobone.in/api/states" \
  -H "Accept: application/json"
```

**Example Response:**
```json
{
  "success": true,
  "total": 30,
  "data": [
    {
      "id": 1,
      "name": "All India",
      "slug": "all-india",
      "posts_count": 1250
    },
    {
      "id": 2,
      "name": "Uttar Pradesh",
      "slug": "uttar-pradesh",
      "posts_count": 456
    }
  ]
}
```

---

## 11. Get Home Sections

**Endpoint:** `GET /api/home`

Returns latest posts for all types (jobs, admit cards, results, etc.)

**Query Parameters:**
- `limit` (integer, optional) - Posts per section (default: 10)
- `state_id` (integer, optional) - Filter by state

**Example Request:**
```bash
curl -X GET "https://jobone.in/api/home?limit=5" \
  -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a" \
  -H "Accept: application/json"
```

**Example Response:**
```json
{
  "success": true,
  "sections": {
    "jobs": [...],
    "admit_cards": [...],
    "results": [...],
    "answer_keys": [...],
    "syllabus": [...],
    "blogs": [...],
    "scholarships": [...]
  }
}
```

---

## 12. Get Stats

**Endpoint:** `GET /api/stats`

Returns post counts by type.

**Example Request:**
```bash
curl -X GET "https://jobone.in/api/stats" \
  -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a" \
  -H "Accept: application/json"
```

**Example Response:**
```json
{
  "success": true,
  "data": {
    "job": 1250,
    "admit_card": 456,
    "result": 789,
    "answer_key": 234,
    "syllabus": 123,
    "blog": 89,
    "scholarship": 67,
    "total": 3008
  }
}
```

---

## 13. Get Token Info

**Endpoint:** `GET /api/token`

**Example Request:**
```bash
curl -X GET "https://jobone.in/api/token" \
  -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a" \
  -H "Accept: application/json"
```

**Example Response:**
```json
{
  "success": true,
  "token": "jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a",
  "status": "active"
}
```

---

## 14. Generate New Token

**Endpoint:** `POST /api/token/generate`

**Example Request:**
```bash
curl -X POST "https://jobone.in/api/token/generate" \
  -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a" \
  -H "Accept: application/json"
```

**Example Response:**
```json
{
  "success": true,
  "message": "New API token generated",
  "token": "jobone_sk_live_a1b2c3d4e5f6g7h8i9j0k1l2m3n4o5p6",
  "note": "Please restart PHP-FPM for changes to take effect"
}
```

---

## 15. Admin Login (Sanctum)

**Endpoint:** `POST /api/admin/login`

**Request Body:**
```json
{
  "email": "admin@jobone.in",
  "password": "your-password"
}
```

**Example Request:**
```bash
curl -X POST "https://jobone.in/api/admin/login" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "email": "admin@jobone.in",
    "password": "your-password"
  }'
```

**Example Response:**
```json
{
  "success": true,
  "message": "Login successful",
  "data": {
    "admin": {
      "id": 1,
      "name": "Admin User",
      "email": "admin@jobone.in"
    },
    "token": "1|abcdefghijklmnopqrstuvwxyz123456"
  }
}
```

---

## 16. Admin Logout (Sanctum)

**Endpoint:** `POST /api/admin/logout`

**Example Request:**
```bash
curl -X POST "https://jobone.in/api/admin/logout" \
  -H "Authorization: Bearer 1|abcdefghijklmnopqrstuvwxyz123456" \
  -H "Accept: application/json"
```

---

## Data Types

### Post Types
- `job` - Job notifications
- `admit_card` - Admit card downloads
- `result` - Exam results
- `answer_key` - Answer keys
- `syllabus` - Exam syllabus
- `blog` - Blog posts
- `scholarship` - Scholarship notifications

### Tags
- `cutoff` - Cutoff marks
- `merit_list` - Merit list
- `selection_list` - Selection list
- `final_result` - Final result
- `provisional_result` - Provisional result
- `revised_result` - Revised result
- `scorecard` - Scorecard
- `marks` - Marks

### Education Qualifications
- `10th_pass`, `12th_pass`, `graduate`, `post_graduate`, `diploma`, `iti`
- `btech`, `mtech`, `bsc`, `msc`, `bcom`, `mcom`, `ba`, `ma`
- `bba`, `mba`, `ca`, `cs`, `cma`, `llb`, `llm`
- `mbbs`, `bds`, `bpharm`, `mpharm`, `nursing`
- `bed`, `med`, `phd`, `any_qualification`

---

## Error Responses

### 401 Unauthorized
```json
{
  "error": "Unauthorized"
}
```

### 404 Not Found
```json
{
  "error": "Post not found"
}
```

### 422 Validation Error
```json
{
  "success": false,
  "message": "The given data was invalid.",
  "errors": {
    "title": ["The title field is required."],
    "category_id": ["The selected category id is invalid."]
  }
}
```

### 500 Server Error
```json
{
  "error": "Failed to create post",
  "message": "Database connection error"
}
```

---

## Rate Limiting

- No rate limiting currently implemented
- Fair use policy applies
- Excessive requests may be throttled

---

## Best Practices

1. **Always use HTTPS** - Never send API tokens over HTTP
2. **Store tokens securely** - Don't commit tokens to version control
3. **Handle errors gracefully** - Check response status codes
4. **Use pagination** - Don't fetch all posts at once
5. **Cache responses** - Cache category and state lists
6. **Validate data** - Validate before sending to API
7. **Use filters** - Use query parameters to reduce response size

---

## Support

For API support, contact:
- Email: support@jobone.in
- Website: https://jobone.in

---

**Last Updated:** April 22, 2026  
**API Version:** 1.0  
**Laravel Version:** 12.53.0
