# Fresh VPS Setup Guide for JobOne.in

## Recommended VPS Configuration

### AWS Lightsail
- **OS**: Ubuntu 22.04 LTS
- **Plan**: $10/month (2 GB RAM, 1 vCPU, 60 GB SSD)
- **Region**: Choose closest to your target audience (e.g., Mumbai for India)

### Alternative Providers
- **DigitalOcean**: Basic Droplet ($12/month - 2 GB RAM)
- **Vultr**: Cloud Compute ($12/month - 2 GB RAM)
- **Linode**: Shared CPU ($12/month - 2 GB RAM)

## Step-by-Step Installation

### 1. Create Fresh VPS
1. Login to AWS Lightsail (or your provider)
2. Click "Create Instance"
3. Select "Linux/Unix" platform
4. Select "Ubuntu 22.04 LTS"
5. Choose $10/month plan (2 GB RAM minimum)
6. Name it: `jobone-production`
7. Click "Create Instance"
8. Wait 2-3 minutes for instance to start

### 2. Connect to VPS
```bash
# From AWS Lightsail console, click "Connect using SSH"
# Or use your own SSH client:
ssh ubuntu@YOUR_SERVER_IP
```

### 3. Download and Run Installation Script

**Option A: Direct Download (Recommended)**
```bash
# Download the fixed installer
wget https://raw.githubusercontent.com/jobone2026/jobone-portal/main/install-fixed.sh

# Make it executable
chmod +x install-fixed.sh

# Run the installer
bash install-fixed.sh
```

**Option B: Manual Copy**
```bash
# Create the file
nano install-fixed.sh

# Paste the script content (from install-fixed.sh)
# Save with: Ctrl+X, then Y, then Enter

# Make it executable
chmod +x install-fixed.sh

# Run the installer
bash install-fixed.sh
```

### 4. Answer Installation Prompts

The script will ask you:

1. **Continue installation?** → Type `y` and press Enter

2. **Domain name** → Options:
   - If you have a domain: Enter `yourdomain.com`
   - If using IP only: Just press Enter (will use server IP)

3. **Database name** → Press Enter (default: `govt_job_portal`)

4. **Database username** → Press Enter (default: `jobone`)

