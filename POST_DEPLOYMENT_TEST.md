# Post-Deployment Testing Guide

After deploying the SEO fixes, follow this testing guide to ensure everything works correctly.

## Pre-Test Verification

```bash
# 1. Verify APP_URL is correct
grep APP_URL .env
# Should show: APP_URL=https://jobone.in (NOT localhost)

# 2. Verify OG image exists
ls -lh public/images/og-image.jpg
# Should show file with size (e.g., 50K-200K)

# 3. Verify file permissions
stat -c "%a %n" public/images/og-image.jpg
# Should show: 644 public/images/og-image.jpg

# 4. Verify caches are cleared
php artisan config:show app.url
# Should show: https://jobone.in
```

## Test 1: Homepage Meta Tags

### Browser Test
1. Open https://jobone.in in browser
2. Right-click → View Page Source
3. Search for `og:image`
4. Verify you see:
   ```html
   <meta property="og:image" content="https://jobone.in/images/og-image.jpg">
   <meta property="og:image:width" content="1200">
   <meta property="og:image:height" content="630">
   ```

### Command Line Test
```bash
curl -s https://jobone.in | grep -i "og:image"
curl -s https://jobone.in | grep -i "og:description"
curl -s https://jobone.in | grep -i "og:title"
```

**Expected Output:**
- Should contain `https://jobone.in/images/og-image.jpg`
- Should NOT contain `localhost`
- Should have proper descriptions

## Test 2: Individual Post Meta Tags

