# JobOne.in External API Documentation

Welcome to the JobOne.in External API! This API allows you to post jobs, admit cards, results, and other content to JobOne.in from external systems.

---

## 📚 Documentation Overview

We've created comprehensive documentation to help you get started:

### 🚀 **Start Here**
- **[EXTERNAL_API_GUIDE.md](EXTERNAL_API_GUIDE.md)** - Complete overview and learning path
  - What is the API?
  - Quick start guide
  - Common use cases
  - Implementation examples
  - Best practices

### ⚡ **Quick Reference**
- **[API_QUICK_REFERENCE.md](API_QUICK_REFERENCE.md)** - One-page cheat sheet
  - Authentication
  - All endpoints
  - Required/optional fields
  - Quick cURL examples
  - Common errors

### 📋 **Field Mapping**
- **[API_FIELD_MAPPING.md](API_FIELD_MAPPING.md)** - Frontend to API mapping
  - Frontend form fields vs API fields
  - Field-by-field mapping table
  - Validation rules
  - Step-by-step guide
  - Python script examples
  - Bulk posting scripts

### 💡 **Real-World Examples**
- **[API_EXAMPLES.md](API_EXAMPLES.md)** - Working code examples
  - Banking job posts
  - Railway job posts
  - SSC job posts
  - Admit card posts
  - Result posts
  - Syllabus posts
  - Bulk posting scripts (Python & Bash)
  - State-specific posts

### 📖 **Full Documentation**
- **[API_DOCUMENTATION.md](API_DOCUMENTATION.md)** - Complete technical reference
  - Endpoint details
  - Request/response formats
  - Field reference table
  - Error handling
  - Best practices
  - Support information

### 🔐 **Authentication Guide**
- **[API_KEY_GUIDE.md](API_KEY_GUIDE.md)** - API key and authentication
  - API token information
  - Endpoint details
  - Code examples (cURL, Python, JavaScript)
  - Required fields
  - Error codes
  - Security tips
  - Testing instructions

---

## 🎯 Quick Start

### 1. Get Your API Token
```
jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a
```

### 2. Get Categories
```bash
curl -X GET https://jobone.in/api/categories \
  -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a"
```

### 3. Post a Job
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
    "total_posts": 5000,
    "is_featured": true
  }'
```

---

## 📊 API Endpoints

| Endpoint | Method | Purpose |
|----------|--------|---------|
| `/api/posts/create` | POST | Create a new job post |
| `/api/categories` | GET | Get all job categories |
| `/api/states` | GET | Get all states/UTs |

---

## 🔑 Authentication

All requests require Bearer token:
```
Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a
Content-Type: application/json
```

---

## 📝 Required Fields

Every job post must include:
- `title` - Job title (max 255 chars)
- `type` - Post type (job, admit_card, result, etc.)
- `short_description` - Brief description
- `content` - Full HTML content
- `category_id` - Category ID (1-15)
- `state_id` - State ID (1-37) or null

---

## 🎨 Optional Fields

- `last_date` - Application deadline (YYYY-MM-DD)
- `notification_date` - Notification date (YYYY-MM-DD)
- `total_posts` - Number of vacancies
- `meta_title` - SEO title (max 60 chars)
- `meta_description` - SEO description (max 160 chars)
- `meta_keywords` - SEO keywords
- `is_featured` - Featured post (true/false)
- `important_links` - External links object

---

## 🏢 Categories

| ID | Category |
|----|----------|
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

## 📊 Post Types

- `job` - Job notification
- `admit_card` - Admit card
- `result` - Exam result
- `answer_key` - Answer key
- `syllabus` - Exam syllabus
- `blog` - Blog post

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
**Solution:** Check your API token

### 422 Validation Error
```json
{"error": "Failed to create post", "message": "The given data was invalid"}
```
**Solution:** Check all required fields are provided

### 500 Server Error
```json
{"error": "Failed to create post", "message": "Error details"}
```
**Solution:** Check server logs

---

## 🛠️ Implementation Examples

### Python
```python
import requests

