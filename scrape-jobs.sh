#!/bin/bash

# Scrape jobs from freejobalert.com
# Usage: bash scrape-jobs.sh [limit]

LIMIT=${1:-50}

echo "=========================================="
echo "Scraping FreeJobAlert.com"
echo "=========================================="
echo "Limit: $LIMIT jobs"
echo ""

cd /var/www/jobone

# Run the scraper command
php artisan scrape:freejobalert --limit=$LIMIT

echo ""
echo "=========================================="
echo "✅ Scraping Complete"
echo "=========================================="
