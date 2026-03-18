# Karnataka Domain Setup - Quick Guide

## Overview
Your `karnatakajob.online` domain will now automatically show ONLY Karnataka-related jobs, while `jobone.in` continues to show all states.

## What Was Changed

### 1. New Middleware
- Created `app/Http/Middleware/DomainStateFilter.php`
- Automatically detects domain and applies state filtering
- Registered in `bootstrap/app.php`

### 2. Updated Controllers
All controllers now respect domain-based filtering:
- `HomeController` - Homepage sections
- `PostController` - Job listings, load more
- `SearchController` - Search and autocomplete
- `CategoryController` - Category pages

### 3. Configuration
Added to `.env`:
```env
DOMAIN_STATE_MAP=karnatakajob.online:karnataka,www.karnatakajob.online:karnataka
```

## Deployment Steps

### On Your Server:

1. **Pull the changes:**
   ```bash
   cd /path/to/govt-job-portal-new
   git pull origin main
   ```

2. **Update .env file:**
   ```bash
   nano .env
   ```
   Add this line:
   ```
   DOMAIN_STATE_MAP=karnatakajob.online:karnataka,www.karnatakajob.online:karnataka
   ```

3. **Clear caches:**
   ```bash
   php artisan config:clear
   php artisan cache:clear
   php artisan view:clear
   ```

4. **Restart PHP-FPM:**
   ```bash
   sudo systemctl restart php8.2-fpm
   # or
   sudo systemctl restart php-fpm
   ```

5. **Verify Karnataka state exists in database:**
   ```bash
   php artisan tinker
   ```
   Then run:
   ```php
   \App\Models\State::where('slug', 'karnataka')->first();
   ```
   If null, create it:
   ```php
   \App\Models\State::create(['name' => 'Karnataka', 'slug' => 'karnataka']);
   ```

## DNS Configuration

Point your domain to the server:

**For karnatakajob.online:**
- A Record: `@` → Your server IP
- A Record: `www` → Your server IP

**Nginx Configuration:**

Add to your nginx config:
```nginx
server {
    listen 80;
    server_name karnatakajob.online www.karnatakajob.online;
    
    root /path/to/govt-job-portal-new/public;
    index index.php;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

Then:
```bash
sudo nginx -t
sudo systemctl reload nginx
```

## Testing

1. **Test karnatakajob.online:**
   - Visit `http://karnatakajob.online`
   - Should show ONLY Karnataka jobs
   - Check homepage, job listings, search

2. **Test jobone.in:**
   - Visit `http://jobone.in`
   - Should show ALL states (no filtering)

3. **Test jobone.in/state/karnataka:**
   - Should still work as before
   - Shows Karnataka via URL routing

## Verification Checklist

- [ ] Domain DNS points to server
- [ ] Nginx configured for karnatakajob.online
- [ ] .env has DOMAIN_STATE_MAP configured
- [ ] Caches cleared
- [ ] PHP-FPM restarted
- [ ] Karnataka state exists in database
- [ ] karnatakajob.online shows only Karnataka posts
- [ ] jobone.in shows all posts

## Troubleshooting

**Problem:** karnatakajob.online shows all states
- Check .env has correct DOMAIN_STATE_MAP
- Run: `php artisan config:clear`
- Verify state slug is exactly 'karnataka' (lowercase)

**Problem:** 404 errors
- Check nginx configuration
- Verify document root path
- Check file permissions

**Problem:** No posts showing
- Verify Karnataka state has posts in database
- Check: `SELECT COUNT(*) FROM posts WHERE state_id = (SELECT id FROM states WHERE slug = 'karnataka');`

## Adding More Domains

To add more state-specific domains, update .env:
```env
DOMAIN_STATE_MAP=karnatakajob.online:karnataka,maharashtrajobs.com:maharashtra,delhijobs.in:delhi
```

Then clear cache and restart PHP-FPM.

## Support

For detailed documentation, see `DOMAIN_STATE_FILTERING.md`
