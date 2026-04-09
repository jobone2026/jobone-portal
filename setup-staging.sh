#!/bin/bash

# Staging Server Setup Script
# This creates a staging environment on the same server

set -e

echo "🚀 Setting up Staging Environment for JobOne"
echo "=============================================="

# Check if running as ubuntu user
if [ "$USER" != "ubuntu" ]; then
    echo "❌ Please run as ubuntu user"
    exit 1
fi

# Variables
STAGING_DIR="/var/www/jobone-staging"
PROD_DIR="/var/www/jobone"
STAGING_DB="jobone_staging"
STAGING_USER="jobone_staging"

echo ""
echo "📋 This will create:"
echo "   - Staging directory: $STAGING_DIR"
echo "   - Staging database: $STAGING_DB"
echo "   - Staging URL: https://staging.jobone.in"
echo ""
read -p "Continue? (yes/no): " confirm

if [ "$confirm" != "yes" ]; then
    echo "❌ Setup cancelled"
    exit 1
fi

# Step 1: Create staging directory
echo ""
echo "📁 Creating staging directory..."
sudo mkdir -p $STAGING_DIR
sudo chown ubuntu:ubuntu $STAGING_DIR

# Step 2: Clone repository
echo "📥 Cloning repository..."
cd $STAGING_DIR
if [ ! -d ".git" ]; then
    git clone https://github.com/jobone2026/jobone-portal.git .
else
    echo "Repository already exists, pulling latest..."
    git pull origin main
fi

# Step 3: Create staging database
echo ""
echo "🗄️  Creating staging database..."
echo "Please enter MySQL root password when prompted"

# Generate random password for staging DB user
STAGING_PASS=$(openssl rand -base64 16)

sudo mysql -u root -p <<EOF
CREATE DATABASE IF NOT EXISTS $STAGING_DB;
CREATE USER IF NOT EXISTS '$STAGING_USER'@'localhost' IDENTIFIED BY '$STAGING_PASS';
GRANT ALL PRIVILEGES ON $STAGING_DB.* TO '$STAGING_USER'@'localhost';
FLUSH PRIVILEGES;
EOF

echo "✅ Database created"

# Step 4: Copy production .env and modify for staging
echo ""
echo "⚙️  Configuring environment..."
if [ -f "$PROD_DIR/.env" ]; then
    cp $PROD_DIR/.env $STAGING_DIR/.env
    
    # Update staging .env
    sed -i "s/APP_ENV=production/APP_ENV=staging/" $STAGING_DIR/.env
    sed -i "s/APP_DEBUG=false/APP_DEBUG=true/" $STAGING_DIR/.env
    sed -i "s|APP_URL=.*|APP_URL=https://staging.jobone.in|" $STAGING_DIR/.env
    sed -i "s/DB_DATABASE=.*/DB_DATABASE=$STAGING_DB/" $STAGING_DIR/.env
    sed -i "s/DB_USERNAME=.*/DB_USERNAME=$STAGING_USER/" $STAGING_DIR/.env
    sed -i "s/DB_PASSWORD=.*/DB_PASSWORD=$STAGING_PASS/" $STAGING_DIR/.env
else
    cp $STAGING_DIR/.env.example $STAGING_DIR/.env
    echo "⚠️  Please configure $STAGING_DIR/.env manually"
fi

# Step 5: Install dependencies
echo ""
echo "📦 Installing dependencies..."
cd $STAGING_DIR
composer install --no-dev --optimize-autoloader

# Generate app key
php artisan key:generate

# Step 6: Copy production data to staging
echo ""
read -p "Copy production database to staging? (yes/no): " copy_db

if [ "$copy_db" = "yes" ]; then
    echo "📋 Copying production data..."
    sudo mysqldump -u root -p jobone > /tmp/prod_backup.sql
    sudo mysql -u root -p $STAGING_DB < /tmp/prod_backup.sql
    rm /tmp/prod_backup.sql
    echo "✅ Data copied"
else
    # Run migrations
    php artisan migrate --force
fi

# Create storage link
php artisan storage:link

