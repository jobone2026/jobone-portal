#!/bin/bash
# Fix for 7 AM 500 error - Ensure storage is healthy before any operations

set -e

echo "🔧 Pre-operation Storage Check (7 AM Fix)"
echo "=========================================="

# Ensure all storage directories exist
mkdir -p /var/www/jobone/storage/framework/{views,cache,sessions}
mkdir -p /var/www/jobone/storage/logs
mkdir -p /var/www/jobone/storage/app

# Fix permissions
chown -R www-data:www-data /var/www/jobone/storage
chmod -R 775 /var/www/jobone/storage

# Clear old compiled views (but keep directory)
rm -f /var/www/jobone/storage/framework/views/*.php 2>/dev/null || true

# Clear old sessions (but keep directory)
find /var/www/jobone/storage/framework/sessions -type f -mtime +7 -delete 2>/dev/null || true

# Clear old cache files (but keep directory)
find /var/www/jobone/storage/framework/cache -type f -mtime +7 -delete 2>/dev/null || true

# Restart PHP-FPM to clear any stale processes
systemctl restart php8.2-fpm

echo "✅ Storage check complete - All directories healthy"
echo "✅ PHP-FPM restarted"
