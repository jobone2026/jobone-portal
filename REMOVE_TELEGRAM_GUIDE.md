# Remove Telegram Links from Posts

## Overview
This guide helps you remove all Telegram links and references from your post content in the database.

## What Gets Removed

The script removes:
- ✅ Telegram links (t.me, telegram.me)
- ✅ Telegram channel mentions (@username)
- ✅ "Join Telegram" buttons and links
- ✅ Telegram icons and images
- ✅ Text mentions like "Join our Telegram Channel"
- ✅ Telegram-related HTML elements

## Steps to Remove Telegram Links

### Method 1: Using PHP Script (Recommended)

1. **Run the cleanup script:**
```bash
cd /var/www/jobone
php remove-telegram-links.php
```

2. **Clear cache:**
```bash
php artisan cache:clear
php artisan view:clear
```

3. **Verify changes:**
- Check a few posts on your website
- Telegram links should be gone

### Method 2: Using SQL Query (Direct Database)

If you prefer direct SQL, run this:

```sql
-- Backup first!
CREATE TABLE posts_backup AS SELECT * FROM posts;

-- Remove Telegram links
UPDATE posts 
SET content = REGEXP_REPLACE(
    REGEXP_REPLACE(
        REGEXP_REPLACE(
            content,
            '<a[^>]*href=["\']https?://(t\\.me|telegram\\.me)[^"\']*["\'][^>]*>.*?</a>',
            '',
            1, 0, 'i'
        ),
        'https?://(t\\.me|telegram\\.me)/[^\\s<>"]+',
        '',
        1, 0, 'i'
    ),
    'Join our Telegram Channel',
    '',
    1, 0, 'i'
);
```

### Method 3: Using Laravel Tinker

```bash
cd /var/www/jobone
php artisan tinker
```

Then run:
```php
use App\Models\Post;

$posts = Post::all();
$count = 0;

foreach ($posts as $post) {
    $original = $post->content;
    
    // Remove Telegram links
    $cleaned = preg_replace('/<a[^>]*href=["\']https?:\/\/(t\.me|telegram\.me)[^"\']*["\'][^>]*>.*?<\/a>/i', '', $original);
    $cleaned = preg_replace('/https?:\/\/(t\.me|telegram\.me)\/[^\s<>"]+/i', '', $cleaned);
    $cleaned = preg_replace('/Join our Telegram Channel/i', '', $cleaned);
    
    if ($cleaned !== $original) {
        $post->content = $cleaned;
        $post->save();
        $count++;
    }
}

echo "Updated {$count} posts\n";
exit;
```

## Before Running

### 1. Backup Your Database
```bash
# On server
mysqldump -u root -p govt_job_portal > backup_before_telegram_removal.sql
```

### 2. Test on One Post First
```bash
# Check one post before running on all
php artisan tinker
```
```php
$post = App\Models\Post::first();
echo $post->content;
```

## After Running

### 1. Clear All Caches
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
sudo systemctl reload nginx
```

### 2. Verify Changes
- Visit your website
- Check a few posts
- Ensure Telegram links are removed
- Ensure other content is intact

## Rollback (If Needed)

If something goes wrong:

```bash
# Restore from backup
mysql -u root -p govt_job_portal < backup_before_telegram_removal.sql

# Clear cache
php artisan cache:clear
```

## Common Issues

### Issue: Script doesn't find any Telegram links
**Solution:** Check if links are in `important_links` JSON field:
```bash
php artisan tinker
```
```php
$posts = App\Models\Post::whereNotNull('important_links')->get();
foreach ($posts as $post) {
    $links = $post->important_links;
    $filtered = array_filter($links, function($link) {
        return !preg_match('/(t\.me|telegram\.me)/i', $link['url'] ?? '');
    });
    if (count($filtered) !== count($links)) {
        $post->important_links = array_values($filtered);
        $post->save();
        echo "Updated post {$post->id}\n";
    }
}
```

### Issue: Permission denied
**Solution:**
```bash
sudo chown -R www-data:www-data /var/www/jobone
sudo chmod -R 775 /var/www/jobone/storage
```

### Issue: Some Telegram content still visible
**Solution:** Clear browser cache and check if it's in:
- Post content (HTML)
- Important links (JSON field)
- Short description
- Meta description

## Advanced: Remove from All Fields

```php
// In tinker
$posts = App\Models\Post::all();

foreach ($posts as $post) {
    // Clean content
    $post->content = preg_replace('/<a[^>]*href=["\']https?:\/\/(t\.me|telegram\.me)[^"\']*["\'][^>]*>.*?<\/a>/i', '', $post->content);
    
    // Clean short description
    $post->short_description = preg_replace('/https?:\/\/(t\.me|telegram\.me)\/[^\s<>"]+/i', '', $post->short_description);
    
    // Clean important links
    if ($post->important_links) {
        $post->important_links = array_filter($post->important_links, function($link) {
            return !preg_match('/(t\.me|telegram\.me)/i', $link['url'] ?? '');
        });
        $post->important_links = array_values($post->important_links);
    }
    
    $post->save();
}
```

## Verification Query

Check if any Telegram links remain:

```sql
-- Check content field
SELECT id, title 
FROM posts 
WHERE content LIKE '%t.me%' 
   OR content LIKE '%telegram.me%'
   OR content LIKE '%Telegram%';

-- Check important_links field
SELECT id, title, important_links 
FROM posts 
WHERE important_links LIKE '%t.me%' 
   OR important_links LIKE '%telegram.me%';
```

## Summary

1. ✅ Backup database first
2. ✅ Run `php remove-telegram-links.php`
3. ✅ Clear all caches
4. ✅ Verify on website
5. ✅ Check a few posts manually

## Support

If you encounter issues:
1. Check Laravel logs: `storage/logs/laravel.log`
2. Check database connection
3. Verify backup exists before making changes

---

**Important:** Always backup before running bulk updates!
