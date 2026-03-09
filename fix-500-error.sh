#!/bin/bash

echo "=== Fixing 500 Internal Server Error ==="
echo ""

# Navigate to application directory
cd /var/www/jobone

# 1. Check Laravel logs
echo "1. Checking Laravel error logs..."
if [ -f storage/logs/laravel.log ]; then
    echo "Last 30 lines of laravel.log:"
    tail -n 30 storage/logs/laravel.log
else
    echo "No laravel.log found"
fi
echo ""

# 2. Check Nginx error logs
echo "2. Checking Nginx error logs..."
sudo tail -n 20 /var/log/nginx/error.log
echo ""

# 3. Fix permissions (common cause of 500 errors)
echo "3. Fixing permissions..."
sudo chown -R www-data:www-data /var/www/jobone
sudo chmod -R 755 /var/www/jobone
sudo chmod -R 775 /var/www/jobone/storage
sudo chmod -R 775 /var/www/jobone/bootstrap/cache
echo "Permissions fixed"
echo ""

# 4. Clear all caches
echo "4. Clearing all caches..."
sudo -u www-data php artisan cache:clear
sudo -u www-data php artisan config:clear
sudo -u www-data php artisan route:clear
sudo -u www-data php artisan view:clear
echo "Caches cleared"
echo ""

# 5. Check .env file exists and has APP_KEY
echo "5. Checking .env configuration..."
if [ ! -f .env ]; then
    echo "ERROR: .env file not found!"
    echo "Copying from .env.example..."
    cp .env.example .env
fi

if ! grep -q "APP_KEY=base64:" .env; then
    echo "APP_KEY not set. Generating..."
    sudo -u www-data php artisan key:generate
else
    echo "APP_KEY is set"
fi
echo ""

# 6. Verify database connection
echo "6. Testing database connection..."
DB_HOST=$(grep DB_HOST .env | cut -d '=' -f2)
DB_DATABASE=$(grep DB_DATABASE .env | cut -d '=' -f2)
DB_USERNAME=$(grep DB_USERNAME .env | cut -d '=' -f2)
DB_PASSWORD=$(grep DB_PASSWORD .env | cut -d '=' -f2)

echo "Database: $DB_DATABASE"
echo "User: $DB_USERNAME"
echo "Host: $DB_HOST"

mysql -h "$DB_HOST" -u "$DB_USERNAME" -p"$DB_PASSWORD" -e "USE $DB_DATABASE; SELECT 'Connection successful' as status;" 2>&1
echo ""

# 7. Check if migrations are run
echo "7. Checking database tables..."
TABLE_COUNT=$(mysql -h "$DB_HOST" -u "$DB_USERNAME" -p"$DB_PASSWORD" -D "$DB_DATABASE" -se "SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = '$DB_DATABASE';")
echo "Tables found: $TABLE_COUNT"

if [ "$TABLE_COUNT" -lt 5 ]; then
    echo "Running migrations..."
    sudo -u www-data php artisan migrate --force
fi
echo ""

# 8. Optimize application
echo "8. Optimizing application..."
sudo -u www-data php artisan config:cache
sudo -u www-data php artisan route:cache
sudo -u www-data php artisan view:cache
echo "Optimization complete"
echo ""

# 9. Restart services
echo "9. Restarting services..."
sudo systemctl restart php8.2-fpm
sudo systemctl restart nginx
echo "Services restarted"
echo ""

# 10. Test PHP-FPM
echo "10. Checking PHP-FPM status..."
sudo systemctl status php8.2-fpm --no-pager | head -n 10
echo ""

echo "=== Fix Complete ==="
echo ""
echo "Now try accessing: http://3.108.161.67"
echo ""
echo "If still getting 500 error, check the logs above for specific error messages"
