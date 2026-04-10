# Staging vs Production - Complete Comparison

## Quick Reference

| Feature | Staging | Production |
|---------|---------|------------|
| **IP Address** | 43.205.194.69 | 3.108.161.67 |
| **URL** | http://43.205.194.69 | https://jobone.in |
| **Environment** | staging | production |
| **Database** | jobone_staging | jobone |
| **DB User** | jobone | root |
| **SSL** | No | Yes (Let's Encrypt) |
| **Debug Mode** | Enabled | Disabled |
| **RAM** | 416MB + 2GB Swap | 1GB |
| **Purpose** | Testing | Live Users |
| **Data** | Test/Empty | Real User Data |

## Server Specifications

### Staging Server (43.205.194.69)

```
OS: Ubuntu 22.04 LTS
RAM: 416MB + 2GB Swap
Disk: 20GB
CPU: Shared (t2.micro)
Cost: ~$3-5/month

Software:
- PHP 8.2.30
- MySQL 8.0.45 (Low memory config)
- Nginx 1.18.0
- Node.js 20.20.2
- Composer 2.9.5
```

### Production Server (3.108.161.67)

```
OS: Ubuntu 22.04 LTS
RAM: 1GB
Disk: 30GB
CPU: Shared
Cost: ~$10-15/month

Software:
- PHP 8.2.30
- MySQL 8.0.45
- Nginx 1.18.0
- Node.js (if installed)
- Composer 2.x
```

## Configuration Differences

### Environment Files (.env)

**Staging:**
```env
APP_ENV=staging
APP_DEBUG=true
APP_URL=http://43.205.194.69

DB_DATABASE=jobone_staging
DB_USERNAME=jobone
DB_PASSWORD=JobOne2026!Secure
```

**Production:**
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://jobone.in

DB_DATABASE=jobone
DB_USERNAME=root
DB_PASSWORD=[production-password]
```

### MySQL Configuration

**Staging (Low Memory):**
```ini
[mysqld]
performance_schema = OFF
innodb_buffer_pool_size = 64M
innodb_log_buffer_size = 4M
max_connections = 50
table_open_cache = 32
key_buffer_size = 8M
tmp_table_size = 8M
max_heap_table_size = 8M
```

**Production (Standard):**
```ini
[mysqld]
performance_schema = ON
innodb_buffer_pool_size = 256M
innodb_log_buffer_size = 16M
max_connections = 151
table_open_cache = 64
```

### Nginx Configuration

**Staging:**
```nginx
server {
    listen 80;
    server_name 43.205.194.69;
    root /var/www/jobone/public;
    # No SSL
}
```

**Production:**
```nginx
server {
    listen 443 ssl http2;
    server_name jobone.in www.jobone.in;
    root /var/www/jobone/public;
    
    ssl_certificate /etc/letsencrypt/live/jobone.in/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/jobone.in/privkey.pem;
}
```

## When to Use Each Server

### Use Staging For:

✅ Testing new features
✅ Testing bug fixes
✅ Testing database migrations
✅ Testing third-party integrations
✅ Testing performance changes
✅ Training new developers
✅ Demonstrating features to clients
✅ Testing deployment scripts

### Use Production For:

✅ Live user traffic
✅ Real data operations
✅ SEO and search engines
✅ Production backups
✅ Performance monitoring
✅ Analytics and tracking

## Data Management

### Staging Data

**Options:**

1. **Empty Database** (Current)
   - Fresh install
   - No real data
   - Good for testing from scratch

2. **Copy from Production**
   ```bash
   # On production
   sudo mysqldump -u root jobone > /tmp/prod_backup.sql
   
   # Copy to staging
   scp -i jobone2026.pem /tmp/prod_backup.sql ubuntu@43.205.194.69:/tmp/
   
   # On staging
   sudo mysql jobone_staging < /tmp/prod_backup.sql
   rm /tmp/prod_backup.sql
   ```

3. **Anonymized Data**
   - Copy production data
   - Remove sensitive information
   - Good for realistic testing

### Production Data

**Always:**
- ✅ Keep real user data
- ✅ Backup daily (automated)
- ✅ Never delete without backup
- ✅ Monitor database size
- ✅ Optimize regularly

## Deployment Differences

### Staging Deployment

```bash
# Faster, less cautious
cd /var/www/jobone
git pull origin main
npm run build
sudo -u www-data php artisan migrate --force
sudo -u www-data php artisan optimize:clear
```

**No need to:**
- Backup database
- Restart PHP-FPM
- Check traffic
- Notify users

### Production Deployment

```bash
# Careful, with backups
cd /var/www/jobone

# BACKUP FIRST!
sudo mysqldump -u root jobone > /var/backups/jobone/pre-deploy-$(date +%Y%m%d-%H%M%S).sql

git pull origin main
npm run build
sudo -u www-data php artisan migrate --force
sudo -u www-data php artisan optimize:clear

# RESTART SERVICES
sudo systemctl restart php8.2-fpm
```

**Must do:**
- ✅ Backup database
- ✅ Test on staging first
- ✅ Deploy during low traffic
- ✅ Monitor after deployment
- ✅ Restart PHP-FPM

## Testing Checklist

### On Staging (Before Production)

- [ ] Homepage loads
- [ ] All pages accessible
- [ ] Forms submit correctly
- [ ] Search works
- [ ] Database operations work
- [ ] No console errors
- [ ] Images load
- [ ] CSS/JS loads correctly
- [ ] Mobile responsive
- [ ] Admin panel works
- [ ] API endpoints work
- [ ] Notifications work

### On Production (After Deployment)

- [ ] Homepage loads
- [ ] Recent posts visible
- [ ] Search works
- [ ] No 500 errors
- [ ] Check error logs
- [ ] Monitor for 10 minutes
- [ ] Test critical features

## Access Control

### Staging Access

**Who can access:**
- Developers
- Testers
- Project managers
- Clients (for demos)

**How to access:**
- Direct IP: http://43.205.194.69
- SSH: `ssh -i jobone2026.pem ubuntu@43.205.194.69`

### Production Access

**Who can access:**
- Public users (website)
- Authorized admins only (SSH)

**How to access:**
- Website: https://jobone.in
- SSH: `ssh -i jobone2026.pem ubuntu@3.108.161.67`

## Monitoring

### Staging Monitoring

**Basic checks:**
- Service status
- Disk space
- Error logs

**No need for:**
- Uptime monitoring
- Performance monitoring
- User analytics

### Production Monitoring

**Critical monitoring:**
- ✅ Uptime (UptimeRobot recommended)
- ✅ Performance (response times)
- ✅ Error rates
- ✅ Disk space
- ✅ Memory usage
- ✅ Database size
- ✅ SSL certificate expiry
- ✅ Backup success

## Cost Comparison

### Staging Server

```
EC2 Instance (t2.micro): $3-5/month
No SSL certificate: $0
No CDN: $0
Total: ~$3-5/month
```

### Production Server

```
EC2 Instance: $10-15/month
SSL (Let's Encrypt): $0
CDN (Cloudflare): $0 (free tier)
Backups: Included
Total: ~$10-15/month
```

**Total Cost: ~$15-20/month for both servers**

## Backup Strategy

### Staging Backups

**Not critical:**
- Manual backups only
- Before major changes
- Can be recreated from production

### Production Backups

**Critical - Automated:**
- Daily database backups (3 AM)
- Keep last 7 days
- Store in `/var/backups/jobone/`
- Test restore monthly

## Security Differences

### Staging Security

**Relaxed:**
- Debug mode enabled
- Detailed error messages
- No rate limiting
- Test credentials OK

### Production Security

**Strict:**
- Debug mode disabled
- Generic error messages
- Rate limiting enabled
- Strong passwords required
- SSL/HTTPS enforced
- Firewall configured
- Regular security updates

## Performance Expectations

### Staging Performance

**Expected:**
- Slower response times (low RAM)
- May use swap memory
- Not optimized for speed
- Good enough for testing

### Production Performance

**Expected:**
- Fast response times (<200ms)
- Optimized caching
- CDN for static assets
- Database query optimization

## Troubleshooting

### Staging Issues

**Common problems:**
- Out of memory (use swap)
- Slow MySQL (low memory config)
- Build failures (limited resources)

**Solutions:**
- Restart services
- Clear caches
- Rebuild from scratch if needed

### Production Issues

**Common problems:**
- High traffic spikes
- Database locks
- Cache issues

**Solutions:**
- Scale resources
- Optimize queries
- Clear caches carefully
- Monitor and alert

## Migration Path

### From Staging to Production

1. Test thoroughly on staging
2. Document all changes
3. Backup production database
4. Deploy during low traffic
5. Monitor closely
6. Have rollback plan ready

### From Production to Staging

1. Export production database
2. Anonymize sensitive data
3. Import to staging
4. Update .env settings
5. Clear caches
6. Test functionality

## Best Practices

### Staging Best Practices

✅ Keep in sync with production code
✅ Test all changes here first
✅ Use for training and demos
✅ Don't worry about uptime
✅ Experiment freely
✅ Document test results

### Production Best Practices

✅ Never test directly here
✅ Always backup before changes
✅ Monitor continuously
✅ Deploy during low traffic
✅ Have rollback plan
✅ Document all changes
✅ Keep security updated

## Quick Commands

### Check Which Server You're On

```bash
# Check hostname
hostname

# Check IP
curl -s ifconfig.me

# Check environment
cat /var/www/jobone/.env | grep APP_ENV
```

### Switch Between Servers

```bash
# To Staging
ssh -i govt-job-portal-new/.ssh/jobone2026.pem ubuntu@43.205.194.69

# To Production
ssh -i govt-job-portal-new/.ssh/jobone2026.pem ubuntu@3.108.161.67
```

## Summary

**Staging = Safe Testing Ground**
- Test everything here first
- Break things without worry
- Learn and experiment
- Low cost, low risk

**Production = Live Business**
- Real users, real data
- High availability required
- Careful changes only
- Backup everything
- Monitor constantly

**Golden Rule: Test on Staging → Deploy to Production**
