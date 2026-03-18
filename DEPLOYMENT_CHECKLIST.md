# Karnataka Domain Deployment Checklist

## Pre-Deployment Verification

### Local Testing
- [ ] All files committed to git
- [ ] No syntax errors in PHP files
- [ ] Middleware registered in bootstrap/app.php
- [ ] .env.example updated with DOMAIN_STATE_MAP example

### Documentation Review
- [ ] Read KARNATAKA_DOMAIN_SETUP.md
- [ ] Understand ARCHITECTURE_FLOW.txt
- [ ] Review DOMAIN_STATE_FILTERING.md

## Server Deployment

### 1. Code Deployment
```bash
cd /var/www/govt-job-portal-new
git pull origin main
```
- [ ] Code pulled successfully
- [ ] No merge conflicts

### 2. Environment Configuration
```bash
nano .env
```
Add:
```
DOMAIN_STATE_MAP=karnatakajob.online:karnataka,www.karnatakajob.online:karnataka
```
- [ ] DOMAIN_STATE_MAP added to .env
- [ ] Syntax correct (domain:slug format)
- [ ] File saved

### 3. Database Verification
```bash
php artisan tinker
```
```php
\App\Models\State::where('slug', 'karnataka')->first();
```
- [ ] Karnataka state exists in database
- [ ] State slug is exactly 'karnataka' (lowercase)
- [ ] State has posts assigned to it

If state doesn't exist:
```php
\App\Models\State::create(['name' => 'Karnataka', 'slug' => 'karnataka']);
```

### 4. Cache Management
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```
- [ ] Config cache cleared
- [ ] Application cache cleared
- [ ] View cache cleared
- [ ] Route cache cleared

### 5. PHP-FPM Restart
```bash
sudo systemctl restart php8.2-fpm
# or
sudo systemctl restart php-fpm
```
- [ ] PHP-FPM restarted successfully
- [ ] No errors in restart

### 6. Nginx Configuration

Create new config:
```bash
sudo nano /etc/nginx/sites-available/karnatakajob.online
```

Add:
```nginx
server {
    listen 80;
    server_name karnatakajob.online www.karnatakajob.online;
    
    root /var/www/govt-job-portal-new/public;
    index index.php index.html;
    
    # Logging
    access_log /var/log/nginx/karnatakajob-access.log;
    error_log /var/log/nginx/karnatakajob-error.log;
    
    # Main location
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    # PHP handling
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
    
    # Deny access to hidden files
    location ~ /\. {
        deny all;
    }
}
```

Enable and test:
```bash
sudo ln -s /etc/nginx/sites-available/karnatakajob.online /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

- [ ] Nginx config created
- [ ] Symlink created
- [ ] Nginx test passed
- [ ] Nginx reloaded

### 7. File Permissions
```bash
sudo chown -R www-data:www-data /var/www/govt-job-portal-new
sudo chmod -R 755 /var/www/govt-job-portal-new
sudo chmod -R 775 /var/www/govt-job-portal-new/storage
sudo chmod -R 775 /var/www/govt-job-portal-new/bootstrap/cache
```
- [ ] Ownership set correctly
- [ ] Permissions set correctly
- [ ] Storage writable
- [ ] Bootstrap cache writable

### 8. DNS Configuration

In your domain registrar (GoDaddy, Namecheap, Cloudflare, etc.):

**A Records:**
- [ ] @ → YOUR_SERVER_IP
- [ ] www → YOUR_SERVER_IP

**Wait for DNS propagation (5-30 minutes)**

Check DNS:
```bash
nslookup karnatakajob.online
nslookup www.karnatakajob.online
```
- [ ] DNS resolves to correct IP
- [ ] www subdomain resolves

### 9. SSL Certificate (Optional but Recommended)
```bash
sudo certbot --nginx -d karnatakajob.online -d www.karnatakajob.online
```
- [ ] SSL certificate installed
- [ ] HTTPS working
- [ ] Auto-renewal configured

## Testing

### 10. Verification Script
```bash
cd /var/www/govt-job-portal-new
php verify-domain-filter.php
```
- [ ] All checks pass
- [ ] No errors reported

### 11. Manual Testing

**Test karnatakajob.online:**
- [ ] Homepage loads
- [ ] Shows ONLY Karnataka posts
- [ ] Jobs page filtered to Karnataka
- [ ] Admit cards filtered to Karnataka
- [ ] Results filtered to Karnataka
- [ ] Search works and shows Karnataka only
- [ ] Category pages show Karnataka only
- [ ] No posts from other states visible

**Test jobone.in:**
- [ ] Homepage loads
- [ ] Shows ALL states
- [ ] Jobs page shows all states
- [ ] Search shows all states
- [ ] No filtering applied

**Test jobone.in/state/karnataka:**
- [ ] Still works as before
- [ ] Shows Karnataka via URL routing
- [ ] Different from domain filtering

### 12. Performance Testing
- [ ] Page load time acceptable
- [ ] No database errors in logs
- [ ] Cache working properly
- [ ] No 500 errors

### 13. Log Verification
```bash
tail -f /var/log/nginx/karnatakajob-error.log
tail -f /var/www/govt-job-portal-new/storage/logs/laravel.log
```
- [ ] No PHP errors
- [ ] No database errors
- [ ] No middleware errors

## Post-Deployment

### 14. Monitoring
- [ ] Set up uptime monitoring
- [ ] Monitor error logs
- [ ] Check analytics setup

### 15. Documentation
- [ ] Update team documentation
- [ ] Share access credentials
- [ ] Document any custom changes

### 16. Backup
- [ ] Database backup created
- [ ] Code backup created
- [ ] .env file backed up securely

## Rollback Plan

If something goes wrong:

1. **Remove domain from Nginx:**
   ```bash
   sudo rm /etc/nginx/sites-enabled/karnatakajob.online
   sudo systemctl reload nginx
   ```

2. **Remove from .env:**
   ```bash
   nano .env
   # Remove DOMAIN_STATE_MAP line
   ```

3. **Clear caches:**
   ```bash
   php artisan config:clear
   php artisan cache:clear
   ```

4. **Restart PHP-FPM:**
   ```bash
   sudo systemctl restart php8.2-fpm
   ```

## Support Contacts

- **Technical Issues:** Check DOMAIN_STATE_FILTERING.md
- **Deployment Issues:** Check KARNATAKA_DOMAIN_SETUP.md
- **Architecture Questions:** Check ARCHITECTURE_FLOW.txt

## Success Criteria

✅ karnatakajob.online shows ONLY Karnataka posts
✅ jobone.in shows ALL posts (unchanged)
✅ No errors in logs
✅ Performance is acceptable
✅ SSL certificate installed
✅ DNS resolves correctly
✅ All tests pass

---

**Deployment Date:** _____________
**Deployed By:** _____________
**Sign-off:** _____________
