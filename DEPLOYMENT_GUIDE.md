# Complete Deployment Guide

## Server Overview

### Production Server
- **IP**: 3.108.161.67
- **URL**: https://jobone.in
- **Environment**: Production
- **Database**: jobone
- **Purpose**: Live site for users

### Staging Server
- **IP**: 43.205.194.69
- **URL**: http://43.205.194.69
- **Environment**: Staging
- **Database**: jobone_staging
- **Purpose**: Testing before production

## SSH Connection

Both servers use the same SSH key:

```bash
# Connect to Production
ssh -i govt-job-portal-new/.ssh/jobone2026.pem ubuntu@3.108.161.67

# Connect to Staging
ssh -i govt-job-portal-new/.ssh/jobone2026.pem ubuntu@43.205.194.69
```

## Deployment Workflow

### Step 1: Make Changes Locally

```bash
# Make your code changes
# Test locally if possible
git add .
git commit -m "Your commit message"
git push origin main
```

### Step 2: Deploy to Staging

```bash
# Connect to staging server
ssh -i govt-job-portal-new/.ssh/jobone2026.pem ubuntu@43.205.194.69

# Navigate to project
cd /var/www/jobone

# Pull latest code
git pull origin main

# Install/update dependencies (if composer.json changed)
composer install --no-dev --optimize-autoloader

# Build frontend assets (if CSS/JS changed)
npm run build

# Run migrations (if database changed)
sudo -u www-data php artisan migrate --force

# Clear all caches
sudo -u www-data php artisan optimize:clear

# Fix permissions
sudo chown -R www-data:www-data storage bootstrap/cache public/build
```

### Step 3: Test on Staging

Visit: http://43.205.194.69

Test all changes:
- ✅ Pages load correctly
- ✅ Forms work
- ✅ No errors in browser console
- ✅ Database operations work
- ✅ Images/assets load

### Step 4: Deploy to Production

**Only after staging tests pass!**

```bash
# Connect to production server
ssh -i govt-job-portal-new/.ssh/jobone2026.pem ubuntu@3.108.161.67

# Navigate to project
cd /var/www/jobone

# Backup database first (IMPORTANT!)
sudo mysqldump -u root jobone > /var/backups/jobone/pre-deploy-$(date +%Y%m%d-%H%M%S).sql

# Pull latest code
git pull origin main

# Install/update dependencies
composer install --no-dev --optimize-autoloader

# Build frontend assets
npm run build

# Run migrations
sudo -u www-data php artisan migrate --force

# Clear all caches
sudo -u www-data php artisan optimize:clear

# Fix permissions
sudo chown -R www-data:www-data storage bootstrap/cache public/build

# Restart PHP-FPM
sudo systemctl restart php8.2-fpm
```

### Step 5: Verify Production

Visit: https://jobone.in

Quick checks:
- ✅ Homepage loads
- ✅ No 500 errors
- ✅ Recent posts visible
- ✅ Search works

## Quick Deploy Scripts

### Staging Deploy Script

Create: `~/deploy-staging.sh`

```bash
#!/bin/bash
echo "🚀 Deploying to STAGING..."

cd /var/www/jobone

# Pull code
git pull origin main

# Dependencies
composer install --no-dev --optimize-autoloader

# Build assets
npm run build

# Migrations
sudo -u www-data php artisan migrate --force

# Clear caches
sudo -u www-data php artisan optimize:clear

# Fix permissions
sudo chown -R www-data:www-data storage bootstrap/cache public/build

echo "✅ Staging deployment complete!"
echo "🌐 Test at: http://43.205.194.69"
```

Make executable:
```bash
chmod +x ~/deploy-staging.sh
```

### Production Deploy Script

Create: `~/deploy-production.sh`

```bash
#!/bin/bash
echo "⚠️  Deploying to PRODUCTION..."

read -p "Have you tested on staging? (yes/no): " confirm
if [ "$confirm" != "yes" ]; then
    echo "❌ Deployment cancelled. Test on staging first!"
    exit 1
fi

cd /var/www/jobone

# Backup database
echo "📦 Backing up database..."
sudo mysqldump -u root jobone > /var/backups/jobone/pre-deploy-$(date +%Y%m%d-%H%M%S).sql

# Pull code
git pull origin main

# Dependencies
composer install --no-dev --optimize-autoloader

# Build assets
npm run build

# Migrations
sudo -u www-data php artisan migrate --force

# Clear caches
sudo -u www-data php artisan optimize:clear

# Fix permissions
sudo chown -R www-data:www-data storage bootstrap/cache public/build

# Restart PHP-FPM
sudo systemctl restart php8.2-fpm

echo "✅ Production deployment complete!"
echo "🌐 Live at: https://jobone.in"
```

Make executable:
```bash
chmod +x ~/deploy-production.sh
```

## Common Tasks

### Clear All Caches

```bash
cd /var/www/jobone
sudo -u www-data php artisan optimize:clear
```

### View Logs

