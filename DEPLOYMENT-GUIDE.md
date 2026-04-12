# JobOne Deployment Guide

## The Problem
Every time we upload files to production, the cache needs to be cleared. Otherwise:
- Old cached data is served
- Domain filter doesn't work (karnatakajob.online shows all posts)
- New changes don't appear

## The Solution
Use the automated deployment script that handles everything.

## How to Deploy

### Option 1: Deploy Everything (Recommended)
```bash
bash deploy-to-production.sh
```

### Option 2: Deploy Specific Files
```bash
bash deploy-to-production.sh file1.php file2.blade.php
```

### Option 3: Just Clear Cache (No File Upload)
```bash
bash deploy-to-production.sh cache-only
```

### Option 4: Just Verify Sites
```bash
bash deploy-to-production.sh verify-only
```

## What the Script Does Automatically

1. **Uploads files** to production server
2. **Fixes ownership** (www-data:www-data)
3. **Sets permissions** (775 for storage, 644 for files)
4. **Clears ALL caches**:
   - Application cache
   - Config cache
   - View cache
   - Route cache
   - File cache directory
5. **Rebuilds caches** properly
6. **Restarts PHP-FPM**
7. **Verifies** both sites are working
8. **Tests** Karnataka domain filter

## Manual Deployment (If Script Fails)

If you need to deploy manually:

```bash
# 1. Upload files
scp -i "govt-job-portal-new/.ssh/jobone2026.pem" your-file.php ubuntu@3.108.161.67:/tmp/

# 2. SSH to server
ssh -i "govt-job-portal-new/.ssh/jobone2026.pem" ubuntu@3.108.161.67

# 3. Move files
sudo mv /tmp/your-file.php /var/www/jobone/path/to/file.php

# 4. Fix permissions
sudo chown -R www-data:www-data /var/www/jobone/storage /var/www/jobone/bootstrap/cache
sudo chmod -R 775 /var/www/jobone/storage /var/www/jobone/bootstrap/cache

# 5. Clear cache (IMPORTANT!)
cd /var/www/jobone
sudo rm -rf storage/framework/cache/data/*
sudo -u www-data php artisan optimize:clear
sudo -u www-data php artisan config:cache
sudo -u www-data php artisan view:cache

# 6. Restart PHP-FPM
sudo systemctl restart php8.2-fpm
```

## Why Cache Clearing is Critical

The application caches:
- **Home page sections** (10 minutes) - includes post listings
- **Config** - includes domain state filter settings
- **Views** - compiled Blade templates
- **Routes** - URL routing

When you upload new files but don't clear cache:
- Old data is still served from cache
- Domain filter config is stale
- New code doesn't run

## Preventing Future Issues

**ALWAYS** after uploading files:
1. Clear cache
2. Restart PHP-FPM
3. Verify sites are working

Or just use the deployment script - it does everything automatically!

## Quick Reference

```bash
# Deploy and verify everything
bash deploy-to-production.sh

# Just clear cache after manual upload
bash deploy-to-production.sh cache-only

# Check if sites are working
bash deploy-to-production.sh verify-only
```

## Troubleshooting

### Site shows 500 error
```bash
# Check permissions
ssh -i "govt-job-portal-new/.ssh/jobone2026.pem" ubuntu@3.108.161.67
sudo chown -R www-data:www-data /var/www/jobone/storage
sudo chmod -R 775 /var/www/jobone/storage
```

### Karnataka filter not working
```bash
# Clear cache completely
bash deploy-to-production.sh cache-only
```

### Changes not appearing
```bash
# Clear view cache
ssh -i "govt-job-portal-new/.ssh/jobone2026.pem" ubuntu@3.108.161.67
cd /var/www/jobone
sudo -u www-data php artisan view:clear
sudo -u www-data php artisan view:cache
sudo systemctl restart php8.2-fpm
```

## Server Details

- **Server IP**: 3.108.161.67
- **SSH User**: ubuntu
- **SSH Key**: govt-job-portal-new/.ssh/jobone2026.pem
- **Web Root**: /var/www/jobone
- **PHP Version**: 8.2
- **Web Server**: Nginx + PHP-FPM

## Important Files

- `/var/www/jobone/.env` - Environment configuration
- `/var/www/jobone/storage/framework/cache/` - Cache directory
- `/var/www/jobone/bootstrap/cache/` - Bootstrap cache
- `/var/www/jobone/storage/logs/laravel.log` - Error logs
