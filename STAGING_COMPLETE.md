# ✅ Staging Server Setup Complete!

## Server Information

- **IP Address**: 43.205.194.69
- **Main Site**: http://43.205.194.69/
- **Jobscrap Tool**: http://43.205.194.69/jobscrap/
- **Environment**: Staging
- **SSH Key**: jobone2026.pem (same as production)

## What's Working

✅ Main Laravel application
✅ Database (jobone_staging)
✅ Frontend assets (Vite build)
✅ Jobscrap tool with AI content enhancer
✅ All API endpoints
✅ Low memory optimization (416MB RAM + 2GB swap)

## Server Specs

- **RAM**: 416MB + 2GB Swap
- **Disk**: 20GB
- **PHP**: 8.2.30
- **MySQL**: 8.0.45 (low memory optimized)
- **Node.js**: 20.20.2
- **Nginx**: 1.18.0

## Credentials

### Database
- **Database**: jobone_staging
- **User**: jobone
- **Password**: JobOne2026!Secure

### API
- **Token**: jobone_sk_live_8f7c9e2d4a1b6f3c5e9a2b7d4f1c8e3a
- **AgentRouter Key**: sk-rNcRTuLbvWAO9bZnFO45OaGIQQgeGRqSIvpARyUxlQpdTSYd

## Your Workflow

### 1. Test Changes on Staging

```bash
# Connect to staging
ssh -i govt-job-portal-new/.ssh/jobone2026.pem ubuntu@43.205.194.69

# Deploy Laravel changes
cd /var/www/jobone
git pull origin main
composer install --no-dev --optimize-autoloader
npm run build
sudo -u www-data php artisan migrate --force
sudo -u www-data php artisan optimize:clear

# Deploy Jobscrap changes
cd /var/www/jobone/public/jobscrap
git pull origin main
```

### 2. Test on Staging

- Main site: http://43.205.194.69/
- Jobscrap: http://43.205.194.69/jobscrap/
- API: http://43.205.194.69/api/posts

### 3. Deploy to Production (if staging works)

```bash
# Connect to production
ssh -i govt-job-portal-new/.ssh/jobone2026.pem ubuntu@3.108.161.67

# Deploy Laravel changes
cd /var/www/jobone
git pull origin main
composer install --no-dev --optimize-autoloader
npm run build
sudo -u www-data php artisan migrate --force
sudo -u www-data php artisan optimize:clear
sudo systemctl restart php8.2-fpm

# Deploy Jobscrap changes
cd /var/www/jobone/public/jobscrap
git pull origin main
```

## Quick Commands

### Connect to Servers

```bash
# Staging
ssh -i govt-job-portal-new/.ssh/jobone2026.pem ubuntu@43.205.194.69

# Production
ssh -i govt-job-portal-new/.ssh/jobone2026.pem ubuntu@3.108.161.67
```

### Check Services

```bash
sudo systemctl status nginx php8.2-fpm mysql
```

### View Logs

```bash
# Laravel logs
sudo tail -f /var/www/jobone/storage/logs/laravel.log

# Nginx error log
sudo tail -f /var/log/nginx/error.log

# PHP-FPM log
sudo tail -f /var/log/php8.2-fpm.log
```

### Clear Caches

```bash
cd /var/www/jobone
sudo -u www-data php artisan optimize:clear
```

### Restart Services

```bash
sudo systemctl restart php8.2-fpm nginx
```

## Important Notes

⚠️ **Low Memory Server**: The staging server has only 416MB RAM. Don't run heavy operations.

⚠️ **Separate Database**: Staging uses `jobone_staging` database, production uses `jobone`.

⚠️ **Empty Database**: The staging database is empty. You can copy production data if needed:

```bash
# On production
sudo mysqldump -u root jobone > /tmp/jobone_backup.sql
scp -i govt-job-portal-new/.ssh/jobone2026.pem /tmp/jobone_backup.sql ubuntu@43.205.194.69:/tmp/

# On staging
sudo mysql jobone_staging < /tmp/jobone_backup.sql
rm /tmp/jobone_backup.sql
```

## Benefits

✅ Test all changes safely before production
✅ Catch errors before users see them
✅ No more production downtime
✅ Separate environment for experiments
✅ Same setup as production (except data)

## Next Steps

1. Test the staging site: http://43.205.194.69/
2. Test jobscrap tool: http://43.205.194.69/jobscrap/
3. Make a change and test the workflow
4. Deploy to production when confident

Your staging server is ready to use! 🚀
