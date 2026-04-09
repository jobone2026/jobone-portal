#!/bin/bash
# High Availability Setup Script for JobOne.in
# Prevents server downtime and protects Google rankings

echo "================================================"
echo "JobOne.in High Availability Setup"
echo "================================================"
echo ""

# Check if running as root
if [ "$EUID" -ne 0 ]; then 
    echo "Please run with sudo: sudo bash setup-high-availability.sh"
    exit 1
fi

# 1. Create backup script
echo "📦 Setting up automated backups..."
cat > /usr/local/bin/backup-jobone.sh << 'EOF'
#!/bin/bash
# Automated backup for JobOne.in

DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/var/backups/jobone"
DB_FILE="/var/www/jobone/database/database.sqlite"
APP_DIR="/var/www/jobone"

# Create backup directory
mkdir -p $BACKUP_DIR

# Backup database
if [ -f "$DB_FILE" ]; then
    cp $DB_FILE $BACKUP_DIR/database_$DATE.sqlite
    echo "✅ Database backed up"
fi

# Backup .env file
if [ -f "$APP_DIR/.env" ]; then
    cp $APP_DIR/.env $BACKUP_DIR/env_$DATE.txt
    echo "✅ .env backed up"
fi

# Backup storage (important files only)
if [ -d "$APP_DIR/storage" ]; then
    tar -czf $BACKUP_DIR/storage_$DATE.tar.gz $APP_DIR/storage/app $APP_DIR/storage/logs 2>/dev/null
    echo "✅ Storage backed up"
fi

# Keep only last 7 days
find $BACKUP_DIR -name "database_*.sqlite" -mtime +7 -delete 2>/dev/null
find $BACKUP_DIR -name "storage_*.tar.gz" -mtime +7 -delete 2>/dev/null
find $BACKUP_DIR -name "env_*.txt" -mtime +7 -delete 2>/dev/null

echo "✅ Backup completed: $DATE"
echo "📁 Location: $BACKUP_DIR"
EOF

chmod +x /usr/local/bin/backup-jobone.sh
echo "✅ Backup script created"

# 2. Add backup to cron
echo "⏰ Adding backup to cron (daily at 3 AM)..."
(crontab -l 2>/dev/null | grep -v "backup-jobone.sh"; echo "0 3 * * * /usr/local/bin/backup-jobone.sh >> /var/log/backup.log 2>&1") | crontab -
echo "✅ Backup cron job added"

# 3. Create resource monitoring script
echo "📊 Setting up resource monitoring..."
cat > /usr/local/bin/check-resources.sh << 'EOF'
#!/bin/bash
# Monitor server resources

LOG_FILE="/var/log/resource-alerts.log"

# Check disk space
DISK_USAGE=$(df -h / | awk 'NR==2 {print $5}' | sed 's/%//')
if [ $DISK_USAGE -gt 80 ]; then
    echo "$(date): ALERT - Disk usage at ${DISK_USAGE}%" >> $LOG_FILE
fi

# Check memory
MEM_USAGE=$(free | grep Mem | awk '{print int(($3/$2) * 100)}')
if [ $MEM_USAGE -gt 90 ]; then
    echo "$(date): ALERT - Memory usage at ${MEM_USAGE}%" >> $LOG_FILE
fi

# Check if services are running
if ! systemctl is-active --quiet php8.2-fpm; then
    echo "$(date): CRITICAL - PHP-FPM is down! Restarting..." >> $LOG_FILE
    systemctl restart php8.2-fpm
fi

if ! systemctl is-active --quiet nginx; then
    echo "$(date): CRITICAL - Nginx is down! Restarting..." >> $LOG_FILE
    systemctl restart nginx
fi
EOF

chmod +x /usr/local/bin/check-resources.sh
echo "✅ Resource monitoring script created"

