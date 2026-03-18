#!/bin/bash
# Quick deployment script - copy and paste this entire block into server terminal

cd /var/www/jobone && \
git stash && \
git pull origin main && \
php artisan config:clear && \
php artisan cache:clear && \
php artisan view:clear && \
php artisan route:clear && \
sudo systemctl restart php8.2-fpm && \
echo "" && \
echo "=== TESTING KARNATAKAJOB.ONLINE (should show ONLY Karnataka) ===" && \
curl -s https://karnatakajob.online | grep -o 'state-box">[^<]*</a' | head -5 && \
echo "" && \
echo "=== TESTING JOBONE.IN (should show ALL states) ===" && \
curl -s https://jobone.in | grep -o 'state-box">[^<]*</a' | head -5 && \
echo "" && \
echo "Deployment complete!"
