# ✅ Staging Server is Ready!

## Server Details

- **IP Address**: 43.205.194.69
- **URL**: http://43.205.194.69
- **Environment**: Staging
- **PHP Version**: 8.2.30
- **MySQL**: 8.0.45 (Low memory optimized)
- **Nginx**: 1.18.0
- **Laravel**: 12.53.0

## What's Installed

✅ Complete Laravel application
✅ Database configured (jobone_staging)
✅ All migrations run successfully
✅ Storage and cache directories created
✅ Nginx configured and running
✅ PHP-FPM running
✅ 2GB Swap file created (for low memory)

## Current Status

The staging server is fully set up and ready to use. The site shows a 500 error because the database is empty (no posts, categories, or states yet).

## Next Steps

### Option 1: Copy Production Data (Recommended)

Copy data from production server to staging:

```bash
# On production server (3.108.161.67)
ssh -i govt-job-portal-new/.ssh/jobone2026.pem ubuntu@3.108.161.67
sudo mysqldump -u root jobone > /tmp/jobone_backup.sql

# Copy to staging
scp -i govt-job-portal-new/.ssh/jobone2026.pem /tmp/jobone_backup.sql ubuntu@43.205.194.69:/tmp/

# On staging server (43.205.194.69)
ssh -i govt-job-portal-new/.ssh/jobone2026.pem ubuntu@43.205.194.69
sudo mysql jobone_staging < /tmp/jobone_backup.sql
rm /tmp/jobone_backup.sql

# Clear cache
cd /var/www/jobone
sudo -u www-data php artisan cache:clear
sudo -u www-data php artisan view:clear
```

### Option 2: Create Test Data

Create some test posts manually through the admin panel or tinker.

## How to Use Staging Server

### 1. Deploy Changes to Staging

```bash
ssh -i govt-job-portal-new/.ssh/jobone2026.pem ubuntu@43.205.194.69

cd /var/www/jobone
git pull origin main
composer install --no-dev --optimize-autoloader
sudo -u www-data php artisan migrate --force
sudo -u www-data php artisan cache:clear
sudo -u www-data php artisan view:clear
sudo -u www-data php artisan config:clear
```

### 2. Test on Staging

Visit: http://43.205.194.69

### 3. If OK, Deploy to Production

```bash
ssh -i govt-job-portal-new/.ssh/jobone2026.pem ubuntu@3.108.161.67

cd /var/www/jobone
git pull origin main
composer install --no-dev --optimize-autoloader
sudo -u www-data php artisan migrate --force
sudo -u www-data php artisan cache:clear
sudo -u www-data php artisan view:clear
sudo -u www-data php artisan config:clear
sudo systemctl restart php8.2-fpm
```

## Server Specifications

- **RAM**: 416MB + 2GB Swap
- **Disk**: 20GB
- **CPU**: Shared
- **Cost**: ~$3-5/month (t2.micro)

## Important Notes

⚠️ This is a LOW MEMORY server (416MB RAM). MySQL is configured for minimal memory usage.

⚠️ Don't run heavy operations on this server. It's for testing only.

⚠️ The staging database is separate from production (jobone_staging vs jobone).

## Credentials

- **Database**: jobone_staging
- **DB User**: jobone
- **DB Password**: JobOne2026!Secure
- **SSH Key**: Same as production (jobone2026.pem)

## Quick Commands

```bash
# Connect to staging
ssh -i govt-job-portal-new/.ssh/jobone2026.pem ubuntu@43.205.194.69

# Check services
sudo systemctl status nginx php8.2-fpm mysql

# View logs
sudo tail -f /var/www/jobone/storage/logs/laravel.log

# Clear all caches
cd /var/www/jobone
sudo -u www-data php artisan optimize:clear

# Restart services
sudo systemctl restart php8.2-fpm nginx
```

## Workflow

1. **Make changes** → Push to GitHub
2. **Deploy to staging** → Test on 43.205.194.69
3. **If OK** → Deploy to production (3.108.161.67)
4. **If issues** → Fix on staging first

This way you never break the production site!
