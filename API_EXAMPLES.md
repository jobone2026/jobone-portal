# API Examples - Real-World Job Posting Scenarios

## Example 1: Banking Job Post

**Frontend Form Data:**
- Title: SBI Clerk Recruitment 2026 - 5000 Posts
- Type: Job
- Category: Banking
- State: All India
- Content: Full job details
- Meta Title: SBI Clerk Recruitment 2026 - 5000 Posts
- Meta Description: Apply for SBI Clerk 2026. 5000 vacancies. Last date 15 Apr 2026.
- Meta Keywords: SBI Clerk, Banking Jobs, Recruitment 2026
- Featured Post: Yes
- Published: Yes

**API Request:**
```bash
curl -X POST https://jobone.in/api/posts/create \
  -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "SBI Clerk Recruitment 2026 - 5000 Posts",
    "type": "job",
    "short_description": "State Bank of India is recruiting 5000 Clerk positions across India. Eligibility: 12th Pass. Salary: Rs 20,000-30,000",
    "content": "<h2>SBI Clerk Recruitment 2026</h2><p><strong>Eligibility:</strong> 12th Pass</p><p><strong>Salary:</strong> Rs 20,000-30,000</p><p><strong>Age Limit:</strong> 18-28 years</p><p><strong>Selection Process:</strong> Prelims, Mains, Interview</p>",
    "category_id": 1,
    "state_id": 37,
    "last_date": "2026-04-15",
    "notification_date": "2026-03-09",
    "total_posts": 5000,
    "meta_title": "SBI Clerk Recruitment 2026 - 5000 Posts",
    "meta_description": "Apply for SBI Clerk 2026. 5000 vacancies. Last date 15 Apr 2026.",
    "meta_keywords": "SBI Clerk, Banking Jobs, Recruitment 2026",
    "is_featured": true,
    "important_links": {
      "official_website": "https://sbi.co.in",
      "apply_online": "https://sbi.co.in/apply",
      "notification": "https://sbi.co.in/notification.pdf",
      "admit_card": "https://sbi.co.in/admit-card"
    }
  }'
```

---

## Example 2: Railway Job Post

**Frontend Form Data:**
- Title: Railway Group D 2026 - 10000 Posts
- Type: Job
- Category: Railways
- State: All India
- Content: Full job details
- Meta Title: Railway Group D 2026 - 10000 Posts
- Meta Description: Indian Railways Group D recruitment 2026. 10000 vacancies.
- Meta Keywords: Railway Group D, Railways Jobs, Recruitment 2026
- Featured Post: Yes
- Published: Yes

**API Request:**
```bash
curl -X POST https://jobone.in/api/posts/create \
  -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Railway Group D 2026 - 10000 Posts",
    "type": "job",
    "short_description": "Indian Railways is recruiting 10000 Group D positions across India. Eligibility: 10th Pass. Salary: Rs 18,000-25,000",
    "content": "<h2>Railway Group D 2026</h2><p><strong>Eligibility:</strong> 10th Pass</p><p><strong>Salary:</strong> Rs 18,000-25,000</p><p><strong>Age Limit:</strong> 18-33 years</p><p><strong>Selection Process:</strong> CBT, Physical Test, Document Verification</p>",
    "category_id": 2,
    "state_id": 37,
    "last_date": "2026-05-30",
    "notification_date": "2026-03-15",
    "total_posts": 10000,
    "meta_title": "Railway Group D 2026 - 10000 Posts",
    "meta_description": "Indian Railways Group D recruitment 2026. 10000 vacancies.",
    "meta_keywords": "Railway Group D, Railways Jobs, Recruitment 2026",
    "is_featured": true,
    "important_links": {
      "official_website": "https://indianrailways.gov.in",
      "apply_online": "https://rrc.indianrailways.gov.in",
      "notification": "https://rrc.indianrailways.gov.in/notification.pdf"
    }
  }'
```

---

## Example 3: SSC Job Post

**Frontend Form Data:**
- Title: SSC CGL 2026 Notification
- Type: Job
- Category: SSC
- State: All India
- Content: Full job details
- Meta Title: SSC CGL 2026 Notification
- Meta Description: SSC CGL 2026 notification released. 8000 vacancies.
- Meta Keywords: SSC CGL, SSC Recruitment, Government Jobs
- Featured Post: Yes
- Published: Yes

**API Request:**
```bash
curl -X POST https://jobone.in/api/posts/create \
  -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "SSC CGL 2026 Notification",
    "type": "job",
    "short_description": "Staff Selection Commission is recruiting for CGL 2026. 8000 vacancies. Eligibility: 12th Pass. Salary: Rs 25,000-47,000",
    "content": "<h2>SSC CGL 2026</h2><p><strong>Eligibility:</strong> 12th Pass</p><p><strong>Salary:</strong> Rs 25,000-47,000</p><p><strong>Age Limit:</strong> 18-27 years</p><p><strong>Selection Process:</strong> Tier 1, Tier 2, Tier 3, Tier 4</p>",
    "category_id": 3,
    "state_id": 37,
    "last_date": "2026-06-15",
    "notification_date": "2026-03-20",
    "total_posts": 8000,
    "meta_title": "SSC CGL 2026 Notification",
    "meta_description": "SSC CGL 2026 notification released. 8000 vacancies.",
    "meta_keywords": "SSC CGL, SSC Recruitment, Government Jobs",
    "is_featured": true,
    "important_links": {
      "official_website": "https://ssc.nic.in",
      "apply_online": "https://ssc.nic.in/apply",
      "notification": "https://ssc.nic.in/notification.pdf"
    }
  }'
```

