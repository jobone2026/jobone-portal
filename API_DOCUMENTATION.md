# JobOne.in Admin API Documentation

Base URL: `http://localhost:8000/api` (or your production domain)

## Authentication

All API requests (except login) require authentication using Bearer token.

Add this header to all authenticated requests:
```
Authorization: Bearer YOUR_TOKEN_HERE
```

---

## 1. Login

Get authentication token for admin user.

**Endpoint:** `POST /api/admin/login`

**Headers:**
```
Content-Type: application/json
Accept: application/json
```

**Request Body:**
```json
{
    "email": "admin@example.com",
    "password": "password123"
}
```

**Success Response (200):**
```json
{
    "success": true,
    "message": "Login successful",
    "data": {
        "admin": {
            "id": 1,
            "name": "Admin User",
            "email": "admin@example.com"
        },
        "token": "1|abcdefghijklmnopqrstuvwxyz1234567890"
    }
}
```

**Error Response (401):**
```json
{
    "success": false,
    "message": "Invalid credentials"
}
```

---

## 2. Get All Posts

Retrieve list of posts with pagination and filters.

**Endpoint:** `GET /api/posts`

**Headers:**
```
Authorization: Bearer YOUR_TOKEN
Accept: application/json
```

**Query Parameters (Optional):**
- `type` - Filter by post type (job, admit_card, result, answer_key, syllabus, blog)
- `category_id` - Filter by category ID
- `state_id` - Filter by state ID
- `is_published` - Filter by published status (0 or 1)
- `per_page` - Items per page (default: 20)
- `page` - Page number

**Example:** `GET /api/posts?type=job&is_published=1&per_page=10`

**Success Response (200):**
```json
{
    "success": true,
    "data": {
        "current_page": 1,
        "data": [
            {
                "id": 1,
                "title": "SSC CGL 2026 Notification",
                "slug": "ssc-cgl-2026-notification-abc123",
                "type": "job",
                "category_id": 1,
                "state_id": null,
                "short_description": "SSC CGL 2026 recruitment notification",
                "content": "Full content here...",
                "notification_date": "2026-03-01",
                "last_date": "2026-04-01",
                "total_posts": 5000,
                "important_links": null,
                "is_featured": true,
                "is_published": true,
                "view_count": 1250,
                "created_at": "2026-03-01T10:00:00.000000Z",
                "updated_at": "2026-03-01T10:00:00.000000Z",
                "category": {
                    "id": 1,
                    "name": "SSC",
                    "slug": "ssc"
                },
                "state": null,
                "admin": {
                    "id": 1,
                    "name": "Admin User"
                }
            }
        ],
        "per_page": 20,
        "total": 150
    }
}
```

---

## 3. Get Single Post

Retrieve details of a specific post.

**Endpoint:** `GET /api/posts/{id}`

**Headers:**
```
Authorization: Bearer YOUR_TOKEN
Accept: application/json
```

**Success Response (200):**
```json
{
    "success": true,
    "data": {
        "id": 1,
        "title": "SSC CGL 2026 Notification",
        "slug": "ssc-cgl-2026-notification-abc123",
        "type": "job",
        "category_id": 1,
        "state_id": null,
        "short_description": "SSC CGL 2026 recruitment notification",
        "content": "Full content here...",
        "notification_date": "2026-03-01",
        "last_date": "2026-04-01",
        "total_posts": 5000,
        "important_links": null,
        "is_featured": true,
        "is_published": true,
        "view_count": 1250,
        "created_at": "2026-03-01T10:00:00.000000Z",
        "updated_at": "2026-03-01T10:00:00.000000Z",
        "category": {
            "id": 1,
            "name": "SSC",
            "slug": "ssc"
        },
        "state": null,
        "admin": {
            "id": 1,
            "name": "Admin User"
        }
    }
}
```

**Error Response (404):**
```json
{
    "success": false,
    "message": "Post not found"
}
```

---

## 4. Create Post

Create a new post.

**Endpoint:** `POST /api/posts`

**Headers:**
```
Authorization: Bearer YOUR_TOKEN
Content-Type: application/json
Accept: application/json
```

