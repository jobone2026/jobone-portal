#!/bin/bash

# Traffic Drop Diagnostic Script
# Run this to quickly check all potential issues

echo "=================================================="
echo "🔍 JOBONE.IN TRAFFIC DROP DIAGNOSTIC"
echo "=================================================="
echo ""

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# 1. Check if site is accessible
echo "1️⃣  Checking if site is accessible..."
if curl -s -o /dev/null -w "%{http_code}" https://jobone.in/ | grep -q "200"; then
    echo -e "${GREEN}✅ Site is accessible (HTTP 200)${NC}"
else
    echo -e "${RED}❌ Site is NOT accessible!${NC}"
fi
echo ""

# 2. Check robots.txt
echo "2️⃣  Checking robots.txt..."
echo "Fetching: https://jobone.in/robots.txt"
curl -s https://jobone.in/robots.txt | head -20
echo ""
if curl -s https://jobone.in/robots.txt | grep -q "Disallow: /\*.xml"; then
    echo -e "${RED}❌ WARNING: robots.txt blocks XML files (sitemaps)!${NC}"
else
    echo -e "${GREEN}✅ robots.txt looks good${NC}"
fi
echo ""

# 3. Check sitemaps
echo "3️⃣  Checking sitemaps..."
for sitemap in "sitemap.xml" "sitemap-news.xml" "sitemap-posts.xml"; do
    status=$(curl -s -o /dev/null -w "%{http_code}" "https://jobone.in/$sitemap")
    if [ "$status" = "200" ]; then
        echo -e "${GREEN}✅ $sitemap - OK (HTTP $status)${NC}"
    else
        echo -e "${RED}❌ $sitemap - FAILED (HTTP $status)${NC}"
    fi
done
echo ""

# 4. Check .env for GA tracking
echo "4️⃣  Checking Google Analytics configuration..."
if grep -q "GA_TRACKING_ID=" .env; then
    ga_id=$(grep "GA_TRACKING_ID=" .env | cut -d '=' -f2)
    if [ -z "$ga_id" ]; then
        echo -e "${RED}❌ GA_TRACKING_ID is empty in .env${NC}"
    else
        echo -e "${GREEN}✅ GA_TRACKING_ID is set: $ga_id${NC}"
    fi
else
    echo -e "${RED}❌ GA_TRACKING_ID not found in .env${NC}"
    echo -e "${YELLOW}   Add this line to .env: GA_TRACKING_ID=G-XXXXXXXXXX${NC}"
fi
echo ""

# 5. Check database connection
echo "5️⃣  Checking database connection..."
if php artisan tinker --execute="DB::connection()->getPdo(); echo 'OK';" 2>/dev/null | grep -q "OK"; then
    echo -e "${GREEN}✅ Database connection OK${NC}"
else
    echo -e "${RED}❌ Database connection FAILED${NC}"
fi
echo ""

# 6. Check recent posts
echo "6️⃣  Checking recent posts (last 7 days)..."
recent_posts=$(php artisan tinker --execute="echo \App\Models\Post::where('created_at', '>=', now()->subDays(7))->count();" 2>/dev/null | tail -1)
if [ "$recent_posts" -gt 0 ]; then
    echo -e "${GREEN}✅ Found $recent_posts posts in last 7 days${NC}"
else
    echo -e "${YELLOW}⚠️  No posts created in last 7 days${NC}"
fi
echo ""

# 7. Check PHP-FPM status
echo "7️⃣  Checking PHP-FPM status..."
if systemctl is-active --quiet php8.2-fpm 2>/dev/null; then
    echo -e "${GREEN}✅ PHP 8.2 FPM is running${NC}"
elif systemctl is-active --quiet php-fpm 2>/dev/null; then
    echo -e "${GREEN}✅ PHP-FPM is running${NC}"
else
    echo -e "${YELLOW}⚠️  Cannot determine PHP-FPM status (may need sudo)${NC}"
fi
echo ""

# 8. Check web server status
echo "8️⃣  Checking web server status..."
if systemctl is-active --quiet apache2 2>/dev/null; then
    echo -e "${GREEN}✅ Apache is running${NC}"
elif systemctl is-active --quiet nginx 2>/dev/null; then
    echo -e "${GREEN}✅ Nginx is running${NC}"
else
    echo -e "${YELLOW}⚠️  Cannot determine web server status (may need sudo)${NC}"
fi
echo ""

# 9. Check disk space
echo "9️⃣  Checking disk space..."
disk_usage=$(df -h . | awk 'NR==2 {print $5}' | sed 's/%//')
if [ "$disk_usage" -lt 90 ]; then
    echo -e "${GREEN}✅ Disk space OK ($disk_usage% used)${NC}"
else
    echo -e "${RED}❌ Disk space critical ($disk_usage% used)${NC}"
fi
echo ""

# 10. Check Laravel logs for errors
echo "🔟 Checking recent Laravel errors..."
if [ -f "storage/logs/laravel.log" ]; then
    error_count=$(grep -c "ERROR" storage/logs/laravel.log 2>/dev/null || echo "0")
    if [ "$error_count" -gt 0 ]; then
        echo -e "${YELLOW}⚠️  Found $error_count errors in laravel.log${NC}"
        echo "   Last 5 errors:"
        grep "ERROR" storage/logs/laravel.log | tail -5
    else
        echo -e "${GREEN}✅ No recent errors in laravel.log${NC}"
    fi
else
    echo -e "${YELLOW}⚠️  laravel.log not found${NC}"
fi
echo ""

# Summary
echo "=================================================="
echo "📊 DIAGNOSTIC SUMMARY"
echo "=================================================="
echo ""
echo "Next steps:"
echo "1. Review TRAFFIC-DROP-ANALYSIS.md for detailed analysis"
echo "2. Follow IMMEDIATE-RECOVERY-CHECKLIST.md step by step"
echo "3. Check Google Search Console for penalties/errors"
echo "4. Monitor recovery over next 7 days"
echo ""
echo "Critical actions:"
echo "- Add GA_TRACKING_ID to .env if missing"
echo "- Submit sitemaps to Google Search Console"
echo "- Request indexing for key pages"
echo "- Clear all caches: php artisan cache:clear"
echo ""
echo "=================================================="