---

## Example 4: Admit Card Post

**Frontend Form Data:**
- Title: SBI Clerk Admit Card 2026
- Type: Admit Card
- Category: Banking
- State: All India
- Content: Admit card details
- Meta Title: SBI Clerk Admit Card 2026
- Meta Description: SBI Clerk admit card released. Download now.
- Meta Keywords: SBI Clerk, Admit Card, 2026
- Featured Post: Yes
- Published: Yes

**API Request:**
```bash
curl -X POST https://jobone.in/api/posts/create \
  -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "SBI Clerk Admit Card 2026",
    "type": "admit_card",
    "short_description": "SBI Clerk admit card has been released. Download your admit card from the official website.",
    "content": "<h2>SBI Clerk Admit Card 2026</h2><p><strong>Exam Date:</strong> 15 April 2026</p><p><strong>How to Download:</strong> Visit sbi.co.in and login with your credentials</p>",
    "category_id": 1,
    "state_id": 37,
    "notification_date": "2026-04-01",
    "meta_title": "SBI Clerk Admit Card 2026",
    "meta_description": "SBI Clerk admit card released. Download now.",
    "meta_keywords": "SBI Clerk, Admit Card, 2026",
    "is_featured": true,
    "important_links": {
      "download_admit_card": "https://sbi.co.in/admit-card",
      "official_website": "https://sbi.co.in"
    }
  }'
```

---

## Example 5: Result Post

**Frontend Form Data:**
- Title: SBI Clerk Prelims Result 2026
- Type: Result
- Category: Banking
- State: All India
- Content: Result details
- Meta Title: SBI Clerk Prelims Result 2026
- Meta Description: SBI Clerk prelims result announced. Check your result.
- Meta Keywords: SBI Clerk, Result, 2026
- Featured Post: Yes
- Published: Yes

**API Request:**
```bash
curl -X POST https://jobone.in/api/posts/create \
  -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "SBI Clerk Prelims Result 2026",
    "type": "result",
    "short_description": "SBI Clerk prelims result has been announced. Check your result on the official website.",
    "content": "<h2>SBI Clerk Prelims Result 2026</h2><p><strong>Result Date:</strong> 20 April 2026</p><p><strong>How to Check:</strong> Visit sbi.co.in and login with your credentials</p>",
    "category_id": 1,
    "state_id": 37,
    "notification_date": "2026-04-20",
    "meta_title": "SBI Clerk Prelims Result 2026",
    "meta_description": "SBI Clerk prelims result announced. Check your result.",
    "meta_keywords": "SBI Clerk, Result, 2026",
    "is_featured": true,
    "important_links": {
      "check_result": "https://sbi.co.in/result",
      "official_website": "https://sbi.co.in"
    }
  }'
```

---

## Example 6: Syllabus Post

**Frontend Form Data:**
- Title: SSC CGL 2026 Syllabus
- Type: Syllabus
- Category: SSC
- State: All India
- Content: Syllabus details
- Meta Title: SSC CGL 2026 Syllabus
- Meta Description: SSC CGL 2026 syllabus and exam pattern.
- Meta Keywords: SSC CGL, Syllabus, 2026
- Featured Post: No
- Published: Yes

**API Request:**
```bash
curl -X POST https://jobone.in/api/posts/create \
  -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "SSC CGL 2026 Syllabus",
    "type": "syllabus",
    "short_description": "Complete SSC CGL 2026 syllabus and exam pattern for all tiers.",
    "content": "<h2>SSC CGL 2026 Syllabus</h2><h3>Tier 1 (CBT)</h3><p><strong>General Intelligence:</strong> Analogies, Similarities, Differences, etc.</p><p><strong>General Awareness:</strong> History, Geography, Science, etc.</p>",
    "category_id": 3,
    "state_id": 37,
    "meta_title": "SSC CGL 2026 Syllabus",
    "meta_description": "SSC CGL 2026 syllabus and exam pattern.",
    "meta_keywords": "SSC CGL, Syllabus, 2026",
    "is_featured": false,
    "important_links": {
      "official_notification": "https://ssc.nic.in/notification.pdf"
    }
  }'
```

---

## Example 7: Minimal Post (Only Required Fields)

**API Request:**
```bash
curl -X POST https://jobone.in/api/posts/create \
  -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "UPSC Civil Services 2026",
    "type": "job",
    "short_description": "UPSC is recruiting for Civil Services 2026",
    "content": "<h2>UPSC Civil Services 2026</h2><p>Details here...</p>",
    "category_id": 4,
    "state_id": 37
  }'
```