**Request Body:**
```json
{
    "title": "UPSC CSE 2026 Notification Released",
    "type": "job",
    "category_id": 2,
    "state_id": null,
    "short_description": "UPSC Civil Services Examination 2026 notification has been released",
    "content": "<h2>UPSC CSE 2026</h2><p>Full details about the exam...</p>",
    "notification_date": "2026-03-10",
    "last_date": "2026-04-30",
    "total_posts": 1000,
    "important_links": {
        "official_website": "https://upsc.gov.in",
        "apply_online": "https://upsconline.nic.in",
        "notification_pdf": "https://upsc.gov.in/notification.pdf"
    },
    "is_featured": true,
    "is_published": true
}
```

**Field Descriptions:**
- `title` (required) - Post title
- `type` (required) - One of: job, admit_card, result, answer_key, syllabus, blog
- `category_id` (required) - Category ID (get from /api/categories)
- `state_id` (optional) - State ID (get from /api/states)
- `short_description` (required) - Brief description
- `content` (required) - Full HTML content
- `notification_date` (optional) - Date in YYYY-MM-DD format
- `last_date` (optional) - Application deadline in YYYY-MM-DD format
- `total_posts` (optional) - Number of vacancies
- `important_links` (optional) - JSON object with key-value pairs (e.g., {"official_website": "url", "apply_online": "url"}). Send as a JSON object, NOT as a string.
- `is_featured` (optional) - Boolean, default: false
- `is_published` (optional) - Boolean, default: true

**Success Response (201):**
```json
{
    "success": true,
    "message": "Post created successfully",
    "data": {
        "id": 250,
        "title": "UPSC CSE 2026 Notification Released",
        "slug": "upsc-cse-2026-notification-released-xyz789",
        "type": "job",
        "category_id": 2,
        "state_id": null,
        "short_description": "UPSC Civil Services Examination 2026 notification has been released",
        "content": "<h2>UPSC CSE 2026</h2><p>Full details about the exam...</p>",
        "notification_date": "2026-03-10",
        "last_date": "2026-04-30",
        "total_posts": 1000,
        "important_links": "{\"official_website\": \"https://upsc.gov.in\", \"apply_link\": \"https://upsconline.nic.in\"}",
        "meta_title": "UPSC CSE 2026 Notification Released",
        "meta_description": "UPSC Civil Services Examination 2026 notification has been released",
        "is_featured": true,
        "is_published": true,
        "view_count": 0,
        "admin_id": 1,
        "created_at": "2026-03-09T10:00:00.000000Z",
        "updated_at": "2026-03-09T10:00:00.000000Z",
        "category": {
            "id": 2,
            "name": "UPSC",
            "slug": "upsc"
        },
        "state": null,
        "admin": {
            "id": 1,
            "name": "Admin User"
        }
    }
}
```

**Error Response (422):**
```json
{
    "success": false,
    "errors": {
        "title": ["The title field is required."],
        "type": ["The type field is required."]
    }
}
```

---

## 5. Update Post

Update an existing post.

**Endpoint:** `PUT /api/posts/{id}`

**Headers:**
```
Authorization: Bearer YOUR_TOKEN
Content-Type: application/json
Accept: application/json
```

**Request Body (all fields optional):**
```json
{
    "title": "UPSC CSE 2026 - Updated Notification",
    "is_published": true,
    "is_featured": false,
    "last_date": "2026-05-15"
}
```

