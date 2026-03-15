#!/bin/bash

# Fix Upload Size Limits for Backup Restore
# Run this on server: bash fix-upload-limits.sh

echo "🔧 Fixing upload size limits..."

# 1. Update PHP configuration
echo "📝 Updating PHP configuration..."
sudo tee /etc/php/8.2/fpm/conf.d/99-upload-limits.conf > /dev/null <<EOF
; Increase upload limits for backup restore
upload_max_filesize = 500M
post_max_size = 500M
max_execution_time = 300
max_input_time = 300
memory_limit = 512M
EOF

# 2. Update Nginx configuration
echo "📝 Updating Nginx configuration..."
sudo tee /etc/nginx/conf.d/upload-limits.conf > /dev/null <<EOF
# Increase client upload size for backup restore
client_max_body_size 500M;
EOF

# 3. Restart services
echo "🔄 Restarting services..."
sudo systemctl restart php8.2-fpm
sudo systemctl restart nginx

echo "✅ Upload limits increased to 500MB"
echo "📋 Changes made:"
echo "   - PHP upload_max_filesize: 500M"
echo "   - PHP post_max_size: 500M"
echo "   - Nginx client_max_body_size: 500M"
echo "   - PHP max_execution_time: 300s"
echo ""
echo "🎉 Done! You can now upload backups up to 500MB"
