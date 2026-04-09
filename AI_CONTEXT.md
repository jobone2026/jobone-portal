# AI Assistant Context - JobOne.in Project

This file helps AI assistants quickly understand the project setup and common operations.

## Project Overview

**Site**: https://jobone.in - Government job portal for India  
**Tech Stack**: Laravel 11, PHP 8.2, SQLite, nginx  
**Server**: AWS EC2 (3.108.161.67)

## Quick Server Access

```bash
# SSH Key Location: .ssh/jobone2026.pem (in project root)
ssh -i .ssh/jobone2026.pem ubuntu@3.108.161.67
cd /var/www/jobone
```

## Common Issues & Fixes

### 1. Site Down (500 Error)
**Cause**: Usually bootstrap/cache or storage permissions  
**Fix**:
```bash
ssh -i .ssh/jobone2026.pem ubuntu@3.108.161.67 "cd /var/www/jobone && sudo mkdir -p bootstrap/cache storage/framework/{cache,views,sessions} && sudo chown -R www-data:www-data storage bootstrap && sudo -u www-data php artisan config:cache && sudo systemctl restart php8.2-fpm"
```

### 2. API Returns "Unauthorized"
**Cause**: Config cache not updated after .env changes  
**Fix**:
```bash
ssh -i .ssh/jobone2026.pem ubuntu@3.108.161.67 "cd /var/www/jobone && sudo -u www-data php artisan config:cache && sudo systemctl restart php8.2-fpm"
```

### 3. Memory Exhausted
**Cause**: Cache files too large  
**Fix**:
```bash
ssh -i .ssh/jobone2026.pem ubuntu@3.108.161.67 "cd /var/www/jobone && php artisan cache:cleanup --max-size=100"
```

### 4. Permission Denied
**Cause**: Wrong file ownership  
**Fix**:
```bash
ssh -i .ssh/jobone2026.pem ubuntu@3.108.161.67 "cd /var/www/jobone && sudo chown -R www-data:www-data storage bootstrap"
```

## Deployment Workflow

```bash
# 1. Connect to server
ssh -i .ssh/jobone2026.pem ubuntu@3.108.161.67

# 2. Navigate to project
cd /var/www/jobone

# 3. Pull latest code
git pull

# 4. Fix permissions
sudo chown -R www-data:www-data storage bootstrap

# 5. Clear caches
sudo -u www-data php artisan config:cache
sudo -u www-data php artisan view:clear

# 6. Restart services
sudo systemctl restart php8.2-fpm
```

## Important File Paths

### On Server
- **Application**: `/var/www/jobone`
- **nginx config**: `/etc/nginx/sites-available/jobone.in`
- **PHP config**: `/etc/php/8.2/fpm/php.ini`
- **Logs**: `/var/www/jobone/storage/logs/laravel.log`

### In Project
- **SSH Key**: `.ssh/jobone2026.pem`
- **API Config**: `config/api.php`
- **Routes**: `routes/web.php`, `routes/api.php`
- **Controllers**: `app/Http/Controllers/`

## Key Configuration

### Environment Variables (.env on server)
```env
APP_URL=https://jobone.in
API_TOKEN=jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a
DB_CONNECTION=sqlite
```

### PHP Settings
- **Memory Limit**: 1024M (was 128M, increased to prevent crashes)
- **Max Execution Time**: 300s

### Cron Jobs (www-data user)
- Health monitor: `*/5 * * * *` (every 5 min)
- Auto recovery: `*/10 * * * *` (every 10 min)
- Cache cleanup: `0 2 * * *` (daily 2 AM)

## Automated Systems

### Health Monitoring
- **File**: `app/Console/Commands/MonitorHealth.php`
- **Action**: Detects critical errors, enables maintenance mode
- **Log**: `/var/log/health-monitor.log`

### Auto Recovery
- **File**: `app/Console/Commands/AutoRecover.php`
- **Action**: Fixes common issues, disables maintenance mode
- **Log**: `/var/log/auto-recover.log`

### Cache Cleanup
- **File**: `app/Console/Commands/CleanupCache.php`
- **Action**: Cleans cache when > 100MB
- **Log**: `/var/log/cache-cleanup.log`

## API Authentication

### Public Endpoints (No Auth)
- `GET /api/categories`
- `GET /api/states`

### Protected Endpoints (Bearer Token)
- `GET /api/posts`
- `POST /api/posts`
- `PUT /api/posts/{id}`
- `DELETE /api/posts/{id}`

### Test API
```bash
curl -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a" \
  "https://jobone.in/api/posts?limit=1"
```

## Critical Rules for AI

1. **Always use `sudo -u www-data`** for artisan commands
2. **Never use `env()` in code** - use `config()` instead (env() returns null when cached)
3. **Always fix permissions** after git operations
4. **Never delete `bootstrap/cache` directory** - only delete files inside
5. **Always restart PHP-FPM** after config changes
6. **Use full SSH command** with key path from project root

## Testing Commands

```bash
# Test site is up
curl -I https://jobone.in/

# Test API
curl https://jobone.in/api/categories

# Check PHP-FPM
sudo systemctl status php8.2-fpm

# Check nginx
sudo systemctl status nginx

# View recent errors
tail -50 /var/www/jobone/storage/logs/laravel.log
```

## Emergency Recovery

If site is completely down:
```bash
ssh -i .ssh/jobone2026.pem ubuntu@3.108.161.67 "cd /var/www/jobone && sudo mkdir -p bootstrap/cache storage/framework/{cache,views,sessions} storage/logs && sudo chown -R www-data:www-data storage bootstrap && sudo touch storage/logs/laravel.log && sudo chown www-data:www-data storage/logs/laravel.log && sudo chmod 666 storage/logs/laravel.log && sudo -u www-data php artisan config:clear && sudo -u www-data php artisan cache:clear && sudo -u www-data php artisan view:clear && sudo -u www-data php artisan config:cache && sudo systemctl restart php8.2-fpm nginx && curl -I https://jobone.in/"
```

## Documentation Files

- **SERVER_CONNECTION.md** - Detailed server access guide
- **AUTO_MAINTENANCE_SETUP.md** - Auto-maintenance system docs
- **CACHE_CLEANUP_SETUP.md** - Cache cleanup system docs
- **API_COMPLETE_DOCUMENTATION.md** - Full API documentation

## Previous Issues Resolved

1. ✅ Cache headers not working → Fixed nginx config
2. ✅ Memory exhausted (128MB) → Increased to 1024MB
3. ✅ Cache growing too large → Added auto-cleanup
4. ✅ Bootstrap/cache deleted → Added auto-recovery
5. ✅ API unauthorized error → Changed env() to config()

---

**For AI Assistants**: When user reports server issues, check logs first, then apply relevant fix from "Common Issues & Fixes" section above.
