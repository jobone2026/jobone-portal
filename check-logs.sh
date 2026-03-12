#!/bin/bash

echo "=========================================="
echo "Checking Laravel Logs for API Errors"
echo "=========================================="

echo "Last 50 lines of Laravel log:"
echo "---"
sudo tail -n 50 storage/logs/laravel.log

echo ""
echo "=========================================="
echo "Checking PHP-FPM Error Log:"
echo "=========================================="
sudo tail -n 20 /var/log/php8.2-fpm.log

echo ""
echo "=========================================="
echo "Checking Nginx Error Log:"
echo "=========================================="
sudo tail -n 20 /var/log/nginx/error.log