# Step 7: Set permissions
echo ""
echo "🔒 Setting permissions..."
sudo chown -R www-data:www-data $STAGING_DIR/storage
sudo chown -R www-data:www-data $STAGING_DIR/bootstrap/cache
sudo chmod -R 775 $STAGING_DIR/storage
sudo chmod -R 775 $STAGING_DIR/bootstrap/cache

# Step 8: Create Nginx config
echo ""
echo "🌐 Configuring Nginx..."
sudo tee /etc/nginx/sites-available/jobone-staging > /dev/null <<'NGINX'
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
        fastcgi_read_timeout 300;
    }
    
    location ~ /\.(?!well-known).* {
        deny all;
    }
}
NGINX

# Enable site
sudo ln -sf /etc/nginx/sites-available/jobone-staging /etc/nginx/sites-enabled/
sudo nginx -t && sudo systemctl reload nginx

echo "✅ Nginx configured"

# Step 9: Setup SSL
echo ""
read -p "Setup SSL certificate for staging.jobone.in? (yes/no): " setup_ssl

if [ "$setup_ssl" = "yes" ]; then
    echo "🔐 Setting up SSL..."
    sudo certbot --nginx -d staging.jobone.in --non-interactive --agree-tos --email admin@jobone.in || echo "⚠️  SSL setup failed, you can run it manually later"
fi

# Step 10: Create deploy scripts
echo ""
echo "📝 Creating deployment scripts..."

# Staging deploy script
cat > ~/deploy-staging.sh <<'SCRIPT'
#!/bin/bash
echo "🚀 Deploying to STAGING..."
cd /var/www/jobone-staging
git pull origin main
composer install --no-dev --optimize-autoloader
sudo -u www-data php artisan cache:clear
sudo -u www-data php artisan view:clear
sudo -u www-data php artisan config:clear
sudo -u www-data php artisan migrate --force
echo "✅ Staging deployment complete!"
echo "🌐 Test at: https://staging.jobone.in"
SCRIPT

# Production deploy script
cat > ~/deploy-production.sh <<'SCRIPT'
#!/bin/bash
echo "⚠️  Deploying to PRODUCTION..."
read -p "Have you tested on staging? (yes/no): " confirm
if [ "$confirm" != "yes" ]; then
    echo "❌ Deployment cancelled. Test on staging first!"
    exit 1
fi
cd /var/www/jobone
sudo mysqldump -u root jobone > /var/backups/jobone/pre-deploy-$(date +%Y%m%d-%H%M%S).sql
git pull origin main
composer install --no-dev --optimize-autoloader
sudo -u www-data php artisan cache:clear
sudo -u www-data php artisan view:clear
sudo -u www-data php artisan config:clear
sudo -u www-data php artisan migrate --force
sudo systemctl restart php8.2-fpm
echo "✅ Production deployment complete!"
echo "🌐 Live at: https://jobone.in"
SCRIPT

chmod +x ~/deploy-staging.sh
chmod +x ~/deploy-production.sh

echo ""
echo "=============================================="
echo "✅ Staging Environment Setup Complete!"
echo "=============================================="
echo ""
echo "📋 Summary:"
echo "   Staging URL: https://staging.jobone.in"
echo "   Staging Path: $STAGING_DIR"
echo "   Database: $STAGING_DB"
echo "   DB User: $STAGING_USER"
echo "   DB Password: $STAGING_PASS"
echo ""
echo "⚠️  IMPORTANT: Save the database password above!"
echo ""
echo "📝 Next Steps:"
echo "   1. Add DNS record: staging.jobone.in → $(curl -s ifconfig.me)"
echo "   2. Wait for DNS to propagate (5-30 minutes)"
echo "   3. Test staging site: https://staging.jobone.in"
echo ""
echo "🚀 Deployment Commands:"
echo "   Deploy to staging: ~/deploy-staging.sh"
echo "   Deploy to production: ~/deploy-production.sh"
echo ""
echo "💡 Workflow:"
echo "   1. Make changes in code"
echo "   2. Push to GitHub"
echo "   3. Run ~/deploy-staging.sh"
echo "   4. Test on staging.jobone.in"
echo "   5. If OK, run ~/deploy-production.sh"
echo ""
