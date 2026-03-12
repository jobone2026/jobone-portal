# API Key & Authentication Guide

## 🔐 API Token

**Your API Token:**
```
jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a
```

**Location:** `.env` file
```
API_TOKEN=jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a
```

---

## 📝 API Endpoints

### 1. Create Job Post
**Endpoint:** `POST /api/posts/create`

**Headers:**
```
Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a
Content-Type: application/json
```

**Request Body:**
```json
{
  "title": "SBI Clerk Recruitment 2026 - 5000 Posts",
  "type": "job",
  "short_description": "State Bank of India invites applications for recruitment of Junior Associates",
  "content": "<h2>SBI Clerk Recruitment 2026</h2><p>Details here...</p>",
  "category_id": 1,
  "state_id": 37,
  "last_date": "2026-04-15",
  "notification_date": "2026-03-15",
  "total_posts": 5000,
  "important_links": [
    {
      "label": "Official Notification",
      "url": "https://sbi.co.in/careers"
    },
    {
      "label": "Apply Online",
      "url": "https://sbi.co.in/apply"
    }
  ],
  "meta_title": "SBI Clerk Recruitment 2026 - 5000 Posts",
  "meta_description": "SBI Clerk Recruitment 2026: Apply online for 5000 Junior Associate posts",
  "meta_keywords": "SBI Clerk, SBI Recruitment 2026, Banking Jobs",
  "is_featured": true
}
```

**Response (Success):**
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

**Response (Error):**
```json
{
  "error": "Failed to create post",
  "message": "Error details here"
}
```

---

### 2. Get All Categories
**Endpoint:** `GET /api/categories`

**Headers:**
```
Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a
```

**Response:**
```json
[
  {
    "id": 1,
    "name": "Banking"
  },
  {
    "id": 2,
    "name": "Railways"
  },
  {
    "id": 3,
    "name": "SSC"
  },
  ...
]
```

---

### 3. Get All States
**Endpoint:** `GET /api/states`

**Headers:**
```
Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a
```

**Response:**
```json
[
  {
    "id": 1,
    "name": "Andhra Pradesh"
  },
  {
    "id": 2,
    "name": "Arunachal Pradesh"
  },
  {
    "id": 37,
    "name": "All India"
  },
  ...
]
```

---

## 🔄 Post Types

Valid post types:
- `job` - Job notification
- `admit_card` - Admit card
- `result` - Exam result
- `answer_key` - Answer key
- `syllabus` - Exam syllabus
- `blog` - Blog post

---

## 📚 cURL Examples

### Create a Job Post
```bash
curl -X POST https://jobone.in/api/posts/create \
  -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "SBI Clerk Recruitment 2026 - 5000 Posts",
    "type": "job",
    "short_description": "State Bank of India invites applications for recruitment of Junior Associates",
    "content": "<h2>SBI Clerk Recruitment 2026</h2><p>Details here...</p>",
    "category_id": 1,
    "state_id": 37,
    "last_date": "2026-04-15",
    "notification_date": "2026-03-15",
    "total_posts": 5000,
    "is_featured": true
  }'
```

### Get Categories
```bash
curl -X GET https://jobone.in/api/categories \
  -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a"
```

### Get States
```bash
curl -X GET https://jobone.in/api/states \
  -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a"
```

---

## 🐍 Python Example

```python
import requests
import json

API_TOKEN = "jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a"
BASE_URL = "https://jobone.in/api"

headers = {
    "Authorization": f"Bearer {API_TOKEN}",
    "Content-Type": "application/json"
}

# Get categories
response = requests.get(f"{BASE_URL}/categories", headers=headers)
categories = response.json()
print("Categories:", categories)

# Get states
response = requests.get(f"{BASE_URL}/states", headers=headers)
states = response.json()
print("States:", states)

# Create a job post
job_data = {
    "title": "SBI Clerk Recruitment 2026 - 5000 Posts",
    "type": "job",
    "short_description": "State Bank of India invites applications",
    "content": "<h2>SBI Clerk Recruitment 2026</h2><p>Details...</p>",
    "category_id": 1,
    "state_id": 37,
    "last_date": "2026-04-15",
    "notification_date": "2026-03-15",
    "total_posts": 5000,
    "is_featured": True
}

response = requests.post(f"{BASE_URL}/posts/create", headers=headers, json=job_data)
result = response.json()
print("Created Post:", result)
```

