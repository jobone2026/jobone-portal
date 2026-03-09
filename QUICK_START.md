# JobOne.in - Quick Start Guide

## 🚀 Fresh VPS Installation (3 Commands)

### Recommended: Ubuntu 22.04 LTS on AWS Lightsail ($10/month, 2GB RAM)

```bash
# 1. Download installer
wget https://raw.githubusercontent.com/jobone2026/jobone-portal/main/install-fixed.sh

# 2. Make executable
chmod +x install-fixed.sh

# 3. Run installer
bash install-fixed.sh
```

**That's it!** The script handles everything automatically.

---

## 📋 What You'll Be Asked

1. **Domain name** → Enter your domain OR press Enter to use server IP
2. **Admin email** → Enter your email
3. **Admin password** → Enter strong password (min 8 chars)
4. **SSL email** → Enter your email
5. **Install SSL?** → Type `y` for domain, `n` for IP

**Note:** Database name and user are automatically set to `govt_job_portal` and `jobone`

---

## ⏱️ Installation Time: 10-15 minutes

The script automatically installs and configures:
- ✅ Nginx
- ✅ PHP 8.2
- ✅ MySQL 8.0
- ✅ Composer
- ✅ Node.js 20
- ✅ Your application
- ✅ SSL certificate (if domain)
- ✅ Queue workers
- ✅ Cron jobs
- ✅ Firewall

---

## 🎯 After Installation

### Access Your Site
```
http://YOUR_IP
or
https://yourdomain.com
```

### Admin Panel
```
http://YOUR_IP/admin/login
or
https://yourdomain.com/admin/login
```

### Credentials
Check: `/tmp/jobone-credentials.txt`

---

## 🔧 What's Fixed in v2.0?

All previous deployment issues resolved:
- ✅ No more "File not found" errors
- ✅ No more 500 Internal Server errors
- ✅ No more MySQL connection issues
- ✅ No more permission errors
- ✅ No more TEXT column default value errors
- ✅ Proper file permissions from start
- ✅ Non-interactive system updates
- ✅ Correct Nginx FastCGI configuration

---

## 🆘 Quick Troubleshooting

### View Logs
```bash
# Laravel logs
tail -f /var/www/jobone/storage/logs/laravel.log

# Nginx logs
sudo tail -f /var/log/nginx/error.log
```

### Restart Services
```bash
sudo systemctl restart php8.2-fpm nginx mysql
```

### Fix Permissions
```bash
cd /var/www/jobone
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

---

## 📦 VPS Recommendations

| Provider | Plan | RAM | Price | Region |
|----------|------|-----|-------|--------|
| AWS Lightsail | Standard | 2 GB | $10/mo | Mumbai |
| DigitalOcean | Basic | 2 GB | $12/mo | Bangalore |
| Vultr | Cloud Compute | 2 GB | $12/mo | Mumbai |

**Minimum Requirements:**
- Ubuntu 22.04 LTS
- 2 GB RAM
- 1 vCPU
- 60 GB SSD

---

## 📞 Need Help?

1. Read full guide: `FRESH_VPS_SETUP.md`
2. Check logs (see Quick Troubleshooting above)
3. Ensure VPS has 2GB RAM minimum
4. Try on fresh VPS if issues persist

---

**Version:** 2.0 (Fixed)  
**Last Updated:** March 2026  
**Repository:** https://github.com/jobone2026/jobone-portal
