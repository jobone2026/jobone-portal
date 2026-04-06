# Fix Cache Headers and Server Permissions

## Problem
Your static assets (CSS, JS, images) are not being cached by browsers, causing slower repeat visits. Also, there are permission issues preventing git operations.

## Solution Steps

### Step 1: Fix Permission Issues
```bash
cd /var/www/jobone

# Fix ownership of all files
sudo chown -R ubuntu:ubuntu .

# Fix specific Laravel directories
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

### Step 2: Pull Latest Code
```bash
cd /var/www/jobone

# Reset any local changes and pull
git fetch origin
git reset --hard origin/main

# Clear Laravel caches
php artisan view:clear
sudo php artisan cache:clear
```

### Step 3: Apply Cache Headers to Nginx

Option A - Automatic (Recommended):
```bash
cd /var/www/jobone
sudo bash setup-cache.sh
```

Option B - Manual:
```bash
# Backup current config
sudo cp /etc/nginx/sites-available/jobone.in /etc/nginx/sites-available/jobone.in.backup

# Edit the config
sudo nano /etc/nginx/sites-available/jobone.in
```

Add these lines BEFORE the closing `}` of your server block:

```nginx
    # Cache static assets for 1 year
    location ~* \.(css|js|jpg|jpeg|png|gif|ico|svg|webp|woff|woff2|ttf|eot|otf)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
        access_log off;
    }

    # Cache build assets (Vite compiled files) for 1 year
    location ~* ^/build/.*\.(css|js|map)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
        access_log off;
    }

    # Cache images for 1 month
    location ~* ^/images/.*\.(jpg|jpeg|png|gif|svg|webp|ico)$ {
        expires 1M;
        add_header Cache-Control "public";
        access_log off;
    }

    # Don't cache HTML files
    location ~* \.html$ {
        expires -1;
        add_header Cache-Control "no-cache, no-store, must-revalidate";
    }
```

Then test and reload:
```bash
sudo nginx -t
sudo systemctl reload nginx
```

### Step 4: Verify Cache Headers
After applying, test with:
```bash
curl -I https://jobone.in/build/assets/css/app-e746hp_G.css | grep -i cache
```

You should see:
```
Cache-Control: public, immutable
Expires: [date 1 year in future]
```

## Expected Results
- CSS/JS files: Cached for 1 year (saves 185 KiB on repeat visits)
- Images: Cached for 1 month
- HTML: Not cached (always fresh)
- Faster page loads for returning visitors
- Better Google PageSpeed scores

## What This Fixes
The browser cache issue you're seeing in PageSpeed Insights where it says:
"Use efficient cache lifetimes - Est savings of 185 KiB"

After applying these changes, those assets will be cached properly and the warning will disappear.
