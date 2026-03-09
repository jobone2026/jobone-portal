# Language Switcher Fix - Deployment Guide

## Issue Summary
Language switcher works in local development but not on production server. The build process also fails due to permission issues.

## Changes Made

### 1. Language Switcher Code (app.blade.php)
- Fixed `changeLanguage()` function to handle English differently (reload page)
- Added proper Google Translate initialization tracking
- Added retry logic for when Google Translate combo box isn't ready
- Added localStorage to remember language preference

### 2. Build Permission Fix Script (fix-build-and-deploy.sh)
- Automatically fixes ownership before build
- Removes old build directory
- Rebuilds assets with correct permissions
- Restores ownership to www-data after build
- Clears all Laravel caches

## Deployment Instructions

### On Your Server (3.108.161.67)

```bash
# SSH into your server
ssh ubuntu@3.108.161.67

# Navigate to application directory
cd /var/www/jobone

# Pull the fix script
sudo git pull origin main

# Make the script executable
chmod +x fix-build-and-deploy.sh

# Run the deployment script
./fix-build-and-deploy.sh
```

The script will:
1. Pull latest changes from GitHub
2. Fix ownership for build process
3. Remove old build directory
4. Install dependencies
5. Build assets
6. Restore ownership to www-data
7. Set correct permissions
8. Clear Laravel caches
9. Restart PHP-FPM

## Testing the Language Switcher

After deployment, test at https://jobone.in:

1. Look for the globe icon (🌐) in the header
2. Click the language dropdown
3. Select a language:
   - **HI** - Hindi
   - **TE** - Telugu
   - **TA** - Tamil
   - **KN** - Kannada
   - **ML** - Malayalam
   - **MR** - Marathi
   - **GU** - Gujarati
   - **BN** - Bengali
   - **PA** - Punjabi
   - **OR** - Odia
   - **AS** - Assamese
4. Page should translate automatically (may take 1-2 seconds)
5. Select **EN** to return to English

## How It Works

### English (EN)
- Reloads the page to show original content
- Removes any active translations

### Other Languages
- Uses Google Translate API
- Finds the `.goog-te-combo` selector
- Changes the value and triggers change event
- Saves preference in localStorage
- Retries if Google Translate isn't ready yet

## Troubleshooting

### If language still doesn't change:

1. **Check browser console** (F12 → Console tab):
   - Look for JavaScript errors
   - Check if Google Translate script loads

2. **Clear browser cache**:
   - Hard refresh: Ctrl+Shift+R (Windows) or Cmd+Shift+R (Mac)

3. **Verify Google Translate loads**:
   - Open browser DevTools → Network tab
   - Look for `translate.google.com` requests
   - Should see `element.js` loading

4. **Check server logs**:
   ```bash
   sudo tail -f /var/log/nginx/error.log
   ```

5. **Rebuild assets manually**:
   ```bash
   cd /var/www/jobone
   sudo chown -R ubuntu:ubuntu .
   rm -rf public/build
   npm run build
   sudo chown -R www-data:ubuntu .
   sudo -u www-data php artisan view:clear
   sudo systemctl restart php8.2-fpm
   ```

## Files Changed
- `resources/views/layouts/app.blade.php` - Language switcher logic
- `fix-build-and-deploy.sh` - Deployment script (new)

## Repository
All changes pushed to: https://github.com/jobone2026/jobone-portal.git

## Notes
- Google Translate is free and doesn't require API key
- Translations are done client-side in the browser
- Language preference is saved in browser localStorage
- Works on all pages automatically once initialized
