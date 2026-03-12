# Lazy Loading Deployment Guide

## Changes Made

Added lazy loading functionality to both admin and public posts pages with "Load More" buttons instead of traditional pagination.

### Admin Side Files Modified:
1. `app/Http/Controllers/Admin/PostController.php` - Added `loadMore()` method
2. `routes/admin.php` - Added route for lazy loading endpoint
3. `resources/views/admin/posts/index.blade.php` - Updated view with lazy loading UI and JavaScript
4. `resources/views/admin/posts/load-more.blade.php` - New partial view for lazy-loaded rows

### Public Side Files Modified:
1. `app/Http/Controllers/PostController.php` - Added `loadMore()` method
2. `routes/web.php` - Added routes for lazy loading endpoints for all post types
3. `resources/views/posts/index.blade.php` - Updated view with lazy loading UI and JavaScript
4. `resources/views/posts/load-more.blade.php` - New partial view for lazy-loaded rows

## Deployment Steps

Run these commands on the server:

```bash
cd /var/www/jobone

# Pull latest changes
git pull portal main

# Clear caches
php artisan cache:clear
php artisan config:clear

# Restart PHP-FPM
sudo systemctl restart php8.2-fpm
```

Or use the provided script: `bash deploy-lazy-loading.sh`

## Features

### Admin Side:
- **Load More Button**: Replaces traditional pagination with a "Load More" button
- **Maintains Filters**: Lazy loading respects all active filters (type, status, category, state, search)
- **Smooth Loading**: Shows loading spinner while fetching more posts
- **Automatic Detection**: Hides "Load More" button when all posts are loaded
- **Post Counter**: Displays how many posts are currently shown
- **Checkbox Support**: Newly loaded posts can be selected for bulk actions

### Public Side:
- **Load More Button**: Replaces previous/next pagination with a "Load More" button
- **All Post Types**: Works on Jobs, Results, Admit Cards, Answer Keys, Syllabus, and Blogs pages
- **Smooth Loading**: Shows loading spinner while fetching more posts
- **Automatic Detection**: Hides "Load More" button when all posts are loaded
- **Post Counter**: Displays how many posts are currently shown
- **Better UX**: Cleaner interface without page navigation

## How It Works

### Admin Side:
1. Initial page load shows first 100 posts
2. User clicks "Load More" button
3. AJAX request fetches next 100 posts
4. New rows are appended to the table
5. Button hides when no more posts available

### Public Side:
1. Initial page load shows first 50 posts
2. User clicks "Load More" button
3. AJAX request fetches next 50 posts
4. New items are appended to the list
5. Button hides when no more posts available

## Testing

### Admin Side:
1. Go to Admin > Posts Management
2. Verify "Load More" button appears at bottom
3. Click "Load More" to load next batch
4. Verify filters still work with lazy loading
5. Verify bulk actions work on newly loaded posts

### Public Side:
1. Go to /jobs, /results, /admit-cards, /answer-keys, /syllabus, or /blogs
2. Verify "Load More" button appears at bottom
3. Click "Load More" to load next batch
4. Verify post counter updates correctly
5. Verify all posts load properly
