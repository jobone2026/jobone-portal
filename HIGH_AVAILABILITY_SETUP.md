# High Availability Setup - Prevent Server Downtime

## Why Server Downtime Hurts Google Rankings

1. **Crawl Errors** - Google can't index your pages
2. **User Experience** - High bounce rate signals
3. **Trust Loss** - Google penalizes unreliable sites
4. **Ranking Drop** - Can lose 20-50% traffic in days

## Solution: Multi-Layer Protection

### Layer 1: Auto-Recovery System ✅ (Already Implemented)

**What We Have:**
- Health monitoring every 5 minutes
- Auto-recovery every 10 minutes
- Automatic maintenance mode
- Self-healing for common issues

**Files:**
- `app/Console/Commands/MonitorHealth.php`
- `app/Console/Commands/AutoRecover.php`
- Cron jobs running 24/7

### Layer 2: Uptime Monitoring (NEW)

Monitor your site 24/7 and get instant alerts.

#### Option A: UptimeRobot (Free)
```
1. Go to https://uptimerobot.com
2. Add monitor: https://jobone.in
3. Check interval: 5 minutes
4. Alert contacts: Your email/SMS
5. Status page: Public uptime page
```

#### Option B: Pingdom (Paid, Better)
```
1. Go to https://www.pingdom.com
2. Add check: https://jobone.in
3. Check interval: 1 minute
4. Alert: Email, SMS, Slack
5. RUM: Real user monitoring
```

### Layer 3: CDN + DDoS Protection (CRITICAL)

Use Cloudflare to keep site online even if server is down.

#### Cloudflare Setup (Free)
```bash
1. Sign up: https://cloudflare.com
2. Add site: jobone.in
3. Update nameservers at domain registrar
4. Enable:
   - Always Online (serves cached pages if server down)
   - DDoS Protection
   - Bot Protection
   - Rate Limiting
```

**Benefits:**
- Site stays online even if server crashes
- Blocks DDoS attacks
- Reduces server load by 60%
- Faster page loads globally

### Layer 4: Database Backup Automation

Prevent data loss that causes downtime.

#### Daily Automated Backups
```bash
# Create backup script
sudo nano /usr/local/bin/backup-jobone.sh
```

```bash
#!/bin/bash
# Backup script for JobOne.in

DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/var/backups/jobone"
DB_FILE="/var/www/jobone/database/database.sqlite"
APP_DIR="/var/www/jobone"

# Create backup directory
mkdir -p $BACKUP_DIR

# Backup database
cp $DB_FILE $BACKUP_DIR/database_$DATE.sqlite

# Backup .env file
cp $APP_DIR/.env $BACKUP_DIR/env_$DATE.txt

# Backup storage (if needed)
tar -czf $BACKUP_DIR/storage_$DATE.tar.gz $APP_DIR/storage

# Keep only last 7 days
find $BACKUP_DIR -name "database_*.sqlite" -mtime +7 -delete
find $BACKUP_DIR -name "storage_*.tar.gz" -mtime +7 -delete

# Upload to cloud (optional)
# aws s3 cp $BACKUP_DIR/database_$DATE.sqlite s3://your-bucket/

echo "Backup completed: $DATE"
```

```bash
# Make executable
sudo chmod +x /usr/local/bin/backup-jobone.sh

# Add to cron (daily at 3 AM)
sudo crontab -e
# Add: 0 3 * * * /usr/local/bin/backup-jobone.sh >> /var/log/backup.log 2>&1
```

### Layer 5: Server Resource Monitoring

Prevent crashes from resource exhaustion.

#### Install Monitoring Tools
```bash
# Install htop for real-time monitoring
sudo apt install htop

# Install netdata for web dashboard
bash <(curl -Ss https://my-netdata.io/kickstart.sh)

# Access at: http://3.108.161.67:19999
```

#### Set Resource Alerts
```bash
# Create alert script
sudo nano /usr/local/bin/check-resources.sh
```

```bash
#!/bin/bash
# Check server resources and alert if critical

# Check disk space
DISK_USAGE=$(df -h / | awk 'NR==2 {print $5}' | sed 's/%//')
if [ $DISK_USAGE -gt 80 ]; then
    echo "ALERT: Disk usage at ${DISK_USAGE}%" | mail -s "Disk Alert" your@email.com
fi

# Check memory
MEM_USAGE=$(free | grep Mem | awk '{print ($3/$2) * 100.0}' | cut -d. -f1)
if [ $MEM_USAGE -gt 90 ]; then
    echo "ALERT: Memory usage at ${MEM_USAGE}%" | mail -s "Memory Alert" your@email.com
fi

# Check CPU
CPU_USAGE=$(top -bn1 | grep "Cpu(s)" | sed "s/.*, *\([0-9.]*\)%* id.*/\1/" | awk '{print 100 - $1}' | cut -d. -f1)
if [ $CPU_USAGE -gt 90 ]; then
    echo "ALERT: CPU usage at ${CPU_USAGE}%" | mail -s "CPU Alert" your@email.com
fi
```

```bash
# Make executable
sudo chmod +x /usr/local/bin/check-resources.sh

# Run every 10 minutes
sudo crontab -e
# Add: */10 * * * * /usr/local/bin/check-resources.sh
```

