# Automatic Cache Cleanup Setup

## Problem Solved
Prevents cache files from growing too large and causing 500 errors.

## Solution: Automatic Cache Cleanup

### Step 1: Add Cleanup Command
The command is already created at: `app/Console/Commands/CleanupCache.php`

### Step 2: Test the Command
```bash
cd /var/www/jobone

# Test cleanup (max 100MB)
php artisan cache:cleanup --max-size=100

# Or with custom size
php artisan cache:cleanup --max-size=50
```

### Step 3: Add to Cron (Automatic Daily Cleanup)

Edit crontab:
```bash
sudo crontab -e
```

Add this line (runs daily at 2 AM):
```
0 2 * * * cd /var/www/jobone && php artisan cache:cleanup --max-size=100 >> /var/log/cache-cleanup.log 2>&1
```

Or add to www-data crontab:
```bash
sudo crontab -u www-data -e
```

Add:
```
0 2 * * * cd /var/www/jobone && php artisan cache:cleanup --max-size=100
```

### Step 4: Verify Cron is Working
```bash
# Check if cron is running
sudo service cron status

# View cron logs
sudo tail -20 /var/log/cache-cleanup.log
```

## What This Does

✅ **Runs daily at 2 AM** - Automatically cleans cache
✅ **Keeps cache under 100MB** - Prevents memory issues
✅ **Deletes old files first** - Preserves recent cache
✅ **Removes files >10MB** - Prevents huge individual files
✅ **Logs all actions** - Track cleanup history

## Manual Cleanup Commands

```bash
# Quick cleanup
php artisan cache:cleanup

# Aggressive cleanup (50MB max)
php artisan cache:cleanup --max-size=50

# View cache size
du -sh /var/www/jobone/storage/framework/cache/data/

# Emergency: Delete all cache
rm -rf /var/www/jobone/storage/framework/cache/data/*
php artisan cache:clear
```

## Monitoring

Check cache size regularly:
```bash
# Check current cache size
du -sh /var/www/jobone/storage/framework/cache/data/

# Find largest cache files
du -sh /var/www/jobone/storage/framework/cache/data/* | sort -rh | head -10
```

## PHP Memory Settings

Also increase PHP memory limit to handle larger requests:

```bash
# Edit PHP config
sudo nano /etc/php/8.2/fpm/php.ini

# Change this line:
memory_limit = 128M

# To:
memory_limit = 512M

# Save and restart
sudo systemctl restart php8.2-fpm
```

## Nginx Configuration

Add to `/etc/nginx/sites-available/jobone.in` to prevent large uploads:

```nginx
# Limit request body size
client_max_body_size 50M;

# Limit cache headers
proxy_cache_valid 200 10m;
proxy_cache_valid 404 1m;
```

## Future Prevention

1. ✅ Cache cleanup runs daily
2. ✅ PHP memory increased to 512MB
3. ✅ Large files automatically deleted
4. ✅ Cache size monitored

This prevents the 500 error from happening again!
