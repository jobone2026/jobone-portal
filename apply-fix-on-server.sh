#!/bin/bash

# This script applies the delete fix directly on the server
# Run this on your server: bash apply-fix-on-server.sh

echo "🔧 Applying category and state delete fix..."

cd /var/www/jobone

# Backup current files
echo "📦 Creating backup..."
cp resources/views/admin/categories/index.blade.php resources/views/admin/categories/index.blade.php.backup
cp resources/views/admin/states/index.blade.php resources/views/admin/states/index.blade.php.backup

# Fix states view - change id to slug
echo "🔨 Fixing states view..."
sed -i "s/onclick=\"confirmDeleteState({{ \$st->id }})\"/onclick=\"confirmDeleteState('{{ \$st->slug }}')\"/" resources/views/admin/states/index.blade.php
sed -i 's/function confirmDeleteState(id) {/function confirmDeleteState(slug) {/' resources/views/admin/states/index.blade.php

# Fix categories view - change id to slug  
echo "🔨 Fixing categories view..."
sed -i "s/onclick=\"confirmDeleteCategory({{ \$cat->id }})\"/onclick=\"confirmDeleteCategory('{{ \$cat->slug }}')\"/" resources/views/admin/categories/index.blade.php
sed -i 's/function confirmDeleteCategory(id) {/function confirmDeleteCategory(slug) {/' resources/views/admin/categories/index.blade.php

# Clear caches
echo "🧹 Clearing caches..."
php artisan view:clear
php artisan config:clear

# Restart PHP-FPM
echo "🔄 Restarting PHP-FPM..."
sudo systemctl restart php8.2-fpm

echo "✅ Fix applied successfully!"
echo ""
echo "Backups saved as:"
echo "  - resources/views/admin/categories/index.blade.php.backup"
echo "  - resources/views/admin/states/index.blade.php.backup"
echo ""
echo "Test at:"
echo "  - https://jobone.in/admin/categories"
echo "  - https://jobone.in/admin/states"
