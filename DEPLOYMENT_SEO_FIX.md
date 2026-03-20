# SEO & OG Image Fix - Deployment Guide

## Issues Fixed

1. ✅ Meta descriptions now have proper fallback logic
2. ✅ OG images use absolute URLs
3. ✅ Added proper OG meta tags (image dimensions, alt text, locale)
4. ✅ Enhanced Twitter card meta tags

## Required Actions on Server

### 1. Update APP_URL in .env

**CRITICAL**: Change the APP_URL from localhost to your actual domain:

```bash
# Edit .env file on server
nano .env

# Change this line:
APP_URL=http://localhost:8000

# To your actual domain:
APP_URL=https://jobone.in
```

After changing, clear the config cache:
```bash
php artisan config:clear
php artisan cache:clear
```

### 2. Create OG Image

You need to create an OG (Open Graph) image at: `public/images/og-image.jpg`

**Specifications:**
- Size: 1200x630 pixels (required for Facebook, WhatsApp, Telegram)
- Format: JPG or PNG
- File name: `og-image.jpg`
- Location: `public/images/og-image.jpg`

**Content suggestions:**
- JobOne.in logo (centered or top)
- Tagline: "Latest Government Jobs 2026"
- Professional gradient background (blue/green)
- Clean, readable text

**Tools to create:**
1. **Canva** (easiest): https://www.canva.com/create/open-graph/
2. **Photoshop/GIMP**: Create 1200x630 canvas
3. **Online generators**: Search "OG image generator"

**Quick option**: Use the existing logo:
```bash
# If you have ImageMagick installed on server
convert public/images/jobone-logo.png -resize 1200x630 -gravity center -background "#1e3a8a" -extent 1200x630 public/images/og-image.jpg
```

### 3. Test Meta Tags

After deployment, test your meta tags:

**Test URLs:**
1. Facebook Debugger: https://developers.facebook.com/tools/debug/
2. Twitter Card Validator: https://cards-dev.twitter.com/validator
3. LinkedIn Post Inspector: https://www.linkedin.com/post-inspector/
4. WhatsApp: Just share a link in WhatsApp

**Clear cache on these platforms:**
- Facebook: Use the debugger and click "Scrape Again"
- WhatsApp: They cache for 7 days, use Facebook debugger to force refresh
- Telegram: Usually updates within minutes

### 4. Verify on Server

```bash
# Check if og-image.jpg exists
ls -lh public/images/og-image.jpg

# Check APP_URL is correct
grep APP_URL .env

# Clear all caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

### 5. Test Individual Posts

Make sure posts have meta descriptions:
```sql
-- Check posts without meta_description
SELECT id, title, meta_description FROM posts WHERE meta_description IS NULL OR meta_description = '' LIMIT 10;

-- Update posts with auto-generated descriptions (optional)
UPDATE posts 
SET meta_description = CONCAT('Latest ', type, ' notification for ', title, '. Check details, eligibility, and important dates.')
WHERE meta_description IS NULL OR meta_description = '';
```

## Verification Checklist

- [ ] APP_URL is set to https://jobone.in in .env
- [ ] og-image.jpg exists at public/images/og-image.jpg (1200x630px)
- [ ] Config cache cleared
- [ ] Tested homepage on Facebook Debugger
- [ ] Tested a post page on Facebook Debugger
- [ ] WhatsApp preview shows image and description
- [ ] Telegram preview shows image and description
- [ ] Google Search Console shows proper descriptions

## Common Issues

### Issue: Still showing localhost URLs
**Solution**: Clear config cache: `php artisan config:clear`

### Issue: Old image/description cached
**Solution**: Use Facebook Debugger "Scrape Again" button

### Issue: Image not showing
**Solution**: 
1. Check file exists: `ls public/images/og-image.jpg`
2. Check file permissions: `chmod 644 public/images/og-image.jpg`
3. Verify URL is absolute (starts with https://)

### Issue: Description is empty
**Solution**: Posts need either `meta_description`, `short_description`, or `content` filled

## Files Modified

1. `app/Services/SeoService.php` - Enhanced description fallback logic
2. `resources/views/components/seo-head.blade.php` - Added proper OG meta tags
3. `public/images/og-image.jpg` - **YOU NEED TO CREATE THIS**

## Notes

- The system now automatically falls back to a default description if post has none
- OG images use post images when available, otherwise default og-image.jpg
- All URLs are now absolute (include domain)
- Image dimensions are specified for better rendering
