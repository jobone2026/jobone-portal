# API Quick Reference Card

## 🔑 Authentication
```
Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a
Content-Type: application/json
```

---

## 📋 Endpoints

### 1️⃣ Create Job Post
```
POST https://jobone.in/api/posts/create
```

### 2️⃣ Get Categories
```
GET https://jobone.in/api/categories
```

### 3️⃣ Get States
```
GET https://jobone.in/api/states
```

---

## 📝 Required Fields for Job Post

```json
{
  "title": "Job Title",
  "type": "job",
  "short_description": "Brief description",
  "content": "<h2>Details</h2><p>Full content</p>",
  "category_id": 1,
  "state_id": 37
}
```

---

## 🎯 Optional Fields

```json
{
  "last_date": "2026-04-15",
  "notification_date": "2026-03-09",
  "total_posts": 5000,
  "meta_title": "SEO Title (max 60 chars)",
  "meta_description": "SEO Description (max 160 chars)",
  "meta_keywords": "keyword1, keyword2, keyword3",
  "is_featured": true,
  "important_links": {
    "apply_online": "https://example.com/apply",
    "official_website": "https://example.com"
  }
}
```

---

## 📚 Post Types

- `job` - Job notification
- `admit_card` - Admit card
- `result` - Exam result
- `answer_key` - Answer key
- `syllabus` - Exam syllabus
- `blog` - Blog post

---

## 🏢 Categories (ID → Name)

| ID | Name |
|----|------|
| 1 | Banking |
| 2 | Railways |
| 3 | SSC |
| 4 | UPSC |
| 5 | Defence |
| 6 | Police |
| 7 | Teaching |
| 8 | PSU |
| 9 | State Govt |
| 10 | Central Govt |
| 11 | Court |
| 12 | Medical |
| 13 | Engineering |
| 14 | Agriculture |
| 15 | Post Office |

---

## 🗺️ States (Sample IDs)

| ID | Name |
|----|------|
| 1 | Andhra Pradesh |
| 2 | Arunachal Pradesh |
| 3 | Assam |
| 4 | Bihar |
| ... | ... |
| 37 | All India |

**Get full list:** `GET https://jobone.in/api/states`

---

## 🚀 Quick cURL Example

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
    "is_featured": true
  }'
```

---

## ✅ Success Response

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

## ❌ Error Responses

### 401 Unauthorized
```json
{"error": "Unauthorized"}
```
→ Check API token

### 422 Validation Error
```json
{"error": "Failed to create post", "message": "The given data was invalid"}
```
→ Check required fields

### 500 Server Error
```json
{"error": "Failed to create post", "message": "Error details"}
```
→ Check server logs

---

## 🐍 Python Quick Example

```python
import requests

API_TOKEN = "jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a"
headers = {
    "Authorization": f"Bearer {API_TOKEN}",
    "Content-Type": "application/json"
}

# Get categories
categories = requests.get("https://jobone.in/api/categories", headers=headers).json()

# Get states
states = requests.get("https://jobone.in/api/states", headers=headers).json()

# Create post
job_data = {
    "title": "SBI Clerk Recruitment 2026 - 5000 Posts",
    "type": "job",
    "short_description": "State Bank of India is recruiting 5000 Clerk positions",
    "content": "<h2>SBI Clerk Recruitment 2026</h2><p>Details...</p>",
    "category_id": 1,
    "state_id": 37,
    "total_posts": 5000,
    "is_featured": True
}

response = requests.post("https://jobone.in/api/posts/create", headers=headers, json=job_data)
print(response.json())
```

---

## 📋 Checklist Before Posting

- [ ] API token is correct
- [ ] Title is provided (max 255 chars)
- [ ] Type is valid (job, admit_card, result, etc.)
- [ ] Short description is provided
- [ ] Content is provided (HTML allowed)
- [ ] Category ID is valid (1-15)
- [ ] State ID is valid or null
- [ ] Dates are in YYYY-MM-DD format
- [ ] Meta title is max 60 chars
- [ ] Meta description is max 160 chars
- [ ] Using HTTPS (not HTTP)

---

## 🔗 Full Documentation

For complete details, see:
- `API_DOCUMENTATION.md` - Full API documentation
- `API_FIELD_MAPPING.md` - Frontend to API field mapping
- `API_KEY_GUIDE.md` - API key and authentication guide

---

**API Version:** 1.0  
**Last Updated:** March 12, 2026  
**Status:** ✅ Production Ready