---

## 🔗 JavaScript/Node.js Example

```javascript
const API_TOKEN = "jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a";
const BASE_URL = "https://jobone.in/api";

const headers = {
  "Authorization": `Bearer ${API_TOKEN}`,
  "Content-Type": "application/json"
};

// Get categories
fetch(`${BASE_URL}/categories`, { headers })
  .then(res => res.json())
  .then(data => console.log("Categories:", data));

// Get states
fetch(`${BASE_URL}/states`, { headers })
  .then(res => res.json())
  .then(data => console.log("States:", data));

// Create a job post
const jobData = {
  title: "SBI Clerk Recruitment 2026 - 5000 Posts",
  type: "job",
  short_description: "State Bank of India invites applications",
  content: "<h2>SBI Clerk Recruitment 2026</h2><p>Details...</p>",
  category_id: 1,
  state_id: 37,
  last_date: "2026-04-15",
  notification_date: "2026-03-15",
  total_posts: 5000,
  is_featured: true
};

fetch(`${BASE_URL}/posts/create`, {
  method: "POST",
  headers,
  body: JSON.stringify(jobData)
})
  .then(res => res.json())
  .then(data => console.log("Created Post:", data));
```

---

## 📋 Required Fields

### For Job Posts:
- `title` (required) - Job title
- `type` (required) - Must be "job"
- `short_description` (required) - Brief description
- `content` (required) - Full HTML content
- `category_id` (required) - Category ID (get from /api/categories)
- `state_id` (optional) - State ID (get from /api/states)

### Optional Fields:
- `last_date` - Application deadline (YYYY-MM-DD)
- `notification_date` - Notification date (YYYY-MM-DD)
- `total_posts` - Number of vacancies
- `important_links` - Array of {label, url} objects
- `meta_title` - SEO title (max 60 chars)
- `meta_description` - SEO description (max 160 chars)
- `meta_keywords` - SEO keywords
- `is_featured` - Featured post (true/false)

---

## ⚠️ Error Codes

| Code | Message | Solution |
|------|---------|----------|
| 401 | Unauthorized | Check API token is correct |
| 422 | Validation Error | Check required fields |
| 500 | Server Error | Check server logs |

---

## 🔒 Security Tips

1. **Keep API Token Secret**
   - Don't share in public repositories
   - Don't commit to version control
   - Use environment variables

2. **Use HTTPS Only**
   - All API calls must use HTTPS
   - Never send token over HTTP

3. **Rate Limiting**
   - Implement rate limiting on your end
   - Don't make excessive requests

4. **Validate Input**
   - Validate all data before sending
   - Use proper error handling

5. **Rotate Token Regularly**
   - Change API token every 90 days
   - Revoke old tokens immediately

---

## 🧪 Testing

### Test with Postman:
1. Create new POST request
2. URL: `https://jobone.in/api/posts/create`
3. Headers:
   - `Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a`
   - `Content-Type: application/json`
4. Body: JSON data
5. Send request

### Test with cURL:
```bash
curl -X POST https://jobone.in/api/posts/create \
  -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a" \
  -H "Content-Type: application/json" \
  -d '{"title":"Test","type":"job","short_description":"Test","content":"Test","category_id":1,"state_id":37}'
```

---

## 📞 Support

For API issues:
1. Check error message in response
2. Verify API token is correct
3. Check required fields are present
4. Review server logs: `/var/log/laravel.log`

---

**API Version:** 1.0  
**Last Updated:** March 12, 2026  
**Status:** ✅ Production Ready
