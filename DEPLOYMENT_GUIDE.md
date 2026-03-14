# Safe Deployment Guide for JobOne.in

## Current Situation
The site is live with users. We need to be careful with deployments.

## Recommended Workflow

### Option 1: Test Locally First (Best)
```bash
# 1. Make changes locally
# 2. Test thoroughly on local environment
# 3. Only push to production when confirmed working

# On local machine
git add .
git commit -m "Description of changes"

# Test locally first!
# Visit http://localhost/jobone in browser
# Check all affected pages

# Only push when everything works
git push portal main
```

### Option 2: Use Staging Branch
```bash
# Create staging branch (one time)
git checkout -b staging
git push portal staging

# For each change:
git checkout staging
# Make changes
git add .
git commit -m "Test: description"
git push portal staging

# Deploy to staging server and test
# If good, merge to main:
git checkout main
git merge staging
git push portal main
```

### Option 3: Feature Branches
```bash
# For each feature/fix
git checkout -b feature/fix-name
# Make changes
git add .
git commit -m "Fix: description"
git push portal feature/fix-name

# Test, then merge to main
git checkout main
git merge feature/fix-name
git push portal main
```

## Deployment to Production Server

### Safe Deployment (Recommended)
```bash
# On server (3.108.161.67)
cd /var/www/jobone
chmod +x deploy-safe.sh
./deploy-safe.sh
```

This script will:
- Create automatic backup
- Pull latest changes
- Clear caches
- Test if site is accessible
- Auto-rollback if site fails

### Manual Deployment
```bash
# On server
cd /var/www/jobone
git pull portal main
php artisan view:clear
php artisan cache:clear
sudo systemctl restart php8.2-fpm
```

## If Something Breaks

### Quick Rollback
```bash
# On server
cd /var/www/jobone
chmod +x rollback.sh

# Rollback to previous commit
./rollback.sh

# Or rollback to specific commit
./rollback.sh abc1234
```

### Manual Rollback
```bash
# On server
cd /var/www/jobone

# See recent commits
git log --oneline -10

# Rollback to specific commit
git reset --hard <commit-hash>

# Clear caches
php artisan view:clear
php artisan cache:clear
sudo systemctl restart php8.2-fpm
```

## View Recent Commits
```bash
# See what was deployed
git log --oneline -10

# See changes in a commit
git show <commit-hash>

# See current commit
git rev-parse HEAD
```

## Backup Strategy

### Automatic Backups
The `deploy-safe.sh` script creates backups automatically at:
`/var/www/backups/jobone-YYYYMMDD-HHMMSS/`

### Manual Backup
```bash
# Create backup before risky changes
BACKUP_DIR="/var/www/backups/jobone-$(date +%Y%m%d-%H%M%S)"
cp -r /var/www/jobone $BACKUP_DIR
echo "Backup created at: $BACKUP_DIR"
```

### Restore from Backup
```bash
# List backups
ls -la /var/www/backups/

# Restore from backup
cp -r /var/www/backups/jobone-YYYYMMDD-HHMMSS/* /var/www/jobone/
cd /var/www/jobone
php artisan view:clear
php artisan cache:clear
sudo systemctl restart php8.2-fpm
```

## Testing Checklist Before Deployment

- [ ] Test on local environment
- [ ] Check admin panel pages
- [ ] Check public post pages
- [ ] Check home page
- [ ] Check category pages
- [ ] Test on mobile view
- [ ] Check browser console for errors
- [ ] Verify no PHP errors in logs

## Emergency Contacts

- Server IP: 3.108.161.67
- Domain: jobone.in
- Project Path: /var/www/jobone
- Git Remote: https://github.com/jobone2026/jobone-portal.git

## Common Issues

### Site shows 500 error
```bash
# Check PHP error logs
tail -f /var/log/php8.2-fpm.log

# Clear all caches
php artisan view:clear
php artisan cache:clear
php artisan config:clear
php artisan route:clear

# Restart PHP-FPM
sudo systemctl restart php8.2-fpm
```

### Changes not showing
```bash
# Clear Laravel caches
php artisan view:clear
php artisan cache:clear

# Clear browser cache
# Press Ctrl+Shift+R (hard refresh)
```

### Git conflicts
```bash
# Discard local changes and pull fresh
git reset --hard HEAD
git pull portal main
```
