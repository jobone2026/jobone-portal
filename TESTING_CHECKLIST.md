# Testing Checklist

Before deploying to production, test these:

## Visual Testing
- [ ] Home page loads correctly
- [ ] Post pages display properly
- [ ] Share buttons look correct (no boxes around icons)
- [ ] Admin panel pages work
- [ ] Category pages work
- [ ] State pages work
- [ ] Search works

## Mobile Testing
- [ ] Open site on mobile browser
- [ ] Check responsive design
- [ ] Share buttons work on mobile
- [ ] Navigation works

## Browser Testing
- [ ] Chrome/Edge
- [ ] Firefox
- [ ] Safari (if available)

## Functionality Testing
- [ ] Can create new post in admin
- [ ] Can edit existing post
- [ ] Can delete post
- [ ] Share buttons open correct apps
- [ ] Pagination works
- [ ] Filters work

## Technical Testing
- [ ] No JavaScript errors in console (F12)
- [ ] No PHP errors in logs
- [ ] Page load time is acceptable
- [ ] Images load correctly

## Admin Panel Testing
- [ ] Login works
- [ ] Dashboard displays stats
- [ ] All admin pages accessible
- [ ] Forms submit correctly
- [ ] Validation works

## How to Test

### Local Testing
```bash
cd C:\xampp\htdocs\job\govt-job-portal-new
php artisan serve
# Visit: http://localhost:8000
```

### Production Testing
```bash
# Visit: https://jobone.in
# Check all pages
# Monitor for user complaints
```

### Check Logs
```bash
# On server
ssh user@3.108.161.67
tail -f /var/www/jobone/storage/logs/laravel.log
```

## If Issues Found

### Minor Issues (cosmetic)
- Note them down
- Fix in next update
- Not urgent

### Major Issues (site broken)
- Rollback immediately
- Fix locally
- Test thoroughly
- Redeploy

### Rollback Command
```bash
ssh user@3.108.161.67
cd /var/www/jobone
./rollback.sh
```
