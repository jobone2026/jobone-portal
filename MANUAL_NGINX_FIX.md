# Manual Nginx Cache Fix

The automatic script didn't work properly. Here's the manual fix:

## Step 1: Edit Nginx Config

```bash
sudo nano /etc/nginx/sites-available/jobone.in
```

## Step 2: Add These Lines

Find your `server {` block and add these location blocks BEFORE the `location / {` line:

```nginx
    # Cache static assets for 1 year
    location ~* \.(css|js|woff|woff2|ttf|eot|otf)$ {
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
    location ~* \.(jpg|jpeg|png|gif|svg|webp|ico)$ {
        expires 1M;
        add_header Cache-Control "public, max-age=2592000";
        access_log off;
    }

    # Don't cache HTML files
    location ~* \.html$ {
        expires -1;
        add_header Cache-Control "no-cache, no-store, must-revalidate";
    }
```

## Step 3: Test and Reload

```bash
sudo nginx -t
sudo systemctl reload nginx
```

## Step 4: Verify

```bash
curl -I https://jobone.in/build/assets/css/app-e746hp_G.css | grep -i cache
```

You should see:
```
Cache-Control: public, immutable
Expires: [date 1 year in future]
```

## Example Nginx Config Structure

Your config should look like this:

```nginx
server {
    listen 80;
    server_name jobone.in www.jobone.in;
    
    root /var/www/jobone/public;
    index index.php index.html;

    # ADD CACHE BLOCKS HERE (before location /)
    
    location ~* \.(css|js|woff|woff2|ttf|eot|otf)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
        access_log off;
    }

    location ~* ^/build/.*\.(css|js|map)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
        access_log off;
    }

    location ~* \.(jpg|jpeg|png|gif|svg|webp|ico)$ {
        expires 1M;
        add_header Cache-Control "public, max-age=2592000";
        access_log off;
    }

    # THEN your main location block
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    # ... rest of your config
}
```

## Why This Matters

Without cache headers:
- Browsers download 185 KiB on EVERY page visit
- Slower page loads
- Higher server bandwidth usage

With cache headers:
- Browsers cache files for 1 year
- Only download once
- Much faster repeat visits
- Better PageSpeed scores