# 4. Add resource monitoring to cron
echo "⏰ Adding resource monitoring to cron (every 10 minutes)..."
(crontab -l 2>/dev/null | grep -v "check-resources.sh"; echo "*/10 * * * * /usr/local/bin/check-resources.sh") | crontab -
echo "✅ Resource monitoring cron job added"

# 5. Create emergency recovery script
echo "🚨 Creating emergency recovery script..."
cat > /usr/local/bin/emergency-recovery.sh << 'EOF'
#!/bin/bash
# Emergency recovery for JobOne.in

echo "🚨 Starting emergency recovery..."

cd /var/www/jobone

# Fix permissions
echo "🔧 Fixing permissions..."
chown -R www-data:www-data storage bootstrap
chmod -R 775 storage bootstrap

# Recreate critical directories
echo "📁 Recreating directories..."
mkdir -p bootstrap/cache
mkdir -p storage/framework/{cache,views,sessions}
mkdir -p storage/logs

# Clear and rebuild caches
echo "🧹 Clearing caches..."
sudo -u www-data php artisan config:clear
sudo -u www-data php artisan cache:clear
sudo -u www-data php artisan view:clear
sudo -u www-data php artisan config:cache

# Restart services
echo "🔄 Restarting services..."
systemctl restart php8.2-fpm
systemctl restart nginx

# Test site
echo "🧪 Testing site..."
HTTP_CODE=$(curl -s -o /dev/null -w "%{http_code}" https://jobone.in/)
if [ $HTTP_CODE -eq 200 ]; then
    echo "✅ Site is UP! (HTTP $HTTP_CODE)"
else
    echo "❌ Site is DOWN! (HTTP $HTTP_CODE)"
fi

echo "✅ Emergency recovery completed"
EOF

chmod +x /usr/local/bin/emergency-recovery.sh
echo "✅ Emergency recovery script created"

# 6. Test backup
echo ""
echo "🧪 Testing backup system..."
/usr/local/bin/backup-jobone.sh

# 7. Install monitoring tools (optional)
echo ""
echo "📊 Installing monitoring tools..."
apt-get update -qq
apt-get install -y htop iotop nethogs -qq 2>/dev/null
echo "✅ Monitoring tools installed (htop, iotop, nethogs)"

# 8. Summary
echo ""
echo "================================================"
echo "✅ High Availability Setup Complete!"
echo "================================================"
echo ""
echo "📋 What's Installed:"
echo "  ✅ Automated daily backups (3 AM)"
echo "  ✅ Resource monitoring (every 10 minutes)"
echo "  ✅ Auto-service restart if down"
echo "  ✅ Emergency recovery script"
echo "  ✅ Monitoring tools (htop, iotop)"
echo ""
echo "📁 Important Files:"
echo "  • Backups: /var/backups/jobone/"
echo "  • Logs: /var/log/backup.log"
echo "  • Alerts: /var/log/resource-alerts.log"
echo ""
echo "🔧 Manual Commands:"
echo "  • Run backup: sudo /usr/local/bin/backup-jobone.sh"
echo "  • Emergency recovery: sudo /usr/local/bin/emergency-recovery.sh"
echo "  • Check resources: htop"
echo "  • View alerts: tail -f /var/log/resource-alerts.log"
echo ""
echo "⚠️  NEXT STEPS (CRITICAL):"
echo "  1. Set up Cloudflare (https://cloudflare.com)"
echo "     - Add jobone.in to Cloudflare"
echo "     - Update nameservers"
echo "     - Enable 'Always Online' mode"
echo ""
echo "  2. Set up UptimeRobot (https://uptimerobot.com)"
echo "     - Add monitor for https://jobone.in"
echo "     - Set check interval: 5 minutes"
echo "     - Add your email for alerts"
echo ""
echo "  3. Test the system:"
echo "     - Check backup: ls -lh /var/backups/jobone/"
echo "     - Test recovery: sudo /usr/local/bin/emergency-recovery.sh"
echo ""
echo "================================================"
echo "Your site is now protected! 🛡️"
echo "================================================"
