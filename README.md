# JobOne.in - Government Job Portal

A comprehensive Laravel-based government job portal featuring job listings, admit cards, results, and more.

## 🚀 Quick Server Deployment

### Pull Latest Changes
```bash
cd /path/to/your/project
git pull origin main
```

### Clear Laravel Caches
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

### Install Dependencies (if needed)
```bash
composer install --no-dev --optimize-autoloader
```

### Set Permissions
```bash
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

## 📋 Recent Updates (Latest Commit: 5a0d81e)

### ✅ UI Improvements
- **Category Cards**: Added icon-based category navigation (Banking, Railways, SSC, UPSC, etc.)
- **Compact States**: Smaller state boxes with responsive grid layout
- **Smart Filtering**: Hide states with 0 jobs from navigation
- **Clean Interface**: Detailed info (date/category/state) only shows on home page
- **Simplified Listings**: Other pages show clean title-only format

### ✅ Performance Optimizations
- Enhanced StateController with better eager loading
- Optimized database queries for state filtering
- Improved caching mechanisms

## 🛠️ Technical Stack
- **Framework**: Laravel 12.x
- **PHP**: 8.2+
- **Database**: MySQL
- **Frontend**: Tailwind CSS, Alpine.js
- **Icons**: Font Awesome 6.4.0

## 📁 Key Files Modified
- `app/Http/Controllers/StateController.php`
- `resources/views/layouts/app.blade.php`
- `resources/views/home.blade.php`
- `resources/views/states/show.blade.php`
- `resources/views/categories/show.blade.php`
- `resources/views/components/post-card.blade.php`
- `resources/views/posts/index.blade.php`

## 🔧 One-Click Server Update Script

Create `update-server.sh`:
```bash
#!/bin/bash
echo "🔄 Updating JobOne Portal..."
cd /path/to/your/project
git pull origin main
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
echo "✅ Server updated successfully!"
```

Make executable: `chmod +x update-server.sh`
Run: `./update-server.sh`