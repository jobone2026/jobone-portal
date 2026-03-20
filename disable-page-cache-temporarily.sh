#!/bin/bash

# Temporarily disable PageCache to see UI changes

echo "🔧 Disabling PageCache middleware temporarily..."

# Backup the original middleware
cp /var/www/jobone/app/Http/Middleware/PageCache.php /var/www/jobone/app/Http/Middleware/PageCache.php.backup

# Replace the handle method to bypass caching
cat > /tmp/pagecache_temp.php << 'EOF'
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PageCache
{
    public function handle(Request $request, Closure $next): Response
    {
        // TEMPORARILY DISABLED FOR UI TESTING
        return $next($request);
    }
    
    private function getCacheTTL(Request $request): int
    {
        return 3600;
    }
}
EOF

# Replace the middleware file
sudo cp /tmp/pagecache_temp.php /var/www/jobone/app/Http/Middleware/PageCache.php

# Clear all caches
sudo php artisan cache:clear
sudo php artisan view:clear
sudo php artisan config:clear

# Restart services
sudo service php8.2-fpm restart
sudo service nginx restart

echo "✅ PageCache disabled! Now refresh your browser."
echo ""
echo "⚠️  IMPORTANT: To re-enable PageCache later, run:"
echo "   sudo cp /var/www/jobone/app/Http/Middleware/PageCache.php.backup /var/www/jobone/app/Http/Middleware/PageCache.php"
