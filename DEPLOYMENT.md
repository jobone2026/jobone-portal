# JobOne.in - Deployment Guide

Complete guide for deploying the Government Job Portal to AWS Ubuntu VPS.

## Table of Contents
1. [Prerequisites](#prerequisites)
2. [Server Setup](#server-setup)
3. [Application Deployment](#application-deployment)
4. [Post-Deployment Configuration](#post-deployment-configuration)
5. [Maintenance](#maintenance)

---

## Prerequisites

### Local Requirements
- Git installed
- SSH client
- GitHub/GitLab account

### AWS Requirements
- AWS Account
- EC2 Instance (Ubuntu 22.04 LTS)
- Recommended: t3.medium (2 vCPU, 4GB RAM) for 10k users
- Security Group with ports: 22 (SSH), 80 (HTTP), 443 (HTTPS)
- Elastic IP (optional but recommended)

---

## Server Setup

### 1. Connect to Your Server

```bash
ssh ubuntu@your-server-ip
```

### 2. Update System

```bash
sudo apt update && sudo apt upgrade -y
```

### 3. Install LEMP Stack

#### Install Nginx
```bash
sudo apt install nginx -y
sudo systemctl start nginx
sudo systemctl enable nginx
```

#### Install PHP 8.2
```bash
sudo apt install software-properties-common -y
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update
sudo apt install php8.2-fpm php8.2-cli php8.2-common php8.2-mysql \
  php8.2-zip php8.2-gd php8.2-mbstring php8.2-curl php8.2-xml \
  php8.2-bcmath php8.2-intl php8.2-redis -y
```

#### Install MySQL 8.0
```bash
sudo apt install mysql-server -y
sudo systemctl start mysql
sudo systemctl enable mysql
sudo mysql_secure_installation
```

### 4. Install Additional Tools

```bash
# Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Node.js & NPM
curl -fsSL https://deb.nodesource.com/setup_20.x | sudo -E bash -
sudo apt install nodejs -y

# Git
sudo apt install git -y

# Supervisor (for queue workers)
sudo apt install supervisor -y
```

### 5. Configure MySQL

```bash
sudo mysql -u root -p
```

```sql
CREATE DATABASE govt_job_portal CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'jobone'@'localhost' IDENTIFIED BY 'your_secure_password';
GRANT ALL PRIVILEGES ON govt_job_portal.* TO 'jobone'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

---

## Application Deployment

### 1. Clone Repository

```bash
cd /var/www
sudo git clone https://github.com/yourusername/govt-job-portal.git jobone
sudo chown -R $USER:www-data /var/www/jobone
cd /var/www/jobone
```

### 2. Install Dependencies

```bash
# PHP dependencies
composer install --optimize-autoloader --no-dev

# Node dependencies
npm install
npm run build
```

### 3. Configure Environment

```bash
cp .env.example .env
nano .env
```

Update these values in `.env`:

```env
APP_NAME="JobOne.in"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://jobone.in

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=govt_job_portal
DB_USERNAME=jobone
DB_PASSWORD=your_secure_password

CACHE_STORE=file
SESSION_DRIVER=file
QUEUE_CONNECTION=database

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=jobone2026@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=jobone2026@gmail.com
MAIL_FROM_NAME="JobOne.in"
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Run Migrations

```bash
php artisan migrate --force
```

### 6. Create Storage Link

```bash
php artisan storage:link
```

### 7. Set Permissions

```bash
sudo chown -R www-data:www-data /var/www/jobone/storage
sudo chown -R www-data:www-data /var/www/jobone/bootstrap/cache
sudo chmod -R 775 /var/www/jobone/storage
sudo chmod -R 775 /var/www/jobone/bootstrap/cache
```

### 8. Optimize Application

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## Nginx Configuration

### 1. Create Nginx Config

```bash
sudo nano /etc/nginx/sites-available/jobone
```

```nginx
server {
    listen 80;
    server_name jobone.in www.jobone.in;
    root /var/www/jobone/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    # Gzip compression
    gzip on;
    gzip_vary on;
    gzip_min_length 1024;
    gzip_types text/plain text/css text/xml text/javascript application/x-javascript application/xml+rss application/json;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }

    # Cache static assets
    location ~* \.(jpg|jpeg|png|gif|ico|css|js|svg|woff|woff2|ttf|eot)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }
}
```

### 2. Enable Site

```bash
sudo ln -s /etc/nginx/sites-available/jobone /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

---

## SSL Certificate (Let's Encrypt)

```bash
sudo apt install certbot python3-certbot-nginx -y
sudo certbot --nginx -d jobone.in -d www.jobone.in
```

Follow the prompts and select option 2 to redirect HTTP to HTTPS.

---

## Queue Worker Setup

### 1. Create Supervisor Config

```bash
sudo nano /etc/supervisor/conf.d/jobone-worker.conf
```

```ini
[program:jobone-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/jobone/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/jobone/storage/logs/worker.log
stopwaitsecs=3600
```

### 2. Start Worker

```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start jobone-worker:*
```

---

## Scheduled Tasks (Cron)

```bash
sudo crontab -e -u www-data
```

Add this line:

```cron
* * * * * cd /var/www/jobone && php artisan schedule:run >> /dev/null 2>&1
```

---

## Post-Deployment Configuration

### 1. Create Admin User

```bash
php artisan tinker
```

```php
$admin = new App\Models\Admin();
$admin->name = 'Admin';
$admin->email = 'admin@jobone.in';
$admin->password = bcrypt('your_secure_password');
$admin->save();
exit
```

### 2. Generate Sitemap

```bash
php artisan sitemap:generate
```

### 3. Clear All Caches

```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

---

## Monitoring & Maintenance

### Check Application Logs

```bash
tail -f /var/www/jobone/storage/logs/laravel.log
```

### Check Nginx Logs

```bash
sudo tail -f /var/log/nginx/error.log
sudo tail -f /var/log/nginx/access.log
```

### Check Queue Worker Status

```bash
sudo supervisorctl status jobone-worker:*
```

### Restart Services

```bash
# Restart Nginx
sudo systemctl restart nginx

# Restart PHP-FPM
sudo systemctl restart php8.2-fpm

# Restart Queue Workers
sudo supervisorctl restart jobone-worker:*
```

---

## Updating Application

```bash
cd /var/www/jobone

# Pull latest changes
git pull origin main

# Update dependencies
composer install --optimize-autoloader --no-dev
npm install && npm run build

# Run migrations
php artisan migrate --force

# Clear and rebuild caches
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Restart queue workers
sudo supervisorctl restart jobone-worker:*
```

---

## Backup Strategy

### Database Backup Script

Create `/var/www/jobone/backup-db.sh`:

```bash
#!/bin/bash
BACKUP_DIR="/var/backups/jobone"
DATE=$(date +%Y%m%d_%H%M%S)
mkdir -p $BACKUP_DIR

mysqldump -u jobone -p'your_password' govt_job_portal | gzip > $BACKUP_DIR/db_$DATE.sql.gz

# Keep only last 7 days
find $BACKUP_DIR -name "db_*.sql.gz" -mtime +7 -delete
```

Make it executable and add to cron:

```bash
chmod +x /var/www/jobone/backup-db.sh
sudo crontab -e
```

Add:
```cron
0 2 * * * /var/www/jobone/backup-db.sh
```

---

## Performance Optimization

### 1. Enable OPcache

```bash
sudo nano /etc/php/8.2/fpm/php.ini
```

Add/Update:
```ini
opcache.enable=1
opcache.memory_consumption=256
opcache.interned_strings_buffer=16
opcache.max_accelerated_files=10000
opcache.revalidate_freq=60
```

### 2. PHP-FPM Tuning

```bash
sudo nano /etc/php/8.2/fpm/pool.d/www.conf
```

Update:
```ini
pm = dynamic
pm.max_children = 50
pm.start_servers = 10
pm.min_spare_servers = 5
pm.max_spare_servers = 20
pm.max_requests = 500
```

Restart PHP-FPM:
```bash
sudo systemctl restart php8.2-fpm
```

---

## Security Checklist

- [ ] Firewall configured (UFW)
- [ ] SSH key-based authentication
- [ ] Disable root login
- [ ] SSL certificate installed
- [ ] Database user has limited privileges
- [ ] `.env` file permissions set to 600
- [ ] Regular security updates enabled
- [ ] Fail2ban installed and configured
- [ ] Application in production mode (APP_DEBUG=false)

---

## Troubleshooting

### 502 Bad Gateway
- Check PHP-FPM status: `sudo systemctl status php8.2-fpm`
- Check Nginx error logs: `sudo tail -f /var/log/nginx/error.log`

### Permission Denied
```bash
sudo chown -R www-data:www-data /var/www/jobone/storage
sudo chmod -R 775 /var/www/jobone/storage
```

### Queue Not Processing
```bash
sudo supervisorctl restart jobone-worker:*
sudo supervisorctl tail -f jobone-worker:jobone-worker_00 stdout
```

---

## Support

For issues or questions:
- Email: jobone2026@gmail.com
- Check logs: `/var/www/jobone/storage/logs/laravel.log`

---

## Cost Estimate (AWS)

### For 10,000 Users
- EC2 t3.medium: ~$30/month
- EBS Storage (50GB): ~$5/month
- Data Transfer: ~$5-10/month
- **Total: ~$40-45/month**

### For 50,000 Users
- EC2 t3.xlarge: ~$150/month
- EBS Storage (100GB): ~$10/month
- Data Transfer: ~$20-30/month
- **Total: ~$180-200/month**

---

**Last Updated:** March 9, 2026
**Version:** 1.0.0