API_TOKEN = "jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a"
headers = {
    "Authorization": f"Bearer {API_TOKEN}",
    "Content-Type": "application/json"
}

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

### JavaScript/Node.js
```javascript
const API_TOKEN = "jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a";
const headers = {
  "Authorization": `Bearer ${API_TOKEN}`,
  "Content-Type": "application/json"
};

const jobData = {
  title: "SBI Clerk Recruitment 2026 - 5000 Posts",
  type: "job",
  short_description: "State Bank of India is recruiting 5000 Clerk positions",
  content: "<h2>SBI Clerk Recruitment 2026</h2><p>Details...</p>",
  category_id: 1,
  state_id: 37,
  total_posts: 5000,
  is_featured: true
};

fetch("https://jobone.in/api/posts/create", {
  method: "POST",
  headers,
  body: JSON.stringify(jobData)
})
  .then(res => res.json())
  .then(data => console.log(data));
```

### cURL
```bash
curl -X POST https://jobone.in/api/posts/create \
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

---

## 📋 Checklist

Before posting, verify:
- [ ] API token is correct
- [ ] Title is provided (max 255 chars)
- [ ] Type is valid
- [ ] Short description is provided
- [ ] Content is provided
- [ ] Category ID is valid (1-15)
- [ ] State ID is valid or null
- [ ] Dates are in YYYY-MM-DD format
- [ ] Meta title is max 60 chars
- [ ] Meta description is max 160 chars
- [ ] Using HTTPS

---

## 🚀 Best Practices

1. **Use HTTPS only** - Always use https:// URLs
2. **Validate data** - Check all required fields before posting
3. **Rate limiting** - Add delays between bulk posts (1-2 seconds)
4. **Error handling** - Implement retry logic for failed requests
5. **Keep token secure** - Never share your API token
6. **Test first** - Test with one post before bulk posting
7. **Use meaningful content** - Provide complete job details
8. **Monitor responses** - Check for errors and handle them
9. **Rotate token regularly** - Change API token every 90 days
10. **Document your integration** - Keep records of what you're posting

---

## 🎓 Learning Path

### Beginner (15 minutes)
1. Read this file (API_README.md)
2. Check [API_QUICK_REFERENCE.md](API_QUICK_REFERENCE.md)
3. Try the Quick Start example above

### Intermediate (1 hour)
1. Read [API_FIELD_MAPPING.md](API_FIELD_MAPPING.md)
2. Review [API_EXAMPLES.md](API_EXAMPLES.md)
3. Try posting a single job

### Advanced (2+ hours)
1. Read [API_DOCUMENTATION.md](API_DOCUMENTATION.md)
2. Implement bulk posting
3. Integrate with your system

---

## 📞 Support

**Documentation:**
- [EXTERNAL_API_GUIDE.md](EXTERNAL_API_GUIDE.md) - Complete overview
- [API_QUICK_REFERENCE.md](API_QUICK_REFERENCE.md) - Quick lookup
- [API_FIELD_MAPPING.md](API_FIELD_MAPPING.md) - Field mapping
- [API_EXAMPLES.md](API_EXAMPLES.md) - Working examples
- [API_DOCUMENTATION.md](API_DOCUMENTATION.md) - Full technical docs
- [API_KEY_GUIDE.md](API_KEY_GUIDE.md) - Authentication guide

**Website:** https://jobone.in  
**Admin Panel:** https://jobone.in/admin  
**Email:** support@jobone.in

---

## 🔄 What's Next?

1. **Test with single post** - Verify everything works
2. **Implement bulk posting** - Use Python or Bash script
3. **Integrate with your system** - Connect to your HR/job board
4. **Monitor and maintain** - Check for errors and update as needed
5. **Scale up** - Post more jobs as needed

---

**API Version:** 1.0  
**Last Updated:** March 12, 2026  
**Status:** ✅ Production Ready

**Ready to get started?** → Read [EXTERNAL_API_GUIDE.md](EXTERNAL_API_GUIDE.md)
