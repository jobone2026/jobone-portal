# API Documentation - Government Job Portal

**Base URL:** `https://jobone.in/api`

**API Token:** `jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a`

**Headers:**
```
Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a
Content-Type: application/json
```

---

## Endpoints

### 1. GET /api/posts
List all posts with pagination and filters.

**Query Parameters:**
- `page` (optional): Page number (default: 1)
- `limit` (optional): Posts per page (default: 15, max: 100)
- `type` (optional): Filter by type: `job`, `admit_card`, `result`, `answer_key`, `syllabus`, `blog`
- `category_id` (optional): Filter by category ID
- `state_id` (optional): Filter by state ID

**Example:**
```bash
curl "https://jobone.in/api/posts?page=1&limit=20&type=job" \
  -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a"
```

---

### 2. GET /api/posts/{id}
Get single post by ID.

**Example:**
```bash
curl "https://jobone.in/api/posts/123" \
  -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a"
```

---

### 3. POST /api/posts
Create new post.

**Required Fields:**
- `title` (string, max 255)
- `type` (string): `job`, `admit_card`, `result`, `answer_key`, `syllabus`, `blog`
- `short_description` (string)
- `content` (string, HTML allowed)
- `category_id` (integer)

**Optional Fields:**
- `state_id` (integer)
- `last_date` (date: YYYY-MM-DD)
- `notification_date` (date: YYYY-MM-DD)
- `total_posts` (integer)
- `important_links` (array of {title, url})
- `is_featured` (boolean)
- `meta_title`, `meta_description`, `meta_keywords` (string)

**Example:**
```bash
curl -X POST "https://jobone.in/api/posts" \
  -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "UPSC Civil Services 2024",
    "type": "job",
    "short_description": "UPSC CSE 2024 Notification",
    "content": "<p>Full description...</p>",
    "category_id": 3,
    "last_date": "2024-12-31",
    "total_posts": 1000
  }'
```

---

### 4. PUT /api/posts/{id}
Update existing post. All fields optional.

**Example:**
```bash
curl -X PUT "https://jobone.in/api/posts/456" \
  -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a" \
  -H "Content-Type: application/json" \
  -d '{"last_date": "2025-01-31"}'
```

---

### 5. DELETE /api/posts/{id}
Delete post permanently.

**Example:**
```bash
curl -X DELETE "https://jobone.in/api/posts/456" \
  -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a"
```

---

### 6. GET /api/categories
Get all categories. No authentication required.

**Example:**
```bash
curl "https://jobone.in/api/categories"
```

**Response:**
```json
{
  "success": true,
  "data": [
    {"id": 1, "name": "Banking", "slug": "banking"},
    {"id": 2, "name": "Railway", "slug": "railway"},
    {"id": 3, "name": "UPSC", "slug": "upsc"}
  ]
}
```

---

### 7. GET /api/states
Get all states. No authentication required.

**Example:**
```bash
curl "https://jobone.in/api/states"
```

**Response:**
```json
{
  "success": true,
  "data": [
    {"id": 1, "name": "Andhra Pradesh", "slug": "andhra-pradesh"},
    {"id": 2, "name": "Karnataka", "slug": "karnataka"},
    {"id": 3, "name": "Maharashtra", "slug": "maharashtra"}
  ]
}
```

**Note:** Use these IDs when creating posts. For all-India jobs, set `state_id` to `null`.

---

### 8. GET /api/token
Check token info.

**Example:**
```bash
curl "https://jobone.in/api/token" \
  -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a"
```

---

### 9. POST /api/token/generate
Generate new API token (invalidates old one).

**Example:**
```bash
curl -X POST "https://jobone.in/api/token/generate" \
  -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a"
```

---

## Response Codes

| Code | Description |
|------|-------------|
| 200 | Success |
| 201 | Created |
| 401 | Unauthorized |
| 404 | Not Found |
| 422 | Validation Error |
| 500 | Server Error |

---

**Last Updated:** March 19, 2026
