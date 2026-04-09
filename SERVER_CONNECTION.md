# Server Connection Guide

## Server Details

- **Domain**: https://jobone.in
- **Server IP**: 3.108.161.67
- **SSH User**: ubuntu
- **SSH Key**: `.ssh/jobone2026.pem` (stored in this project)
- **Server Path**: `/var/www/jobone`
- **PHP Version**: 8.2
- **Web Server**: nginx 1.24.0
- **Database**: SQLite (database.sqlite)

## Quick Connect

### Windows (PowerShell/CMD)
```bash
ssh -i .ssh/jobone2026.pem ubuntu@3.108.161.67
```

### Linux/Mac
```bash
chmod 400 .ssh/jobone2026.pem
ssh -i .ssh/jobone2026.pem ubuntu@3.108.161.67
```

## Common Server Commands

### Connect to Server
```bash
ssh -i .ssh/jobone2026.pem ubuntu@3.108.161.67
cd /var/www/jobone
```

### Deploy Code Changes
```bash
# On server
cd /var/www/jobone
git pull
sudo chown -R www-data:www-data storage bootstrap
sudo -u www-data php artisan config:cache
sudo -u www-data php artisan view:clear
sudo systemctl restart php8.2-fpm
```

### Check Site Status
```bash
# Test site
curl -I https://jobone.in/

# Check PHP-FPM status
sudo systemctl status php8.2-fpm

# Check nginx status
sudo systemctl status nginx
```

### View Logs
```bash
# Laravel logs
tail -f /var/www/jobone/storage/logs/laravel.log

# Nginx error logs
sudo tail -f /var/log/nginx/error.log

# PHP-FPM logs
sudo tail -f /var/log/php8.2-fpm.log

# Health monitor logs
sudo tail -f /var/log/health-monitor.log

# Auto recovery logs
sudo tail -f /var/log/auto-recover.log

# Cache cleanup logs
sudo tail -f /var/log/cache-cleanup.log
```

### Restart Services
```bash
# Restart PHP-FPM
sudo systemctl restart php8.2-fpm

# Restart nginx
sudo systemctl restart nginx

# Restart both
sudo systemctl restart php8.2-fpm nginx
```

### Clear Caches
```bash
cd /var/www/jobone

# Clear all caches
sudo -u www-data php artisan cache:clear
sudo -u www-data php artisan config:clear
sudo -u www-data php artisan view:clear

# Rebuild config cache
sudo -u www-data php artisan config:cache
```

### Fix Permissions (if needed)
```bash
cd /var/www/jobone

# Fix all permissions
sudo chown -R www-data:www-data storage bootstrap
sudo chmod -R 775 storage bootstrap

# Fix log file
sudo touch storage/logs/laravel.log
sudo chown www-data:www-data storage/logs/laravel.log
sudo chmod 666 storage/logs/laravel.log
```

### Database Operations
```bash
cd /var/www/jobone

# Run migrations
php artisan migrate

# Backup database
cp database/database.sqlite database/backup-$(date +%Y%m%d-%H%M%S).sqlite

# Check database size
ls -lh database/database.sqlite
```

## File Locations

### Configuration Files
- **nginx config**: `/etc/nginx/sites-available/jobone.in`
- **PHP config**: `/etc/php/8.2/fpm/php.ini`
- **Laravel .env**: `/var/www/jobone/.env`

### Important Directories
- **Application**: `/var/www/jobone`
- **Public files**: `/var/www/jobone/public`
- **Storage**: `/var/www/jobone/storage`
- **Logs**: `/var/www/jobone/storage/logs`
- **Cache**: `/var/www/jobone/storage/framework/cache`

### Cron Jobs
```bash
# View cron jobs
sudo crontab -u www-data -l

# Edit cron jobs
sudo crontab -u www-data -e
```

Current cron jobs:
- Health monitoring: Every 5 minutes
- Auto recovery: Every 10 minutes
- Cache cleanup: Daily at 2 AM

## Maintenance Mode

### Enable Maintenance Mode
```bash
cd /var/www/jobone
php artisan down
```

### Disable Maintenance Mode
```bash
cd /var/www/jobone
php artisan up
```

### Check if in Maintenance Mode
```bash
cd /var/www/jobone
php artisan | grep -i down
# Or check for storage/framework/down file
ls -la storage/framework/down
```

## API Configuration

### API Token
- **Location**: `.env` file
- **Config**: `config/api.php`
- **Current Token**: `jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a`

### Test API
```bash
# Test public endpoint
curl https://jobone.in/api/categories

# Test authenticated endpoint
curl -H "Authorization: Bearer jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a" \
  "https://jobone.in/api/posts?limit=1"
```

## Troubleshooting

### Site Down (500 Error)
```bash
# Check logs
tail -50 /var/www/jobone/storage/logs/laravel.log

# Fix common issues
cd /var/www/jobone
sudo mkdir -p bootstrap/cache storage/framework/{cache,views,sessions}
sudo chown -R www-data:www-data storage bootstrap
sudo -u www-data php artisan config:cache
sudo systemctl restart php8.2-fpm
```

### Memory Issues
```bash
# Check PHP memory limit
grep memory_limit /etc/php/8.2/fpm/php.ini

# Current setting: 1024M
```

### Cache Issues
```bash
# Check cache size
du -sh /var/www/jobone/storage/framework/cache

# Clean cache manually
cd /var/www/jobone
php artisan cache:cleanup --max-size=100
```

### Permission Issues
```bash
# Always run artisan commands as www-data
sudo -u www-data php artisan [command]

# Fix ownership
sudo chown -R www-data:www-data /var/www/jobone
```

## Security Notes

⚠️ **IMPORTANT**: 
- The `.ssh/jobone2026.pem` file contains the private key
- Add `.ssh/` to `.gitignore` to prevent committing the key
- Never share the PEM key publicly
- Keep file permissions: `chmod 400 .ssh/jobone2026.pem`

## Quick Reference Commands

```bash
# Connect
ssh -i .ssh/jobone2026.pem ubuntu@3.108.161.67

# Deploy
cd /var/www/jobone && git pull && sudo chown -R www-data:www-data . && sudo systemctl restart php8.2-fpm

# Check status
curl -I https://jobone.in/

# View logs
sudo tail -f /var/log/health-monitor.log

# Emergency fix
cd /var/www/jobone && sudo chown -R www-data:www-data storage bootstrap && sudo -u www-data php artisan config:cache && sudo systemctl restart php8.2-fpm nginx
```

## Automated Systems

### Health Monitoring
- **Command**: `php artisan health:monitor`
- **Schedule**: Every 5 minutes
- **Log**: `/var/log/health-monitor.log`
- **Action**: Enables maintenance mode on critical errors

### Auto Recovery
- **Command**: `php artisan health:recover`
- **Schedule**: Every 10 minutes
- **Log**: `/var/log/auto-recover.log`
- **Action**: Fixes common issues and disables maintenance mode

### Cache Cleanup
- **Command**: `php artisan cache:cleanup --max-size=100`
- **Schedule**: Daily at 2 AM
- **Log**: `/var/log/cache-cleanup.log`
- **Action**: Cleans cache when it exceeds 100MB

## Contact & Support

For server issues:
1. Check logs first
2. Try auto-recovery: `php artisan health:recover`
3. Check this documentation
4. Review error messages in Laravel logs

---

**Last Updated**: April 9, 2026
**Maintained By**: Development Team