5. **Database password** → Auto-generated (you'll see it in summary)

6. **Admin email** → Enter your email (e.g., `admin@jobone.in`)

7. **Admin password** → Enter a strong password (min 8 characters)

8. **SSL email** → Enter your email for SSL certificate

9. **Install SSL?** → 
   - Type `y` if you entered a domain name
   - Type `n` if using IP address only

### 5. Wait for Installation

The script will automatically:
- ✅ Update system packages
- ✅ Install Nginx web server
- ✅ Install PHP 8.2 with all extensions
- ✅ Install MySQL 8.0 database
- ✅ Create database and user
- ✅ Install Composer
- ✅ Install Node.js 20
- ✅ Install Supervisor for queue workers
- ✅ Clone your GitHub repository
- ✅ Install PHP and Node dependencies
- ✅ Build frontend assets
- ✅ Configure environment (.env file)
- ✅ Set correct file permissions
- ✅ Run database migrations
- ✅ Configure Nginx
- ✅ Install SSL certificate (if domain provided)
- ✅ Setup queue workers
- ✅ Setup cron jobs
- ✅ Create admin user
- ✅ Configure firewall

**Estimated time: 10-15 minutes**

### 6. Installation Complete!

You'll see a summary with:
- Website URL
- Admin panel URL
- Admin login credentials
- Database credentials
- Important file locations

**Credentials are also saved to:** `/tmp/jobone-credentials.txt`

## What's Fixed in This Version?

### Previous Issues → Solutions

1. **"File not found" error**
   - ✅ Fixed Nginx FastCGI configuration
   - ✅ Proper SCRIPT_FILENAME parameter

2. **500 Internal Server Error**
   - ✅ Correct file permissions (www-data ownership)
   - ✅ Writable storage and cache directories
   - ✅ APP_KEY generated before migrations

3. **MySQL connection errors**
   - ✅ Proper MySQL authentication setup
   - ✅ Database created with correct charset
   - ✅ User privileges granted correctly

4. **TEXT column default value error**
   - ✅ MySQL strict mode disabled
   - ✅ Custom MySQL configuration added

5. **Permission denied errors**
   - ✅ All commands run as www-data user
   - ✅ Correct ownership set before operations

6. **Kernel upgrade prompts**
   - ✅ Non-interactive mode enabled
   - ✅ Auto-accept default configurations

7. **Missing Node.js/npm**
   - ✅ Node.js 20 installed from official repository
   - ✅ npm included automatically

8. **SQLite driver error**
   - ✅ php8.2-sqlite3 extension installed
   - ✅ .env properly configured for MySQL

## Post-Installation Steps

### 1. Access Your Website
```
http://YOUR_SERVER_IP
or
https://yourdomain.com
```

### 2. Login to Admin Panel
```
http://YOUR_SERVER_IP/admin/login
or
https://yourdomain.com/admin/login
```

Use the credentials shown in the installation summary.

### 3. Change Admin Password
1. Login to admin panel
2. Go to Settings → Profile
3. Change your password immediately

### 4. Configure Site Settings
1. Go to Settings → Site Settings
2. Update site name, description, logo
3. Configure SEO settings
4. Add Google Analytics (if needed)

### 5. Add Content
1. Create categories (States, Job Types)
2. Add job posts
3. Add admit cards, results, etc.

### 6. Setup Domain (If Using IP Initially)

If you started with IP and want to add domain later:

```bash
# SSH into your server
ssh ubuntu@YOUR_SERVER_IP

# Update .env file
cd /var/www/jobone
sudo nano .env

# Change APP_URL to your domain
APP_URL=https://yourdomain.com

# Update Nginx configuration
sudo nano /etc/nginx/sites-available/jobone

# Change server_name line to:
server_name yourdomain.com www.yourdomain.com;

# Save and test Nginx
sudo nginx -t

# Reload Nginx
sudo systemctl reload nginx

# Install SSL
sudo certbot --nginx -d yourdomain.com -d www.yourdomain.com

# Clear cache
sudo -u www-data php artisan config:cache
```

## Troubleshooting

### If Installation Fails

1. **Check the error message** - The script will show what went wrong

2. **View logs**:
```bash
# Laravel logs
tail -f /var/www/jobone/storage/logs/laravel.log

# Nginx error logs
sudo tail -f /var/log/nginx/error.log

# PHP-FPM logs
sudo tail -f /var/log/php8.2-fpm.log
```

3. **Restart services**:
```bash
sudo systemctl restart php8.2-fpm
sudo systemctl restart nginx
sudo systemctl restart mysql
```

4. **Check service status**:
```bash
sudo systemctl status php8.2-fpm
sudo systemctl status nginx
sudo systemctl status mysql
```

### Common Issues

**Website shows Nginx default page**
```bash
sudo rm /etc/nginx/sites-enabled/default
sudo systemctl reload nginx
```

**Permission errors**
```bash
cd /var/www/jobone
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

**Database connection error**
```bash
# Test database connection
mysql -u jobone -p govt_job_portal
# Enter the password from /tmp/jobone-credentials.txt
```

## Security Recommendations

1. **Change default SSH port** (optional but recommended)
2. **Setup fail2ban** for brute force protection
3. **Enable automatic security updates**
4. **Regular backups** (database + files)
5. **Monitor logs** regularly
6. **Keep software updated**

## Backup Commands

### Database Backup
```bash
mysqldump -u jobone -p govt_job_portal > backup-$(date +%Y%m%d).sql
```

### Files Backup
```bash
tar -czf jobone-files-$(date +%Y%m%d).tar.gz /var/www/jobone
```

## Support

If you encounter any issues:
1. Check the logs (see Troubleshooting section)
2. Review the error messages carefully
3. Ensure your VPS meets minimum requirements (2 GB RAM)
4. Try the installation on a fresh VPS if problems persist

## Next Steps After Installation

1. ✅ Access website and verify it loads
2. ✅ Login to admin panel
3. ✅ Change admin password
4. ✅ Configure site settings
5. ✅ Add categories and states
6. ✅ Create your first job post
7. ✅ Submit sitemap to Google Search Console
8. ✅ Setup regular backups
9. ✅ Monitor server resources

---

**Installation Script Version:** 2.0 (Fixed)  
**Last Updated:** March 2026  
**Tested On:** Ubuntu 22.04 LTS (AWS Lightsail)
