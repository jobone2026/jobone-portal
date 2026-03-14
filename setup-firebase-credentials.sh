#!/bin/bash

# Setup Firebase Credentials on Server
# Run this on your server: bash setup-firebase-credentials.sh

echo "🔧 Setting up Firebase credentials directory..."

# Create firebase directory if it doesn't exist
mkdir -p storage/app/firebase

# Set proper permissions
chmod 755 storage/app/firebase

echo "✅ Firebase directory created: storage/app/firebase"
echo ""
echo "📋 Next steps:"
echo "1. Upload your Firebase service account JSON file to:"
echo "   storage/app/firebase/jobone-firebase-adminsdk.json"
echo ""
echo "2. Set proper permissions:"
echo "   chmod 644 storage/app/firebase/jobone-firebase-adminsdk.json"
echo ""
echo "3. Install Firebase PHP SDK:"
echo "   composer require kreait/firebase-php"
echo ""
echo "4. Test notifications:"
echo "   php artisan notification:test"
echo ""
echo "✨ Done!"