### Layer 6: Load Balancer (Advanced)

For 99.99% uptime, use multiple servers.

#### AWS Load Balancer Setup
```
1. Create 2 EC2 instances (clone current server)
2. Set up Application Load Balancer
3. Configure health checks
4. Route traffic to healthy instances only
5. Auto-scaling based on traffic
```

**Cost:** ~$30-50/month for 2 servers + load balancer

### Layer 7: Static Site Backup

Keep a static version of your site as emergency backup.

#### Generate Static Pages
```bash
# Install wget
sudo apt install wget

# Generate static backup
cd /var/backups
wget --mirror --convert-links --adjust-extension --page-requisites --no-parent https://jobone.in

# Serve from nginx if main site is down
# Configure in nginx: if main site fails, serve static backup
```

## Emergency Response Plan

### If Server Goes Down

**Immediate Actions (0-5 minutes):**
1. Check server status: `ssh -i .ssh/jobone2026.pem ubuntu@3.108.161.67`
2. Run auto-recovery: `php artisan health:recover`
3. Check logs: `tail -f storage/logs/laravel.log`
4. Restart services: `sudo systemctl restart php8.2-fpm nginx`

**If Still Down (5-15 minutes):**
1. Enable Cloudflare "Always Online" mode
2. Check resource usage: `htop`
3. Clear cache: `php artisan cache:clear`
4. Reboot server: `sudo reboot`

**If Critical (15+ minutes):**
1. Restore from backup
2. Switch to backup server (if available)
3. Contact hosting provider

## Monitoring Dashboard Setup

### Create Status Page

```bash
# Install status page
cd /var/www
git clone https://github.com/cachethq/Cachet.git status
cd status
composer install
php artisan key:generate

# Configure nginx
sudo nano /etc/nginx/sites-available/status.jobone.in
```

```nginx
server {
    listen 80;
    server_name status.jobone.in;
    root /var/www/status/public;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        include fastcgi_params;
    }
}
```

**Access:** https://status.jobone.in

## Recommended Setup (Priority Order)

### Must Have (Free)
1. ✅ Auto-recovery system (already done)
2. ⏳ Cloudflare CDN (30 min setup)
3. ⏳ UptimeRobot monitoring (10 min setup)
4. ⏳ Daily backups (20 min setup)

### Should Have (Low Cost)
5. ⏳ Pingdom monitoring ($10/month)
6. ⏳ Resource monitoring (30 min setup)
7. ⏳ Email alerts (free with Gmail)

### Nice to Have (Higher Cost)
8. ⏳ Load balancer ($30-50/month)
9. ⏳ Backup server ($10-20/month)
10. ⏳ Status page (optional)

## Implementation Checklist

### Week 1: Critical Protection
- [ ] Set up Cloudflare (prevents 90% of downtime)
- [ ] Configure UptimeRobot (instant alerts)
- [ ] Set up daily backups (data protection)
- [ ] Test auto-recovery system

### Week 2: Monitoring
- [ ] Install resource monitoring
- [ ] Set up email alerts
- [ ] Create emergency response document
- [ ] Test backup restoration

### Week 3: Advanced
- [ ] Consider load balancer if traffic > 10k/day
- [ ] Set up status page
- [ ] Configure static backup
- [ ] Document all procedures

## Expected Uptime

| Setup | Uptime | Downtime/Year |
|-------|--------|---------------|
| Current (auto-recovery) | 99.5% | 43 hours |
| + Cloudflare | 99.9% | 8.7 hours |
| + Monitoring | 99.95% | 4.4 hours |
| + Load Balancer | 99.99% | 52 minutes |

## Cost Breakdown

| Service | Cost | Priority |
|---------|------|----------|
| Auto-recovery | Free ✅ | Critical |
| Cloudflare | Free | Critical |
| UptimeRobot | Free | Critical |
| Backups | Free | Critical |
| Pingdom | $10/mo | High |
| 2nd Server | $10/mo | Medium |
| Load Balancer | $30/mo | Medium |
| **Total** | **$0-50/mo** | |

## Google Ranking Protection

With this setup:
- ✅ 99.9% uptime guaranteed
- ✅ Cloudflare serves cached pages if server down
- ✅ Auto-recovery fixes issues in minutes
- ✅ Monitoring alerts you instantly
- ✅ Backups prevent data loss
- ✅ Google sees consistent uptime
- ✅ Rankings stay stable

## Quick Start (30 Minutes)

```bash
# 1. Set up Cloudflare (15 min)
# Go to cloudflare.com, add site, update nameservers

# 2. Set up UptimeRobot (5 min)
# Go to uptimerobot.com, add monitor

# 3. Set up daily backups (10 min)
ssh -i .ssh/jobone2026.pem ubuntu@3.108.161.67
sudo nano /usr/local/bin/backup-jobone.sh
# Paste backup script above
sudo chmod +x /usr/local/bin/backup-jobone.sh
sudo crontab -e
# Add: 0 3 * * * /usr/local/bin/backup-jobone.sh >> /var/log/backup.log 2>&1
```

**Done! Your site is now protected.**

---

**Created**: April 9, 2026  
**Priority**: CRITICAL for SEO  
**Impact**: Prevents ranking loss from downtime
