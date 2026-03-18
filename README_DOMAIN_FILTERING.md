# Domain-Based State Filtering

## Overview

This implementation allows `karnatakajob.online` to automatically show ONLY Karnataka-related jobs, while `jobone.in` continues to show all states. The filtering is completely automatic based on the domain name.

## Quick Start

### For Deployment Team

1. **Read this first:** `QUICK_DEPLOY.txt` (5 minutes)
2. **Follow checklist:** `DEPLOYMENT_CHECKLIST.md` (30 minutes)
3. **Verify setup:** Run `php verify-domain-filter.php`

### For Developers

1. **Architecture:** `ARCHITECTURE_FLOW.txt`
2. **Technical details:** `IMPLEMENTATION_SUMMARY.txt`
3. **Full documentation:** `DOMAIN_STATE_FILTERING.md`

## What's New

### Files Created

**Middleware:**
- `app/Http/Middleware/DomainStateFilter.php` - Core filtering logic

**Documentation:**
- `DOMAIN_STATE_FILTERING.md` - Complete feature documentation
- `KARNATAKA_DOMAIN_SETUP.md` - Deployment guide
- `ARCHITECTURE_FLOW.txt` - System architecture
- `IMPLEMENTATION_SUMMARY.txt` - Technical summary
- `DEPLOYMENT_CHECKLIST.md` - Step-by-step deployment
- `QUICK_DEPLOY.txt` - Quick reference card
- `README_DOMAIN_FILTERING.md` - This file

**Scripts:**
- `verify-domain-filter.php` - Verification script
- `setup-domain-filtering.sh` - Interactive setup

### Files Modified

**Core Application:**
- `bootstrap/app.php` - Middleware registration
- `app/Http/Controllers/HomeController.php` - Homepage filtering
- `app/Http/Controllers/PostController.php` - Post listing filtering
- `app/Http/Controllers/SearchController.php` - Search filtering
- `app/Http/Controllers/CategoryController.php` - Category filtering
- `.env` - Configuration added

## How It Works

```
User visits karnatakajob.online
         ↓
DomainStateFilter Middleware
         ↓
Detects domain → Looks up Karnataka state
         ↓
Sets config: app.domain_state_id = 1
         ↓
Controllers check config
         ↓
Add WHERE state_id = 1 to queries
         ↓
Only Karnataka posts returned
```

## Configuration

Add to `.env`:
```env
DOMAIN_STATE_MAP=karnatakajob.online:karnataka,www.karnatakajob.online:karnataka
```

## Testing

### Verification Script
```bash
php verify-domain-filter.php
```

### Manual Testing
1. Visit `http://karnatakajob.online` → Should show ONLY Karnataka
2. Visit `http://jobone.in` → Should show ALL states
3. Visit `http://jobone.in/state/karnataka` → Should work as before

## Deployment

### One-Line Deploy
```bash
php artisan config:clear && php artisan cache:clear && sudo systemctl restart php8.2-fpm
```

### Full Deployment
See `DEPLOYMENT_CHECKLIST.md` for complete steps.

## Features

✅ Automatic domain detection
✅ Zero code changes for new domains
✅ Independent caching per domain
✅ Backward compatible
✅ No impact on existing functionality
✅ API endpoints unaffected
✅ Admin panel unaffected

## Affected Pages

- Homepage (/)
- All post type listings (/jobs, /admit-cards, /results, etc.)
- Category pages (/category/{slug})
- Search results (/search)
- Load more (AJAX pagination)

## Not Affected

- Single post view (shows if exists)
- Admin panel
- API endpoints (use state_id parameter)
- Static pages

## Adding More Domains

To add Maharashtra domain:
```env
DOMAIN_STATE_MAP=karnatakajob.online:karnataka,maharashtrajobs.com:maharashtra
```

Then:
```bash
php artisan config:clear
sudo systemctl restart php8.2-fpm
```

## Troubleshooting

### Shows all states instead of Karnataka
```bash
# Check .env
grep DOMAIN_STATE_MAP .env

# Clear cache
php artisan config:clear
php artisan cache:clear

# Restart PHP-FPM
sudo systemctl restart php8.2-fpm
```

### No posts showing
```bash
# Check Karnataka state exists
php artisan tinker
\App\Models\State::where('slug', 'karnataka')->first();

# Check posts exist for Karnataka
\App\Models\Post::where('state_id', 1)->count();
```

### 404 errors
```bash
# Check nginx config
sudo nginx -t

# Check file permissions
ls -la /var/www/govt-job-portal-new/public
```

## Documentation Index

| File | Purpose | Audience |
|------|---------|----------|
| `QUICK_DEPLOY.txt` | Quick deployment guide | DevOps |
| `DEPLOYMENT_CHECKLIST.md` | Step-by-step checklist | DevOps |
| `KARNATAKA_DOMAIN_SETUP.md` | Detailed setup guide | DevOps |
| `DOMAIN_STATE_FILTERING.md` | Complete documentation | All |
| `ARCHITECTURE_FLOW.txt` | System architecture | Developers |
| `IMPLEMENTATION_SUMMARY.txt` | Technical details | Developers |
| `verify-domain-filter.php` | Verification script | DevOps |
| `setup-domain-filtering.sh` | Interactive setup | DevOps |

## Support

For issues or questions:
1. Check the troubleshooting section above
2. Review `DOMAIN_STATE_FILTERING.md`
3. Run `php verify-domain-filter.php`
4. Check logs: `storage/logs/laravel.log`

## Version

- **Feature:** Domain-Based State Filtering
- **Version:** 1.0
- **Date:** 2026-03-18
- **Status:** Production Ready

## License

Same as main application.
