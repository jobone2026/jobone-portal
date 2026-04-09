# Staging Server Setup Guide

## Why Use a Staging Server?

A staging server lets you:
- Test all changes before going live
- Catch errors without affecting users
- Try new features safely
- Verify deployments work correctly

## Setup Options

### Option 1: Separate AWS EC2 Instance (Recommended)

**Cost**: ~$5-10/month for t2.micro or t3.micro

**Steps**:

1. **Launch New EC2 Instance**
   - Go to AWS Console → EC2 → Launch Instance
   - Choose Ubuntu 22.04 LTS
   - Select t2.micro (free tier) or t3.micro
   - Use same security group as production
   - Create new key pair: `jobone-staging.pem`

2. **Point Subdomain to Staging**
   - In your domain DNS settings, create:
   - `staging.jobone.in` → Point to new server IP
   - OR `test.jobone.in` → Point to new server IP

3. **Install Everything on Staging**
   ```bash
   # Connect to staging server
   ssh -i jobone-staging.pem ubuntu@STAGING_IP
   
   # Run installation script
   curl -o- https://raw.githubusercontent.com/jobone2026/jobone-portal/main/setup-high-availability.sh | bash
   ```

### Option 2: Same Server, Different Directory (Budget Option)

**Cost**: Free (uses existing server)

**Steps**:

1. **Create Staging Directory**
   ```bash
   ssh -i jobone2026.pem ubuntu@3.108.161.67
   
   # Create staging directory
   sudo mkdir -p /var/www/jobone-staging
   sudo chown ubuntu:ubuntu /var/www/jobone-staging
   
   # Clone repository
   cd /var/www/jobone-staging
   git clone https://github.com/jobone2026/jobone-portal.git .
   ```

2. **Setup Staging Database**
   ```bash
   # Create separate database
   sudo mysql -u root -p
   ```
   
   ```sql
   CREATE DATABASE jobone_staging;
   CREATE USER 'jobone_staging'@'localhost' IDENTIFIED BY 'your_password';
   GRANT ALL PRIVILEGES ON jobone_staging.* TO 'jobone_staging'@'localhost';
   FLUSH PRIVILEGES;
   EXIT;
   ```

3. **Configure Staging Environment**
   ```bash
   cd /var/www/jobone-staging
   cp .env.example .env
   nano .env
   ```
   
   Update:
   ```
   APP_ENV=staging
   APP_DEBUG=true
   APP_URL=https://staging.jobone.in
   
   DB_DATABASE=jobone_staging
   DB_USERNAME=jobone_staging
   DB_PASSWORD=your_password
   ```

4. **Install Dependencies**
   ```bash
   composer install
   php artisan key:generate
   php artisan migrate
   php artisan storage:link
   
   # Copy production data (optional)
   sudo mysqldump -u root -p jobone > /tmp/prod_backup.sql
   sudo mysql -u root -p jobone_staging < /tmp/prod_backup.sql
   rm /tmp/prod_backup.sql
   ```

5. **Setup Nginx for Staging**
   ```bash
   sudo nano /etc/nginx/sites-available/jobone-staging
   ```
   
   Add:
   ```nginx
   server {
       listen 80;
       server_name staging.jobone.in;
       root /var/www/jobone-staging/public;
       
       add_header X-Frame-Options "SAMEORIGIN";
       add_header X-Content-Type-Options "nosniff";
       
       index index.php;
       
       charset utf-8;
       
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
       }
       
       location ~ /\.(?!well-known).* {
           deny all;
       }
   }
   ```
   
   Enable site:
   ```bash
   sudo ln -s /etc/nginx/sites-available/jobone-staging /etc/nginx/sites-enabled/
   sudo nginx -t
   sudo systemctl reload nginx
   ```

6. **Setup SSL Certificate**
   ```bash
   sudo certbot --nginx -d staging.jobone.in
   ```

7. **Set Permissions**
   ```bash
   sudo chown -R www-data:www-data /var/www/jobone-staging/storage
   sudo chown -R www-data:www-data /var/www/jobone-staging/bootstrap/cache
   sudo chmod -R 775 /var/www/jobone-staging/storage
   sudo chmod -R 775 /var/www/jobone-staging/bootstrap/cache
   ```

## Deployment Workflow

### 1. Test on Staging First
```bash
# Connect to server
ssh -i jobone2026.pem ubuntu@3.108.161.67

# Pull changes to staging
cd /var/www/jobone-staging
git pull origin main

# Clear cache
sudo -u www-data php artisan cache:clear
sudo -u www-data php artisan view:clear
sudo -u www-data php artisan config:clear

# Test on staging.jobone.in
```

### 2. If Staging Works, Deploy to Production
```bash
# Pull changes to production
cd /var/www/jobone
git pull origin main

# Clear cache
sudo -u www-data php artisan cache:clear
sudo -u www-data php artisan view:clear
sudo -u www-data php artisan config:clear

# Restart PHP-FPM
sudo systemctl restart php8.2-fpm
```

## Quick Deploy Script

Create this script for easy deployment:

```bash
nano ~/deploy-staging.sh
```

Add:
```bash
#!/bin/bash

echo "🚀 Deploying to STAGING..."

cd /var/www/jobone-staging

# Pull latest code
git pull origin main

# Install dependencies
composer install --no-dev --optimize-autoloader

# Clear caches
sudo -u www-data php artisan cache:clear
sudo -u www-data php artisan view:clear
sudo -u www-data php artisan config:clear

# Run migrations
sudo -u www-data php artisan migrate --force

echo "✅ Staging deployment complete!"
echo "🌐 Test at: https://staging.jobone.in"
```

Make executable:
```bash
chmod +x ~/deploy-staging.sh
```

Create production deploy script:
```bash
nano ~/deploy-production.sh
```

Add:
```bash
#!/bin/bash

echo "⚠️  Deploying to PRODUCTION..."
read -p "Have you tested on staging? (yes/no): " confirm

if [ "$confirm" != "yes" ]; then
    echo "❌ Deployment cancelled. Test on staging first!"
    exit 1
fi

cd /var/www/jobone

# Backup database first
sudo mysqldump -u root jobone > /var/backups/jobone/pre-deploy-$(date +%Y%m%d-%H%M%S).sql

# Pull latest code
git pull origin main

# Install dependencies
composer install --no-dev --optimize-autoloader

# Clear caches
sudo -u www-data php artisan cache:clear
sudo -u www-data php artisan view:clear
sudo -u www-data php artisan config:clear

# Run migrations
sudo -u www-data php artisan migrate --force

# Restart PHP-FPM
sudo systemctl restart php8.2-fpm

echo "✅ Production deployment complete!"
echo "🌐 Live at: https://jobone.in"
```

Make executable:
```bash
chmod +x ~/deploy-production.sh
```

## Usage

### Deploy to Staging
```bash
ssh -i jobone2026.pem ubuntu@3.108.161.67
~/deploy-staging.sh
```

### Deploy to Production (after testing staging)
```bash
ssh -i jobone2026.pem ubuntu@3.108.161.67
~/deploy-production.sh
```

## Recommended: Option 2 (Same Server)

For your use case, I recommend **Option 2** because:
- ✅ No extra cost
- ✅ Quick to setup (15 minutes)
- ✅ Uses same server resources
- ✅ Perfect for testing before production
- ✅ Separate database prevents data corruption

## Next Steps

1. Choose your option (I recommend Option 2)
2. Follow the setup steps
3. Test the staging site
4. Use the deploy scripts for safe deployments

Would you like me to help you set this up now?
