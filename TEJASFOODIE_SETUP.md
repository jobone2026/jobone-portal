# Tejas Foodie Domain Setup Guide

This guide will help you set up `tejasfoodie.store` with SSL on your server.

## Overview

- Domain: `tejasfoodie.store`
- Type: Standalone HTML landing page
- SSL: Let's Encrypt (Free)
- No connection to jobone.in or karnatakajob.one

## Files Created

1. `app/Http/Middleware/TejasFoodieMiddleware.php` - Middleware to handle tejasfoodie.store requests
2. `public/tejasfoodie.html` - Landing page HTML
3. `tejasfoodie-nginx.conf` - Nginx configuration with SSL
4. `bootstrap/app.php` - Updated to include TejasFoodie middleware

## Setup Steps

### 1. Point Domain to Your Server

First, update your DNS records for `tejasfoodie.store`:

```
A Record: tejasfoodie.store → Your Server IP
A Record: www.tejasfoodie.store → Your Server IP
```

Wait for DNS propagation (5-30 minutes).

### 2. Install Certbot (if not already installed)

```bash
sudo apt update
sudo apt install certbot python3-certbot-nginx -y
```

### 3. Copy Nginx Configuration

```bash
# Copy the nginx config
sudo cp tejasfoodie-nginx.conf /etc/nginx/sites-available/tejasfoodie.store

# Create symbolic link
sudo ln -s /etc/nginx/sites-available/tejasfoodie.store /etc/nginx/sites-enabled/

# Test nginx configuration
sudo nginx -t
```

### 4. Obtain SSL Certificate

```bash
# Get SSL certificate from Let's Encrypt
sudo certbot --nginx -d tejasfoodie.store -d www.tejasfoodie.store

# Follow the prompts:
# - Enter your email
# - Agree to terms
# - Choose whether to redirect HTTP to HTTPS (recommended: Yes)
```

### 5. Reload Nginx

```bash
sudo systemctl reload nginx
```

### 6. Test the Setup

Visit these URLs:
- http://tejasfoodie.store (should redirect to HTTPS)
- https://tejasfoodie.store (should show landing page)
- https://www.tejasfoodie.store (should show landing page)

### 7. Auto-Renewal Setup

Certbot automatically sets up SSL renewal. Test it:

```bash
# Test renewal
sudo certbot renew --dry-run

# Check renewal timer
sudo systemctl status certbot.timer
```

## Customizing the Landing Page

Edit `public/tejasfoodie.html` to customize:
- Logo/emoji
- Title and text
- Colors and styling
- Add contact information
- Add social media links

## Troubleshooting

### Issue: 502 Bad Gateway
```bash
# Check PHP-FPM is running
sudo systemctl status php8.2-fpm

# Restart if needed
sudo systemctl restart php8.2-fpm
```

### Issue: SSL Certificate Error
```bash
# Check certificate status
sudo certbot certificates

# Renew manually if needed
sudo certbot renew --force-renewal
```

### Issue: Page not loading
```bash
# Check nginx error logs
sudo tail -f /var/log/nginx/tejasfoodie-error.log

# Check nginx access logs
sudo tail -f /var/log/nginx/tejasfoodie-access.log
```

### Issue: Shows job portal instead of landing page
```bash
# Clear Laravel cache
cd /var/www/govt-job-portal-new
php artisan cache:clear
php artisan config:clear
php artisan route:clear
```

## Important Notes

1. This domain is completely separate from jobone.in and karnatakajob.one
2. The middleware intercepts requests early, so no job portal code runs
3. SSL certificates auto-renew every 90 days
4. The landing page is static HTML (no database required)
5. You can edit the HTML file directly without affecting other domains

## Quick Deploy Command

```bash
cd /var/www/govt-job-portal-new
git pull origin main
sudo systemctl reload nginx
```

## Security

- SSL/TLS encryption enabled
- Security headers configured
- Hidden files protected
- Automatic HTTPS redirect

## Support

If you need to modify the landing page, edit:
`/var/www/govt-job-portal-new/public/tejasfoodie.html`

Then reload nginx:
```bash
sudo systemctl reload nginx
```
