# JobOne.in API - Quick Reference

## Base URL
```
https://jobone.in/api
```

## Authentication
```
Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a
```

## Quick Commands

### Get All Posts
```bash
curl -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a" \
     https://jobone.in/api/posts?limit=10
```

### Search Posts
```bash
curl -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a" \
     "https://jobone.in/api/posts/search?q=railway"
```

### Get Featured Posts
```bash
curl -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a" \
     https://jobone.in/api/posts/featured
```

### Get Single Post
```bash
curl -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a" \
     https://jobone.in/api/posts/123
```

### Create Post
```bash
curl -X POST https://jobone.in/api/posts \
  -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Test Job Post",
    "type": "job",
    "short_description": "Test description",
    "content": "<p>Test content</p>",
    "category_id": 1
  }'
```

### Update Post
```bash
curl -X PUT https://jobone.in/api/posts/123 \
  -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a" \
  -H "Content-Type: application/json" \
  -d '{"is_featured": true}'
```

### Delete Post
```bash
curl -X DELETE https://jobone.in/api/posts/123 \
  -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a"
```

### Get Categories (No Auth)
```bash
curl https://jobone.in/api/categories
```

### Get States (No Auth)
```bash
curl https://jobone.in/api/states
```

## Endpoints Summary

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| GET | `/posts` | ✓ | List all posts |
| GET | `/posts/search` | ✓ | Search posts |
| GET | `/posts/featured` | ✓ | Get featured posts |
| GET | `/posts/{id}` | ✓ | Get single post |
| POST | `/posts` | ✓ | Create post |
| PUT | `/posts/{id}` | ✓ | Update post |
| DELETE | `/posts/{id}` | ✓ | Delete post |
| GET | `/categories` | ✗ | Get categories |
| GET | `/states` | ✗ | Get states |
| GET | `/token` | ✓ | Get token info |
| POST | `/token/generate` | ✓ | Generate new token |

## Post Types
- `job` - Job notifications
- `admit_card` - Admit cards
- `result` - Results
- `answer_key` - Answer keys
- `syllabus` - Syllabus
- `blog` - Blog posts

## Common Query Parameters
- `page` - Page number (default: 1)
- `limit` - Items per page (default: 15)
- `type` - Filter by post type
- `category_id` - Filter by category
- `state_id` - Filter by state
- `q` - Search query

## Response Format
```json
{
  "success": true,
  "data": [...],
  "meta": {
    "total": 150,
    "per_page": 15,
    "current_page": 1,
    "last_page": 10
  }
}
```

## Error Codes
- `401` - Unauthorized (invalid token)
- `404` - Not found
- `422` - Validation error
- `500` - Server error

## Files
- `API-DOCUMENTATION.md` - Full documentation
- `JobOne-API.postman_collection.json` - Postman collection
- `API-QUICK-REFERENCE.md` - This file
