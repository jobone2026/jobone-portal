# External API Guide - Complete Overview

## 📌 What is the External API?

The JobOne.in External API allows you to post job announcements, admit cards, results, and other content to JobOne.in from external systems without using the admin panel.

**Perfect for:**
- Automated job posting from your HR system
- Bulk importing jobs from multiple sources
- Integration with third-party job boards
- Programmatic content management

---

## 🚀 Quick Start (5 Minutes)

### Step 1: Get Your API Token
```
jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a
```

### Step 2: Get Category IDs
```bash
curl -X GET https://jobone.in/api/categories \
  -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a"
```

### Step 3: Post a Job
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

### Step 4: Check Response
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

## 📚 Documentation Files

We've created comprehensive documentation for the API:

### 1. **API_QUICK_REFERENCE.md** ⚡
Quick reference card with:
- Authentication details
- All endpoints
- Required/optional fields
- Quick cURL examples
- Common errors

**Use this when:** You need a quick lookup

### 2. **API_FIELD_MAPPING.md** 📋
Complete field mapping showing:
- Frontend form fields vs API fields
- Field-by-field mapping table
- Validation rules
- Step-by-step guide
- Python script examples
- Bulk posting scripts

**Use this when:** You need to understand what data to send

### 3. **API_EXAMPLES.md** 💡
Real-world examples including:
- Banking job posts
- Railway job posts
- SSC job posts
- Admit card posts
- Result posts
- Syllabus posts
- Minimal posts
- Bulk posting scripts (Python & Bash)
- State-specific posts

**Use this when:** You need working code examples

### 4. **API_DOCUMENTATION.md** 📖
Full API documentation with:
- Complete endpoint reference
- Request/response formats
- Field reference table
- Error handling
- Best practices
- Support information

**Use this when:** You need complete technical details

### 5. **API_KEY_GUIDE.md** 🔐
API key and authentication guide with:
- API token information
- Endpoint details
- Code examples (cURL, Python, JavaScript)
- Required fields
- Error codes
- Security tips
- Testing instructions

**Use this when:** You need authentication details

---

## 🎯 Common Use Cases

### Use Case 1: Post a Single Job
**Best for:** Manual posting or testing

**Steps:**
1. Prepare job data
2. Send POST request to `/api/posts/create`
3. Get response with job URL

**Documentation:** See API_EXAMPLES.md → Example 1-7

---

### Use Case 2: Bulk Post Multiple Jobs
**Best for:** Importing jobs from CSV or database

**Steps:**
1. Prepare jobs.json with all jobs
2. Run bulk posting script (Python or Bash)
3. Monitor progress and errors

**Documentation:** See API_EXAMPLES.md → Example 8-9

---

### Use Case 3: Integrate with Your System
**Best for:** Automated job posting from your HR system

**Steps:**
1. Get API token from environment
2. Fetch categories and states
3. Transform your data to API format
4. Post jobs programmatically
5. Handle errors and retries

**Documentation:** See API_FIELD_MAPPING.md → Python Script Example

---

### Use Case 4: Post Different Content Types
**Best for:** Admit cards, results, syllabus, etc.

**Steps:**
1. Change `type` field (job, admit_card, result, etc.)
2. Adjust content accordingly
3. Send POST request

**Documentation:** See API_EXAMPLES.md → Example 4-6

---

## 🔑 API Endpoints

| Endpoint | Method | Purpose |
|----------|--------|---------|
| `/api/posts/create` | POST | Create a new job post |
| `/api/categories` | GET | Get all job categories |
| `/api/states` | GET | Get all states/UTs |

---

## 📝 Required Fields

Every job post must include:

```json
{
  "title": "Job Title",
  "type": "job",
  "short_description": "Brief description",
  "content": "<h2>Full Details</h2>",
  "category_id": 1,
  "state_id": 37
}
```

---

## 🎨 Optional Fields

Enhance your posts with:

```json
{
  "last_date": "2026-04-15",
  "notification_date": "2026-03-09",
  "total_posts": 5000,
  "meta_title": "SEO Title",
  "meta_description": "SEO Description",
  "meta_keywords": "keyword1, keyword2",
  "is_featured": true,
  "important_links": {
    "apply_online": "https://example.com/apply",
    "official_website": "https://example.com"
  }
}
```

---

## 🏢 Available Categories

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

## 🗺️ Available States

37 states and union territories including:
- Andhra Pradesh
- Arunachal Pradesh
- Assam
- Bihar
- ... (and 33 more)
- All India (ID: 37)

**Get full list:** `GET https://jobone.in/api/states`

---

## 📊 Post Types

| Type | Use For |
|------|---------|
| `job` | Job notifications |
| `admit_card` | Admit card releases |
| `result` | Exam results |
| `answer_key` | Answer keys |
| `syllabus` | Exam syllabus |
| `blog` | Blog posts |

---

## 🔐 Authentication

All API requests require Bearer token authentication:

```
Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a
Content-Type: application/json
```

---

## ✅ Success Response

```json
{
  "success": true,
  "message": "Post created successfully",
  "post": {
    "id": 123,
    "title": "Job Title",
    "slug": "job-title-slug",
    "url": "https://jobone.in/job/job-title-slug"
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

## 🧪 Testing Your Integration

### Test 1: Get Categories
```bash
curl -X GET https://jobone.in/api/categories \
  -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a"
```

### Test 2: Get States
```bash
curl -X GET https://jobone.in/api/states \
  -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a"
```

### Test 3: Create Test Post
```bash
curl -X POST https://jobone.in/api/posts/create \
  -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Test Job Post",
    "type": "job",
    "short_description": "This is a test post",
    "content": "<p>Test content</p>",
    "category_id": 1,
    "state_id": 37
  }'
```

---

## 📞 Support & Resources

**Documentation Files:**
- `API_QUICK_REFERENCE.md` - Quick lookup
- `API_FIELD_MAPPING.md` - Field mapping guide
- `API_EXAMPLES.md` - Working examples
- `API_DOCUMENTATION.md` - Full technical docs
- `API_KEY_GUIDE.md` - Authentication guide

**Website:** https://jobone.in  
**Admin Panel:** https://jobone.in/admin  
**Email:** support@jobone.in

---

## 🎓 Learning Path

**Beginner:**
1. Read this file (EXTERNAL_API_GUIDE.md)
2. Check API_QUICK_REFERENCE.md
3. Try the Quick Start example above

**Intermediate:**
1. Read API_FIELD_MAPPING.md
2. Review API_EXAMPLES.md
3. Try posting a single job

**Advanced:**
1. Read API_DOCUMENTATION.md
2. Implement bulk posting
3. Integrate with your system

---

## 📈 What's Next?

After setting up the API:

1. **Test with single post** - Verify everything works
2. **Implement bulk posting** - Use Python or Bash script
3. **Integrate with your system** - Connect to your HR/job board
4. **Monitor and maintain** - Check for errors and update as needed
5. **Scale up** - Post more jobs as needed

---

**API Version:** 1.0  
**Last Updated:** March 12, 2026  
**Status:** ✅ Production Ready

**Questions?** Check the documentation files or contact support@jobone.in
