#!/bin/bash

# Pre-Deployment Check Script
# Run this BEFORE deploying to server to ensure everything is ready

echo "╔══════════════════════════════════════════════════════════════╗"
echo "║         Pre-Deployment Check - JobOne.in SEO Fix            ║"
echo "╚══════════════════════════════════════════════════════════════╝"
echo ""

ERRORS=0
WARNINGS=0

# Check 1: OG Image exists
echo "📋 Check 1: OG Image File"
if [ -f "public/images/og-image.jpg" ]; then
    SIZE=$(stat -f%z "public/images/og-image.jpg" 2>/dev/null || stat -c%s "public/images/og-image.jpg" 2>/dev/null)
    echo "   ✅ og-image.jpg exists"
    echo "   📏 Size: $SIZE bytes ($(($SIZE / 1024))KB)"
    
    if [ $SIZE -lt 10000 ]; then
        echo "   ⚠️  WARNING: File size is very small (< 10KB)"
        WARNINGS=$((WARNINGS + 1))
    elif [ $SIZE -gt 500000 ]; then
        echo "   ⚠️  WARNING: File size is large (> 500KB), consider optimizing"
        WARNINGS=$((WARNINGS + 1))
    fi
else
    echo "   ❌ ERROR: og-image.jpg NOT FOUND in public/images/"
    echo "   → Create the image before deploying!"
    ERRORS=$((ERRORS + 1))
fi
echo ""

# Check 2: Modified files exist
echo "📋 Check 2: Modified Files"
if [ -f "app/Services/SeoService.php" ]; then
    echo "   ✅ SeoService.php exists"
    
    # Check if it contains the fix
    if grep -q "generatePostDescription" app/Services/SeoService.php; then
        echo "   ✅ Contains generatePostDescription method"
    else
        echo "   ⚠️  WARNING: Method might be missing"
        WARNINGS=$((WARNINGS + 1))
    fi
else
    echo "   ❌ ERROR: SeoService.php NOT FOUND"
    ERRORS=$((ERRORS + 1))
fi

if [ -f "resources/views/components/seo-head.blade.php" ]; then
    echo "   ✅ seo-head.blade.php exists"
    
    # Check if it contains the new meta tags
    if grep -q "og:image:width" resources/views/components/seo-head.blade.php; then
        echo "   ✅ Contains og:image:width meta tag"
    else
        echo "   ⚠️  WARNING: New meta tags might be missing"
        WARNINGS=$((WARNINGS + 1))
    fi
else
    echo "   ❌ ERROR: seo-head.blade.php NOT FOUND"
    ERRORS=$((ERRORS + 1))
fi
echo ""

# Check 3: Git status (if using git)
echo "📋 Check 3: Git Status"
if [ -d ".git" ]; then
    CHANGED=$(git status --porcelain | wc -l)
    if [ $CHANGED -gt 0 ]; then
        echo "   ℹ️  You have $CHANGED uncommitted changes"
        echo "   📝 Modified files:"
        git status --short | head -5
        if [ $CHANGED -gt 5 ]; then
            echo "   ... and $((CHANGED - 5)) more"
        fi
    else
        echo "   ✅ No uncommitted changes"
    fi
else
    echo "   ℹ️  Not a git repository"
fi
echo ""

# Check 4: Image dimensions (if ImageMagick available)
echo "📋 Check 4: Image Dimensions"
if command -v identify &> /dev/null; then
    if [ -f "public/images/og-image.jpg" ]; then
        DIMENSIONS=$(identify -format "%wx%h" public/images/og-image.jpg 2>/dev/null)
        echo "   📐 Dimensions: $DIMENSIONS"
        
        if [ "$DIMENSIONS" = "1200x630" ]; then
            echo "   ✅ Perfect! Correct OG image size"
        else
            echo "   ⚠️  WARNING: Recommended size is 1200x630"
            WARNINGS=$((WARNINGS + 1))
        fi
    fi
else
    echo "   ℹ️  ImageMagick not installed, skipping dimension check"
fi
echo ""

# Check 5: Documentation files
echo "📋 Check 5: Documentation Files"
DOCS=("DEPLOY_TO_SERVER.md" "QUICK_FIX_GUIDE.txt" "SEO_FIX_SUMMARY.md")
for doc in "${DOCS[@]}"; do
    if [ -f "$doc" ]; then
        echo "   ✅ $doc"
    else
        echo "   ⚠️  $doc missing"
        WARNINGS=$((WARNINGS + 1))
    fi
done
echo ""

# Summary
echo "╔══════════════════════════════════════════════════════════════╗"
echo "║                      Summary                                 ║"
echo "╚══════════════════════════════════════════════════════════════╝"
echo ""

if [ $ERRORS -eq 0 ] && [ $WARNINGS -eq 0 ]; then
    echo "✅ All checks passed! Ready to deploy."
    echo ""
    echo "📦 Next steps:"
    echo "   1. Commit and push changes (if using git)"
    echo "   2. Upload files to server"
    echo "   3. Update APP_URL in server .env"
    echo "   4. Clear caches on server"
    echo "   5. Test with Facebook Debugger"
    echo ""
    echo "📖 See DEPLOY_TO_SERVER.md for detailed instructions"
    exit 0
elif [ $ERRORS -eq 0 ]; then
    echo "⚠️  $WARNINGS warning(s) found, but you can proceed"
    echo ""
    echo "📦 Next steps:"
    echo "   1. Review warnings above"
    echo "   2. Upload files to server"
    echo "   3. Update APP_URL in server .env"
    echo "   4. Clear caches on server"
    echo ""
    echo "📖 See DEPLOY_TO_SERVER.md for detailed instructions"
    exit 0
else
    echo "❌ $ERRORS error(s) found! Fix before deploying."
    echo "⚠️  $WARNINGS warning(s) found."
    echo ""
    echo "🔧 Fix the errors above before deploying to server"
    exit 1
fi
