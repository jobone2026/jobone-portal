# 🚀 JobOne Portal - Server Deployment Guide

## Quick Commands Reference

### 1. Pull Latest Changes
```bash
cd /var/www/html/jobone-portal  # Replace with your path
git pull origin main
```

### 2. Clear All Caches
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
php artisan optimize:clear
```

### 3. Optimize for Production
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

### 4. Set Permissions
```bash
sudo chmod -R 755 storage bootstrap/cache
sudo chown -R www-data:www-data storage bootstrap/cache
```

## 🔄 Automated Update Script

Create `/home/update-jobone.sh`:
```bash
#!/bin/bash
echo "🔄 Starting JobOne Portal Update..."
cd /var/www/html/jobone-portal

echo "📥 Pulling latest changes..."
git pull origin main

echo "🧹 Clearing caches..."
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear

echo "⚡ Optimizing for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "🔐 Setting permissions..."
sudo chmod -R 755 storage bootstrap/cache
sudo chown -R www-data:www-data storage bootstrap/cache

echo "✅ JobOne Portal updated successfully!"
echo "🌐 Visit your site to see the changes"
```

### Make it executable:
```bash
chmod +x /home/update-jobone.sh
```

### Run the update:
```bash
./update-jobone.sh
```

## 🆘 Troubleshooting

### If you get permission errors:
```bash
sudo chown -R $USER:www-data .
sudo chmod -R 775 storage bootstrap/cache
```

### If views are not updating:
```bash
php artisan view:clear
rm -rf storage/framework/views/*
```

### If routes are not working:
```bash
php artisan route:clear
php artisan route:cache
```

## 📊 Latest Features Deployed

- ✅ Icon-based category navigation
- ✅ Compact state boxes (only states with jobs)
- ✅ Clean UI (details only on home page)
- ✅ Optimized database queries
- ✅ Better mobile responsiveness