**Success Response (200):**
```json
{
    "success": true,
    "message": "Post updated successfully",
    "data": {
        "id": 250,
        "title": "UPSC CSE 2026 - Updated Notification",
        "slug": "upsc-cse-2026-notification-released-xyz789",
        "type": "job",
        "category_id": 2,
        "state_id": null,
        "short_description": "UPSC Civil Services Examination 2026 notification has been released",
        "content": "<h2>UPSC CSE 2026</h2><p>Full details about the exam...</p>",
        "notification_date": "2026-03-10",
        "last_date": "2026-05-15",
        "total_posts": 1000,
        "important_links": "{\"official_website\": \"https://upsc.gov.in\", \"apply_link\": \"https://upsconline.nic.in\"}",
        "meta_title": "UPSC CSE 2026 - Updated Notification",
        "meta_description": "UPSC Civil Services Examination 2026 notification has been released",
        "is_featured": false,
        "is_published": true,
        "view_count": 0,
        "admin_id": 1,
        "created_at": "2026-03-09T10:00:00.000000Z",
        "updated_at": "2026-03-09T10:30:00.000000Z",
        "category": {
            "id": 2,
            "name": "UPSC",
            "slug": "upsc"
        },
        "state": null,
        "admin": {
            "id": 1,
            "name": "Admin User"
        }
    }
}
```

**Error Response (404):**
```json
{
    "success": false,
    "message": "Post not found"
}
```

---

## 6. Delete Post

Delete a post permanently.

**Endpoint:** `DELETE /api/posts/{id}`

**Headers:**
```
Authorization: Bearer YOUR_TOKEN
Accept: application/json
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
    "success": false,
    "message": "Post not found"
}
```

---

## 7. Get All Categories

Retrieve list of all categories.

**Endpoint:** `GET /api/categories`

**Headers:**
```
Authorization: Bearer YOUR_TOKEN
Accept: application/json
```

**Success Response (200):**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "SSC",
            "slug": "ssc",
            "description": "Staff Selection Commission",
            "created_at": "2026-03-01T00:00:00.000000Z",
            "updated_at": "2026-03-01T00:00:00.000000Z"
        },
        {
            "id": 2,
            "name": "UPSC",
            "slug": "upsc",
            "description": "Union Public Service Commission",
            "created_at": "2026-03-01T00:00:00.000000Z",
            "updated_at": "2026-03-01T00:00:00.000000Z"
        }
    ]
}
```

---

## 8. Get All States

Retrieve list of all states.

**Endpoint:** `GET /api/states`

**Headers:**
```
Authorization: Bearer YOUR_TOKEN
Accept: application/json
```

**Success Response (200):**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "Andhra Pradesh",
            "slug": "andhra-pradesh",
            "created_at": "2026-03-01T00:00:00.000000Z",
            "updated_at": "2026-03-01T00:00:00.000000Z"
        },
        {
            "id": 2,
            "name": "Bihar",
            "slug": "bihar",
            "created_at": "2026-03-01T00:00:00.000000Z",
            "updated_at": "2026-03-01T00:00:00.000000Z"
        }
    ]
}
```

---

## 9. Logout

Revoke current authentication token.

**Endpoint:** `POST /api/admin/logout`

**Headers:**
```
Authorization: Bearer YOUR_TOKEN
Accept: application/json
```

**Success Response (200):**
```json
{
    "success": true,
    "message": "Logged out successfully"
}
```

---

## Postman Collection Setup

1. Create a new collection in Postman
2. Add a variable `base_url` = `http://localhost:8000/api`
3. Add a variable `token` (will be set after login)
4. For authenticated requests, add header: `Authorization: Bearer {{token}}`

### Quick Test Flow:

1. **Login** → Copy the token from response
2. **Set token** → In Postman collection variables
3. **Get Categories** → Get category IDs
4. **Get States** → Get state IDs (optional)
5. **Create Post** → Use category_id from step 3
6. **Get Posts** → Verify your post was created
7. **Update Post** → Modify the post
8. **Delete Post** → Remove the post

---

## Error Codes

- `200` - Success
- `201` - Created successfully
- `401` - Unauthorized (invalid or missing token)
- `404` - Resource not found
- `422` - Validation error
- `500` - Server error

---

## Rate Limiting

API requests are limited to 60 requests per minute per IP address.

If you exceed this limit, you'll receive a `429 Too Many Requests` response.

---

## Notes

- All dates should be in `YYYY-MM-DD` format
- All timestamps are in UTC
- The `slug` field is auto-generated from the title
- `meta_title` and `meta_description` are auto-generated but can be customized
- The API automatically handles cache invalidation when posts are created/updated/deleted
