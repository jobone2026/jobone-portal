# 🚨 Fix Website 500 Error

Your website is showing a 500 error because the NotificationService files might not be on the server.

## Quick Fix (Run on Server)

```bash
# SSH to server
ssh ubuntu@3.108.161.67

# Go to project
cd /var/www/jobone

# Pull latest code
git pull portal main

# Force checkout notification files
git checkout HEAD -- app/Services/NotificationService.php
git checkout HEAD -- app/Console/Commands/TestNotification.php

# Clear all caches
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Restart PHP-FPM
sudo systemctl restart php8.2-fpm

# Check if website is working
curl -I https://jobone.in
```

## Alternative: Use the Fix Script

```bash
# On server
cd /var/www/jobone
git pull portal main
bash fix-website-500.sh
```

## What Caused This?

The PostController uses NotificationService, but the file might not have been pulled properly to the server. This fix ensures all notification files are present.

## Verify Files Exist

```bash
# Check if files exist
ls -la app/Services/NotificationService.php
ls -la app/Console/Commands/TestNotification.php

# Both should show the files
```

## Check Error Logs

If the issue persists, check Laravel logs:

```bash
tail -50 storage/logs/laravel.log
```

## Still Not Working?

If website still shows 500 error after running the fix:

1. Check PHP error logs:
```bash
sudo tail -50 /var/log/php8.2-fpm.log
```

2. Check nginx error logs:
```bash
sudo tail -50 /var/log/nginx/error.log
```

3. Check file permissions:
```bash
sudo chown -R www-data:www-data /var/www/jobone
sudo chmod -R 755 /var/www/jobone
sudo chmod -R 775 /var/www/jobone/storage
sudo chmod -R 775 /var/www/jobone/bootstrap/cache
```

## Emergency Rollback

If you need to rollback to before notification system:

```bash
# Go back to previous working commit
git log --oneline -10
# Find the commit before notification system
git checkout <commit-hash>

# Clear caches
php artisan config:clear
php artisan cache:clear
sudo systemctl restart php8.2-fpm
```

## Contact

If issue persists, share the error from:
```bash
tail -50 storage/logs/laravel.log
```
