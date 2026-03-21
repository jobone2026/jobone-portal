#!/bin/bash

echo "🖼️  Converting Logo to WebP Format"
echo "═══════════════════════════════════════════════════════════════"
echo ""

# Navigate to images directory
cd /var/www/jobone/public/images

# Check if webp tools are installed
if ! command -v cwebp &> /dev/null; then
    echo "📦 Installing WebP tools..."
    sudo apt-get update
    sudo apt-get install -y webp
fi

# Check if logo exists
if [ ! -f "jobone-logo.png" ]; then
    echo "❌ Error: jobone-logo.png not found!"
    exit 1
fi

echo "✅ Found jobone-logo.png"
echo ""

# Get original file size
ORIGINAL_SIZE=$(du -h jobone-logo.png | cut -f1)
echo "📊 Original PNG size: $ORIGINAL_SIZE"

# Convert to WebP
echo "🔄 Converting to WebP..."
cwebp -q 90 jobone-logo.png -o jobone-logo.webp

# Check if conversion was successful
if [ -f "jobone-logo.webp" ]; then
    WEBP_SIZE=$(du -h jobone-logo.webp | cut -f1)
    echo "✅ WebP created successfully!"
    echo "📊 WebP size: $WEBP_SIZE"
    echo ""
    
    # Calculate savings
    ORIGINAL_BYTES=$(stat -f%z jobone-logo.png 2>/dev/null || stat -c%s jobone-logo.png)
    WEBP_BYTES=$(stat -f%z jobone-logo.webp 2>/dev/null || stat -c%s jobone-logo.webp)
    SAVINGS=$((ORIGINAL_BYTES - WEBP_BYTES))
    SAVINGS_KB=$((SAVINGS / 1024))
    PERCENT=$((100 - (WEBP_BYTES * 100 / ORIGINAL_BYTES)))
    
    echo "💾 Savings: ${SAVINGS_KB} KB (${PERCENT}% reduction)"
    echo ""
    
    # Set proper permissions
    sudo chown www-data:www-data jobone-logo.webp
    sudo chmod 644 jobone-logo.webp
    
    echo "✅ Permissions set correctly"
    echo ""
    echo "═══════════════════════════════════════════════════════════════"
    echo "🎉 Conversion complete!"
    echo ""
    echo "📝 Next step: Update your Blade template to use WebP"
    echo ""
    echo "Replace in resources/views/layouts/app.blade.php:"
    echo ""
    echo "FROM:"
    echo '<img src="{{ asset('"'"'images/jobone-logo.png'"'"') }}" alt="JobOne.in" class="h-10 md:h-16 w-auto object-contain">'
    echo ""
    echo "TO:"
    echo '<picture>'
    echo '    <source srcset="{{ asset('"'"'images/jobone-logo.webp'"'"') }}" type="image/webp">'
    echo '    <img src="{{ asset('"'"'images/jobone-logo.png'"'"') }}" alt="JobOne.in" class="h-10 md:h-16 w-auto object-contain">'
    echo '</picture>'
    echo ""
    echo "═══════════════════════════════════════════════════════════════"
else
    echo "❌ Error: WebP conversion failed!"
    exit 1
fi