### Browser Test
1. Open any job post (e.g., https://jobone.in/jobs/ssc-cgl-2026)
2. View Page Source
3. Verify meta tags contain:
   - Post title in `og:title`
   - Post description in `og:description`
   - Post image or default og-image in `og:image`

### Command Line Test
```bash
# Replace with actual post URL
curl -s https://jobone.in/jobs/your-post-slug | grep -i "og:description"
```

**Expected Output:**
- Description should NOT be empty
- Should contain relevant job information

## Test 3: Facebook/WhatsApp Debugger

### Steps
1. Go to: https://developers.facebook.com/tools/debug/
2. Enter: `https://jobone.in`
3. Click "Debug"

### What to Check
- ✅ Title shows correctly
- ✅ Description shows correctly
- ✅ Image shows (1200x630)
- ✅ No errors or warnings
- ✅ URL is correct (not localhost)

### Clear Cache
1. Click "Scrape Again" button
2. Verify updated information shows

### Test Multiple URLs
- Homepage: `https://jobone.in`
- Jobs listing: `https://jobone.in/jobs`
- Individual post: `https://jobone.in/jobs/[slug]`
- Category: `https://jobone.in/category/[slug]`
- State: `https://jobone.in/state/[slug]`

## Test 4: WhatsApp Share

### Mobile Test
1. Open WhatsApp on mobile
2. Share link: `https://jobone.in`
3. Wait 2-3 seconds for preview to load

### What to Check
- ✅ Image appears (og-image.jpg)
- ✅ Title appears
- ✅ Description appears
- ✅ Preview looks professional

### Desktop Test
1. Open WhatsApp Web
2. Share link in any chat
3. Verify preview appears

**Note:** WhatsApp caches previews for 7 days. If old preview shows, use Facebook Debugger to clear cache.

## Test 5: Telegram Share

### Steps
1. Open Telegram
2. Share link: `https://jobone.in`
3. Verify preview appears

### What to Check
- ✅ Image appears
- ✅ Title appears
- ✅ Description appears
- ✅ Link is clickable

**Note:** Telegram usually updates within minutes, but may cache for up to 24 hours.

## Test 6: Twitter Card

### Steps
1. Go to: https://cards-dev.twitter.com/validator
2. Enter: `https://jobone.in`
3. Click "Preview card"

### What to Check
- ✅ Card type: summary_large_image
- ✅ Image displays correctly
- ✅ Title and description show

## Test 7: LinkedIn

### Steps
1. Go to: https://www.linkedin.com/post-inspector/
2. Enter: `https://jobone.in`
3. Click "Inspect"

### What to Check
- ✅ Image appears
- ✅ Title and description correct
- ✅ No errors

## Test 8: Google Search Console

### Steps
1. Go to: https://search.google.com/search-console
2. URL Inspection tool
3. Enter: `https://jobone.in`
4. Click "Test Live URL"

### What to Check
- ✅ Page is indexable
- ✅ Meta description appears
- ✅ Structured data valid (if applicable)

## Test 9: Rich Results Test

### Steps
1. Go to: https://search.google.com/test/rich-results
2. Enter: `https://jobone.in/jobs/[any-job-post]`
3. Click "Test URL"

### What to Check
- ✅ JobPosting schema detected (for job posts)
- ✅ Article schema detected (for blogs)
- ✅ No errors

## Test 10: Image Accessibility

### Direct Image Test
```bash
# Test if image is accessible
curl -I https://jobone.in/images/og-image.jpg

# Should return:
# HTTP/1.1 200 OK
# Content-Type: image/jpeg
# Content-Length: [size]
```

### Browser Test
1. Open: `https://jobone.in/images/og-image.jpg`
2. Image should load correctly
3. Check dimensions (should be 1200x630)

## Test 11: Mobile Responsiveness

### Steps
1. Open https://jobone.in on mobile
2. Share link via any app
3. Verify preview works

### Apps to Test
- WhatsApp
- Telegram
- Facebook Messenger
- Twitter
- LinkedIn

## Test 12: Performance Check

### Image Size
```bash
# Check og-image.jpg file size
ls -lh public/images/og-image.jpg

# Should be < 300KB for optimal loading
```

### Page Load Test
1. Go to: https://pagespeed.web.dev/
2. Enter: `https://jobone.in`
3. Check performance score

## Common Issues & Solutions

### Issue: Image not showing in WhatsApp
**Possible Causes:**
1. WhatsApp cache (wait 7 days or use Facebook Debugger)
2. Image file doesn't exist
3. Wrong file permissions
4. APP_URL still set to localhost

**Solutions:**
```bash
# Check file exists
ls -lh public/images/og-image.jpg

# Fix permissions
chmod 644 public/images/og-image.jpg

# Verify APP_URL
grep APP_URL .env

# Clear cache
php artisan config:clear
```

### Issue: Description is empty
**Possible Causes:**
1. Post has no meta_description
2. Post has no short_description
3. Post has no content

**Solution:**
The code now auto-generates descriptions, but you can manually update:
```sql
UPDATE posts 
SET meta_description = CONCAT('Latest ', title, '. Check eligibility, dates, and application process.')
WHERE meta_description IS NULL OR meta_description = '';
```

### Issue: Still showing localhost URLs
**Possible Causes:**
1. APP_URL not updated in .env
2. Config cache not cleared

**Solutions:**
```bash
# Update .env
nano .env
# Change APP_URL to https://jobone.in

# Clear cache
php artisan config:clear
php artisan cache:clear

# Verify
php artisan config:show app.url
```

### Issue: 404 on og-image.jpg
**Possible Causes:**
1. File doesn't exist
2. Wrong path
3. .htaccess blocking access

**Solutions:**
```bash
# Create image
php create-og-image.php

# Or manually place image
# Upload to: public/images/og-image.jpg

# Check .htaccess allows image access
cat public/.htaccess | grep -i "images"
```

## Success Criteria

All tests pass when:

- ✅ No localhost URLs in any meta tags
- ✅ OG image loads on all platforms
- ✅ Descriptions are never empty
- ✅ Facebook Debugger shows no errors
- ✅ WhatsApp preview works
- ✅ Telegram preview works
- ✅ Twitter card validates
- ✅ LinkedIn preview works
- ✅ Google can crawl and index
- ✅ Image file size < 300KB
- ✅ All URLs use HTTPS

## Monitoring

### Set up monitoring for:
1. Meta tag presence (use uptime monitoring)
2. OG image availability (check 200 status)
3. Social share analytics
4. Google Search Console errors

### Weekly Checks
- Review Google Search Console for meta tag issues
- Check social share counts
- Monitor 404 errors for og-image.jpg
- Review new posts have proper meta tags

## Documentation

After successful testing, document:
- Date of deployment
- Test results
- Any issues encountered
- Solutions applied
- Performance metrics

---

**Testing Complete?** 

If all tests pass, your SEO and OG image implementation is working correctly! 🎉

**Need Help?**
- See: DEPLOYMENT_SEO_FIX.md for detailed deployment steps
- See: SEO_FIX_SUMMARY.md for technical details
- See: QUICK_FIX_GUIDE.txt for quick reference