---

## Example 8: Bulk Posting with Python

**jobs_data.py:**
```python
import requests
import json
import time

API_TOKEN = "jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a"
BASE_URL = "https://jobone.in/api"

headers = {
    "Authorization": f"Bearer {API_TOKEN}",
    "Content-Type": "application/json"
}

jobs = [
    {
        "title": "SBI Clerk Recruitment 2026 - 5000 Posts",
        "type": "job",
        "short_description": "State Bank of India is recruiting 5000 Clerk positions",
        "content": "<h2>SBI Clerk Recruitment 2026</h2><p>Details...</p>",
        "category_id": 1,
        "state_id": 37,
        "total_posts": 5000,
        "is_featured": True
    },
    {
        "title": "Railway Group D 2026 - 10000 Posts",
        "type": "job",
        "short_description": "Indian Railways is recruiting 10000 Group D positions",
        "content": "<h2>Railway Group D 2026</h2><p>Details...</p>",
        "category_id": 2,
        "state_id": 37,
        "total_posts": 10000,
        "is_featured": True
    },
    {
        "title": "SSC CGL 2026 Notification",
        "type": "job",
        "short_description": "Staff Selection Commission is recruiting for CGL 2026",
        "content": "<h2>SSC CGL 2026</h2><p>Details...</p>",
        "category_id": 3,
        "state_id": 37,
        "total_posts": 8000,
        "is_featured": True
    }
]

print("Starting bulk job posting...")
for i, job in enumerate(jobs, 1):
    print(f"\n[{i}/{len(jobs)}] Posting: {job['title']}")
    
    response = requests.post(f"{BASE_URL}/posts/create", headers=headers, json=job)
    result = response.json()
    
    if result.get('success'):
        print(f"✅ Posted successfully")
        print(f"URL: {result['post']['url']}")
    else:
        print(f"❌ Failed: {result.get('error')}")
    
    time.sleep(2)

print("\n✅ Bulk posting complete!")
```

**Run:**
```bash
python jobs_data.py
```

---

## Example 9: Bulk Posting with Bash

**jobs.json:**
```json
[
  {
    "title": "SBI Clerk Recruitment 2026 - 5000 Posts",
    "type": "job",
    "short_description": "State Bank of India is recruiting 5000 Clerk positions",
    "content": "<h2>SBI Clerk Recruitment 2026</h2><p>Details...</p>",
    "category_id": 1,
    "state_id": 37,
    "total_posts": 5000,
    "is_featured": true
  },
  {
    "title": "Railway Group D 2026 - 10000 Posts",
    "type": "job",
    "short_description": "Indian Railways is recruiting 10000 Group D positions",
    "content": "<h2>Railway Group D 2026</h2><p>Details...</p>",
    "category_id": 2,
    "state_id": 37,
    "total_posts": 10000,
    "is_featured": true
  }
]
```

**post_jobs.sh:**
```bash
#!/bin/bash

API_TOKEN="jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a"
API_URL="https://jobone.in/api/posts/create"

echo "Starting bulk job posting..."

jq -c '.[]' jobs.json | while read job; do
  title=$(echo $job | jq -r '.title')
  echo "Posting: $title"
  
  response=$(curl -s -X POST "$API_URL" \
    -H "Authorization: Bearer $API_TOKEN" \
    -H "Content-Type: application/json" \
    -d "$job")
  
  if echo "$response" | jq -e '.success' > /dev/null 2>&1; then
    echo "✅ Posted successfully"
    url=$(echo $response | jq -r '.post.url')
    echo "URL: $url"
  else
    error=$(echo $response | jq -r '.error')
    echo "❌ Failed: $error"
  fi
  
  echo "---"
  sleep 2
done

echo "✅ Bulk posting complete!"
```

**Run:**
```bash
chmod +x post_jobs.sh
./post_jobs.sh
```

---

## Example 10: State-Specific Job Post

**API Request (Andhra Pradesh only):**
```bash
curl -X POST https://jobone.in/api/posts/create \
  -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Andhra Pradesh Police Recruitment 2026",
    "type": "job",
    "short_description": "Andhra Pradesh Police is recruiting for various positions",
    "content": "<h2>AP Police Recruitment 2026</h2><p>Details...</p>",
    "category_id": 6,
    "state_id": 1,
    "total_posts": 2000,
    "is_featured": true
  }'
```

---

## Summary

**All examples follow the same pattern:**

1. ✅ Set Authorization header with API token
2. ✅ Set Content-Type to application/json
3. ✅ Provide required fields (title, type, short_description, content, category_id)
4. ✅ Add optional fields as needed
5. ✅ Send POST request to `/api/posts/create`
6. ✅ Parse response and handle success/error

**For bulk posting:**
- Use Python for complex logic
- Use Bash for simple sequential posting
- Add delays between requests (1-2 seconds)
- Implement error handling and retry logic

---

**API Version:** 1.0  
**Last Updated:** March 12, 2026  
**Status:** ✅ Production Ready
