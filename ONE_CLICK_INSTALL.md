# JobOne.in - One-Click Installation Guide

Complete automated deployment in just one command!

## Prerequisites

- Fresh Ubuntu 22.04 or 24.04 LTS server
- Root or sudo access
- Domain name pointed to your server IP
- Minimum 2GB RAM, 2 vCPU (t3.medium on AWS)

## Quick Start

### 1. Connect to Your Server

```bash
ssh ubuntu@your-server-ip
```

### 2. Download and Run Installer

```bash
# Download the installer
wget https://raw.githubusercontent.com/jobone2026/jobone-portal/main/install.sh

# Make it executable
chmod +x install.sh

# Run the installer
bash install.sh
```

### 3. Follow the Prompts

The installer will ask you for:

- **Domain name** (e.g., jobone.in)
- **Database name** (default: govt_job_portal) - auto-configured
- **Database username** (default: jobone) - auto-configured
- **Database password** - auto-generated securely
- **Admin email** (for admin login)
- **Admin password** (for admin login)
- **SSL email** (for Let's Encrypt certificate)

**Note:** Database credentials are automatically generated and saved in the `.env` file.

### 4. Wait for Installation

The script will automatically:
- ✅ Update system packages
- ✅ Install Nginx web server
- ✅ Install PHP 8.2 with all extensions
- ✅ Install MySQL 8.0 database
- ✅ Install Composer and Node.js
- ✅ Clone your application from GitHub
- ✅ Install all dependencies
- ✅ Configure environment
- ✅ Run database migrations
- ✅ Configure Nginx virtual host
- ✅ Install SSL certificate (Let's Encrypt)
- ✅ Set up queue workers
- ✅ Configure cron jobs
- ✅ Create admin user
- ✅ Generate sitemap
- ✅ Configure firewall

**Estimated time:** 10-15 minutes

## What You'll Get

After installation completes, you'll have:

- 🌐 **Live website** at https://yourdomain.com
- 🔐 **Admin panel** at https://yourdomain.com/admin/login
- 🔒 **SSL certificate** (HTTPS enabled)
- 📊 **SEO optimized** (250+ keywords, sitemaps, structured data)
- 🚀 **Production ready** (caching, queue workers, scheduled tasks)
- 📱 **Mobile responsive** design
- 🔧 **REST API** enabled

## Post-Installation Steps

### 1. Access Your Website

Visit: `https://yourdomain.com`

### 2. Login to Admin Panel

- URL: `https://yourdomain.com/admin/login`
- Email: (the email you provided during installation)
- Password: (the password you provided during installation)

### 3. Change Admin Password

1. Login to admin panel
2. Go to Settings or Profile
3. Change your password immediately

### 4. Configure Site Settings

1. Go to Admin → Settings
2. Update:
   - Site name
   - Site description
   - Contact information
   - Social media links
   - Google Analytics ID

### 5. Add Content

1. Go to Admin → Posts
2. Create your first job posting
3. Add categories and states as needed

### 6. Submit Sitemap to Google

1. Go to [Google Search Console](https://search.google.com/search-console)
2. Add your property (domain)
3. Submit sitemap: `https://yourdomain.com/sitemap.xml`

## Installation Locations

- **Application:** `/var/www/jobone`
- **Logs:** `/var/www/jobone/storage/logs`
- **Nginx config:** `/etc/nginx/sites-available/jobone`
- **SSL certificates:** `/etc/letsencrypt/live/yourdomain.com`

## Useful Commands

### Check Application Status

```bash
# Check Nginx status
sudo systemctl status nginx

# Check PHP-FPM status
sudo systemctl status php8.2-fpm

# Check MySQL status
sudo systemctl status mysql

# Check queue workers
sudo supervisorctl status jobone-worker:*
```

### View Logs

```bash
# Application logs
tail -f /var/www/jobone/storage/logs/laravel.log

# Nginx error logs
sudo tail -f /var/log/nginx/error.log

# Queue worker logs
tail -f /var/www/jobone/storage/logs/worker.log
```

### Restart Services

```bash
# Restart Nginx
sudo systemctl restart nginx

# Restart PHP-FPM
sudo systemctl restart php8.2-fpm

# Restart queue workers
sudo supervisorctl restart jobone-worker:*
```

### Update Application

```bash
cd /var/www/jobone
git pull origin main
composer install --optimize-autoloader --no-dev
npm install && npm run build
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
sudo supervisorctl restart jobone-worker:*
```

## Troubleshooting

### Installation Failed

If installation fails at any step:

1. Check the error message
2. Fix the issue
3. Run the installer again (it's safe to re-run)

### Website Not Loading

```bash
# Check Nginx configuration
sudo nginx -t

# Check if Nginx is running
sudo systemctl status nginx

# Check application logs
tail -f /var/www/jobone/storage/logs/laravel.log
```

### SSL Certificate Issues

```bash
# Renew SSL certificate manually
sudo certbot renew

# Test SSL configuration
sudo certbot certificates
```

### Database Connection Issues

```bash
# Check MySQL status
sudo systemctl status mysql

# Test database connection
mysql -u jobone -p govt_job_portal
```

### Permission Issues

```bash
# Fix storage permissions
sudo chown -R www-data:www-data /var/www/jobone/storage
sudo chmod -R 775 /var/www/jobone/storage

# Fix cache permissions
sudo chown -R www-data:www-data /var/www/jobone/bootstrap/cache
sudo chmod -R 775 /var/www/jobone/bootstrap/cache
```

## Manual Installation

If you prefer manual installation, follow the detailed guide in `DEPLOYMENT.md`.

## Security Recommendations

After installation:

1. ✅ Change admin password immediately
2. ✅ Set up regular backups (use admin panel backup feature)
3. ✅ Enable automatic security updates
4. ✅ Configure fail2ban for SSH protection
5. ✅ Use strong database passwords
6. ✅ Keep system and packages updated

## Backup & Restore

### Create Backup

Use the admin panel:
1. Login to admin panel
2. Go to Backups
3. Click "Create Backup"
4. Download the backup file

### Restore Backup

1. Login to admin panel
2. Go to Backups
3. Upload backup file
4. Click "Restore"

## Support

- **Email:** jobone2026@gmail.com
- **GitHub:** https://github.com/jobone2026/jobone-portal
- **Documentation:** See all .md files in repository

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

## Features Included

### SEO & Marketing
- 250+ targeted keywords
- Dynamic meta tags
- Open Graph tags
- Structured data (JSON-LD)
- Automated XML sitemaps
- IndexNow integration
- Google Analytics 4

### Admin Panel
- Secure authentication
- Full CRUD operations
- Database backup & restore
- Ad management
- Site settings

### REST API
- Laravel Sanctum authentication
- Full CRUD via API
- Token-based access

### Performance
- Page caching
- Smart cache invalidation
- Lazy loading images
- Minified assets
- Database optimization

### Mobile
- Responsive design
- Mobile-first approach
- Touch-friendly navigation
- Core Web Vitals optimized

---

**Last Updated:** March 9, 2026  
**Version:** 1.0.0

🎉 **Enjoy your new JobOne.in portal!**
