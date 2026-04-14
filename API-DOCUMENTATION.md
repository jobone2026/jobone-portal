# JobOne.in API Documentation

## Base URL
```
https://jobone.in/api
```

## Authentication

All API endpoints (except `/categories` and `/states`) require Bearer token authentication.

### Headers
```
Authorization: Bearer YOUR_API_TOKEN
Content-Type: application/json
Accept: application/json
```

### Current API Token
```
jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a
```

---

## Endpoints

### 1. Get All Posts
Retrieve a paginated list of posts with optional filters.

**Endpoint:** `GET /api/posts`

**Query Parameters:**
- `page` (integer, optional) - Page number (default: 1)
- `limit` (integer, optional) - Items per page (default: 15)
- `type` (string, optional) - Filter by post type: `job`, `admit_card`, `result`, `answer_key`, `syllabus`, `blog`
- `category_id` (integer, optional) - Filter by category ID
- `state_id` (integer, optional) - Filter by state ID

**Example Request:**
```bash
curl -X GET "https://jobone.in/api/posts?page=1&limit=10&type=job" \
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
        "name": "UPSC"
      },
      "state": {
        "id": 1,
        "name": "All India"
      },
      "last_date": "2026-05-15",
      "notification_date": "2026-04-01",
      "total_posts": 1000,
      "is_featured": true,
      "created_at": "2026-04-01T10:00:00.000000Z"
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

### 2. Search Posts
Search posts by title, description, or content.

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

**Example Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 45,
      "title": "Railway Recruitment 2026",
      "type": "job",
      "short_description": "Apply for Railway jobs"
    }
  ],
  "meta": {
    "total": 25,
    "per_page": 5,
    "current_page": 1,
    "last_page": 5
  }
}
```

---

### 3. Get Featured Posts
Retrieve featured posts from the last 30 days.

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

### 4. Get Single Post
Retrieve a specific post by ID.

**Endpoint:** `GET /api/posts/{id}`

**Example Request:**
```bash
curl -X GET "https://jobone.in/api/posts/123" \
  -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a" \
  -H "Accept: application/json"
```

**Example Response:**
```json
{
  "success": true,
  "data": {
    "id": 123,
    "title": "SSC CGL 2026 Notification",
    "slug": "ssc-cgl-2026-notification",
    "type": "job",
    "short_description": "Staff Selection Commission Combined Graduate Level Exam 2026",
    "content": "<p>Full HTML content here...</p>",
    "category": {
      "id": 2,
      "name": "SSC"
    },
    "state": {
      "id": 1,
      "name": "All India"
    },
    "organization": "Staff Selection Commission",
    "last_date": "2026-06-30",
    "notification_date": "2026-04-15",
    "total_posts": 5000,
    "important_links": [
      {
        "title": "Apply Online",
        "url": "https://ssc.nic.in/apply"
      },
      {
        "title": "Download Notification",
        "url": "https://ssc.nic.in/notification.pdf"
      }
    ],
    "tags": ["cutoff", "merit_list"],
    "education": ["graduate", "post_graduate"],
    "is_featured": true,
    "meta_title": "SSC CGL 2026 Notification - Apply Online",
    "meta_description": "SSC CGL 2026 notification released. Apply online for 5000 posts.",
    "meta_keywords": "ssc, cgl, 2026, notification",
    "created_at": "2026-04-15T09:00:00.000000Z",
    "updated_at": "2026-04-15T09:00:00.000000Z"
  }
}
```

---

### 5. Create Post
Create a new job post.

**Endpoint:** `POST /api/posts`

**Required Fields:**
- `title` (string, max 255) - Post title
- `type` (string) - One of: `job`, `admit_card`, `result`, `answer_key`, `syllabus`, `blog`
- `short_description` (string) - Brief description
- `content` (string) - Full HTML content
- `category_id` (integer) - Category ID

**Optional Fields:**
- `state_id` (integer) - State ID (null for All India)
- `organization` (string, max 255) - Organization name
- `last_date` (date, YYYY-MM-DD) - Application deadline
- `notification_date` (date, YYYY-MM-DD) - Notification release date
- `total_posts` (integer) - Number of vacancies
- `important_links` (array) - Array of link objects
- `tags` (array) - Array of tags
- `education` (array) - Array of education qualifications
- `is_featured` (boolean) - Mark as featured (default: false)
- `meta_title` (string, max 60) - SEO title
- `meta_description` (string, max 160) - SEO description
- `meta_keywords` (string) - SEO keywords

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
    "last_date": "2026-06-15",
    "notification_date": "2026-04-20",
    "total_posts": 400,
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

### 6. Update Post
Update an existing post.

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

**Example Response:**
```json
{
  "success": true,
  "message": "Post updated successfully",
  "data": {
    "id": 456,
    "title": "UPSC NDA 2026 Notification",
    "last_date": "2026-06-20",
    "total_posts": 450,
    "is_featured": false
  }
}
```

---

### 7. Delete Post
Delete a post permanently.

**Endpoint:** `DELETE /api/posts/{id}`

**Example Request:**
```bash
curl -X DELETE "https://jobone.in/api/posts/456" \
  -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a" \
  -H "Accept: application/json"
```

**Example Response:**
```json
{
  "success": true,
  "message": "Post deleted successfully"
}
```

---

### 8. Get Categories
Retrieve all categories (public endpoint, no auth required).

**Endpoint:** `GET /api/categories`

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
    },
    {
      "id": 3,
      "name": "Banking",
      "slug": "banking",
      "posts_count": 156
    }
  ]
}
```

---

### 9. Get States
Retrieve all states (public endpoint, no auth required).

**Endpoint:** `GET /api/states`

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
    },
    {
      "id": 3,
      "name": "Maharashtra",
      "slug": "maharashtra",
      "posts_count": 234
    }
  ]
}
```

---

### 10. Get Token Info
Get information about the current API token.

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

### 11. Generate New Token
Generate a new API token (requires current valid token).

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

## Data Types

### Post Types
- `job` - Job notifications
- `admit_card` - Admit card downloads
- `result` - Exam results
- `answer_key` - Answer keys
- `syllabus` - Exam syllabus
- `blog` - Blog posts

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
- `10th_pass` - 10th Pass
- `12th_pass` - 12th Pass
- `graduate` - Graduate
- `post_graduate` - Post Graduate
- `diploma` - Diploma
- `iti` - ITI
- `btech` - B.Tech/B.E
- `mtech` - M.Tech/M.E
- `bsc` - B.Sc
- `msc` - M.Sc
- `bcom` - B.Com
- `mcom` - M.Com
- `ba` - B.A
- `ma` - M.A
- `bba` - BBA
- `mba` - MBA
- `ca` - CA
- `cs` - CS
- `cma` - CMA
- `llb` - LLB
- `llm` - LLM
- `mbbs` - MBBS
- `bds` - BDS
- `bpharm` - B.Pharm
- `mpharm` - M.Pharm
- `nursing` - Nursing
- `bed` - B.Ed
- `med` - M.Ed
- `phd` - PhD
- `any_qualification` - Any Qualification

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

## Changelog

### Version 1.0 (April 2026)
- Initial API release
- Post CRUD operations
- Search and filtering
- Category and state endpoints
- Token management
