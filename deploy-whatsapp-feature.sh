#!/bin/bash

echo "🚀 Deploying WhatsApp Share Feature..."

# Copy files to production
echo "📁 Copying files..."
scp -i .ssh/jobone2026.pem app/Console/Commands/ShareToWhatsApp.php ubuntu@3.108.161.67:/tmp/
scp -i .ssh/jobone2026.pem app/Http/Controllers/Admin/WhatsAppController.php ubuntu@3.108.161.67:/tmp/
scp -i .ssh/jobone2026.pem resources/views/admin/whatsapp/index.blade.php ubuntu@3.108.161.67:/tmp/
scp -i .ssh/jobone2026.pem routes/admin.php ubuntu@3.108.161.67:/tmp/
scp -i .ssh/jobone2026.pem resources/views/layouts/admin.blade.php ubuntu@3.108.161.67:/tmp/

# Move files and set permissions
echo "🔧 Installing files..."
ssh -i .ssh/jobone2026.pem ubuntu@3.108.161.67 << 'ENDSSH'
sudo mv /tmp/ShareToWhatsApp.php /var/www/jobone/app/Console/Commands/
sudo mv /tmp/WhatsAppController.php /var/www/jobone/app/Http/Controllers/Admin/
sudo mkdir -p /var/www/jobone/resources/views/admin/whatsapp
sudo mv /tmp/index.blade.php /var/www/jobone/resources/views/admin/whatsapp/
sudo mv /tmp/admin.php /var/www/jobone/routes/
sudo mv /tmp/admin.blade.php /var/www/jobone/resources/views/layouts/

# Set permissions
sudo chown -R www-data:www-data /var/www/jobone/app/Console/Commands/ShareToWhatsApp.php
sudo chown -R www-data:www-data /var/www/jobone/app/Http/Controllers/Admin/WhatsAppController.php
sudo chown -R www-data:www-data /var/www/jobone/resources/views/admin/whatsapp/
sudo chown -R www-data:www-data /var/www/jobone/routes/admin.php
sudo chown -R www-data:www-data /var/www/jobone/resources/views/layouts/admin.blade.php

# Clear caches
cd /var/www/jobone
sudo -u www-data php artisan cache:clear
sudo -u www-data php artisan config:clear
sudo -u www-data php artisan view:clear
sudo -u www-data php artisan route:clear

# Restart PHP
sudo systemctl restart php8.2-fpm

echo "✅ Deployment complete!"
echo ""
echo "📱 Access the feature at: https://jobone.in/admin/whatsapp"
echo ""
echo "🧪 Test the CLI command:"
echo "   sudo -u www-data php artisan share:whatsapp --latest"
ENDSSH

echo ""
echo "✅ WhatsApp Share Feature deployed successfully!"
echo "📖 Read WHATSAPP-SHARE-GUIDE.md for usage instructions"