```bash
# Laravel logs
sudo tail -f /var/www/jobone/storage/logs/laravel.log

# Nginx error logs
sudo tail -f /var/log/nginx/error.log

# PHP-FPM logs
sudo tail -f /var/log/php8.2-fpm.log
```

### Restart Services

```bash
# Restart PHP-FPM
sudo systemctl restart php8.2-fpm

# Restart Nginx
sudo systemctl restart nginx

# Restart MySQL
sudo systemctl restart mysql
```

### Check Service Status

```bash
sudo systemctl status php8.2-fpm nginx mysql
```

### Database Operations

```bash
# Backup database
sudo mysqldump -u root jobone > backup-$(date +%Y%m%d).sql

# Restore database
sudo mysql jobone < backup-20260409.sql

# Access MySQL
sudo mysql

# Run migrations
sudo -u www-data php artisan migrate

# Rollback last migration
sudo -u www-data php artisan migrate:rollback
```

### Fix Permissions

```bash
cd /var/www/jobone
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

## Troubleshooting

### Site Shows 500 Error

```bash
# Check Laravel logs
sudo tail -50 /var/www/jobone/storage/logs/laravel.log

# Clear caches
sudo -u www-data php artisan optimize:clear

# Check permissions
ls -la /var/www/jobone/storage
ls -la /var/www/jobone/bootstrap/cache

# Restart PHP-FPM
sudo systemctl restart php8.2-fpm
```

### Database Connection Error

```bash
# Check MySQL is running
sudo systemctl status mysql

# Check .env file
cat /var/www/jobone/.env | grep DB_

# Test database connection
sudo -u www-data php artisan tinker
>>> DB::connection()->getPdo();
```

### Assets Not Loading

```bash
# Rebuild assets
cd /var/www/jobone
npm run build

# Check build directory
ls -la public/build/

# Clear cache
sudo -u www-data php artisan optimize:clear
```

### Git Pull Fails

```bash
# Check for local changes
git status

# Stash local changes
git stash

# Pull again
git pull origin main

# If needed, restore changes
git stash pop
```

## Emergency Procedures

### Site is Down - Quick Recovery

```bash
# 1. Check services
sudo systemctl status php8.2-fpm nginx mysql

# 2. Restart all services
sudo systemctl restart php8.2-fpm nginx mysql

# 3. Clear caches
cd /var/www/jobone
sudo -u www-data php artisan optimize:clear

# 4. Check logs
sudo tail -50 /var/www/jobone/storage/logs/laravel.log
```

### Rollback Deployment

```bash
# 1. Check git history
git log --oneline -10

# 2. Rollback to previous commit
git reset --hard <commit-hash>

# 3. Clear caches
sudo -u www-data php artisan optimize:clear

# 4. Restart services
sudo systemctl restart php8.2-fpm
```

### Restore Database Backup

```bash
# 1. List backups
ls -lh /var/backups/jobone/

# 2. Restore backup
sudo mysql jobone < /var/backups/jobone/backup-file.sql

# 3. Clear cache
sudo -u www-data php artisan optimize:clear
```

## Best Practices

### Before Every Deployment

1. ✅ Test changes locally
2. ✅ Commit with clear message
3. ✅ Push to GitHub
4. ✅ Deploy to staging first
5. ✅ Test thoroughly on staging
6. ✅ Backup production database
7. ✅ Deploy to production
8. ✅ Verify production works

### Never Do This

❌ Deploy directly to production without testing
❌ Skip database backups
❌ Make changes directly on server
❌ Forget to clear caches after deployment
❌ Deploy during high traffic hours
❌ Deploy without checking logs

### Always Do This

✅ Use staging server for testing
✅ Backup database before deployment
✅ Clear caches after deployment
✅ Check logs after deployment
✅ Test critical features after deployment
✅ Keep deployment scripts updated

## Monitoring

### Daily Checks

```bash
# Check disk space
df -h

# Check memory usage
free -h

# Check service status
sudo systemctl status php8.2-fpm nginx mysql

# Check recent errors
sudo tail -50 /var/www/jobone/storage/logs/laravel.log | grep ERROR
```

### Weekly Checks

- Review error logs
- Check database size
- Verify backups are working
- Update system packages
- Check SSL certificate expiry

## Contact Information

- **Server Provider**: AWS EC2
- **SSH Key Location**: `govt-job-portal-new/.ssh/jobone2026.pem`
- **GitHub Repo**: https://github.com/jobone2026/jobone-portal
- **Production URL**: https://jobone.in
- **Staging URL**: http://43.205.194.69

## Additional Resources

- [HIGH_AVAILABILITY_SETUP.md](HIGH_AVAILABILITY_SETUP.md) - Server protection and monitoring
- [STAGING_SERVER_SETUP.md](STAGING_SERVER_SETUP.md) - Staging server details
- [API_COMPLETE_DOCUMENTATION.md](API_COMPLETE_DOCUMENTATION.md) - API documentation
- [SERVER_CONNECTION.md](SERVER_CONNECTION.md) - SSH connection details
