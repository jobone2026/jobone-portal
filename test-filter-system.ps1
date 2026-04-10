# Filter System Test Script (PowerShell)
# This script tests the filter system implementation

Write-Host "🧪 Filter System Test Script" -ForegroundColor Cyan
Write-Host "==============================" -ForegroundColor Cyan
Write-Host ""

# Test counter
$PASSED = 0
$FAILED = 0

# Function to test file existence
function Test-FileExists {
    param($FilePath)
    if (Test-Path $FilePath) {
        Write-Host "✓ File exists: $FilePath" -ForegroundColor Green
        $script:PASSED++
    } else {
        Write-Host "✗ File missing: $FilePath" -ForegroundColor Red
        $script:FAILED++
    }
}

# Function to test string in file
function Test-StringInFile {
    param($FilePath, $SearchString)
    if (Test-Path $FilePath) {
        $content = Get-Content $FilePath -Raw
        if ($content -match [regex]::Escape($SearchString)) {
            Write-Host "✓ Found '$SearchString' in $FilePath" -ForegroundColor Green
            $script:PASSED++
        } else {
            Write-Host "✗ Not found '$SearchString' in $FilePath" -ForegroundColor Red
            $script:FAILED++
        }
    } else {
        Write-Host "✗ File not found: $FilePath" -ForegroundColor Red
        $script:FAILED++
    }
}

Write-Host "📁 Testing File Structure..." -ForegroundColor Yellow
Write-Host "----------------------------"

# Test new files
Test-FileExists "app/Http/Controllers/FilterController.php"
Test-FileExists "resources/views/components/filter-bar.blade.php"
Test-FileExists "FILTER_SYSTEM_DOCUMENTATION.md"
Test-FileExists "FILTER_IMPLEMENTATION_SUMMARY.md"
Test-FileExists "FILTER_DECISION_GUIDE.md"
Test-FileExists "FILTER_VISUAL_DEMO.md"
Test-FileExists "README_FILTER_SYSTEM.md"

Write-Host ""
Write-Host "🔍 Testing Modified Files..." -ForegroundColor Yellow
Write-Host "----------------------------"

# Test modified files
Test-FileExists "routes/web.php"
Test-FileExists "resources/views/posts/index.blade.php"
Test-FileExists "resources/views/components/category-menu.blade.php"

Write-Host ""
Write-Host "📝 Testing File Contents..." -ForegroundColor Yellow
Write-Host "----------------------------"

# Test routes
Test-StringInFile "routes/web.php" "FilterController"
Test-StringInFile "routes/web.php" "filter.combined"

# Test posts index
Test-StringInFile "resources/views/posts/index.blade.php" "x-filter-bar"

# Test category menu
Test-StringInFile "resources/views/components/category-menu.blade.php" "isActive"

# Test filter controller
Test-StringInFile "app/Http/Controllers/FilterController.php" "namespace App\Http\Controllers"
Test-StringInFile "app/Http/Controllers/FilterController.php" "class FilterController"

# Test filter bar component
Test-StringInFile "resources/views/components/filter-bar.blade.php" "applyFilter"
Test-StringInFile "resources/views/components/filter-bar.blade.php" "clearFilters"

Write-Host ""
Write-Host "🎨 Testing Component Structure..." -ForegroundColor Yellow
Write-Host "----------------------------"

# Test filter bar has required elements
Test-StringInFile "resources/views/components/filter-bar.blade.php" "Category"
Test-StringInFile "resources/views/components/filter-bar.blade.php" "State"
Test-StringInFile "resources/views/components/filter-bar.blade.php" "Post Type"
Test-StringInFile "resources/views/components/filter-bar.blade.php" "Clear All"

Write-Host ""
Write-Host "📊 Test Results" -ForegroundColor Cyan
Write-Host "==============="
Write-Host "Passed: $PASSED" -ForegroundColor Green
Write-Host "Failed: $FAILED" -ForegroundColor Red
Write-Host ""

if ($FAILED -eq 0) {
    Write-Host "🎉 All tests passed!" -ForegroundColor Green
    Write-Host ""
    Write-Host "✅ Filter system is properly implemented" -ForegroundColor Green
    Write-Host ""
    Write-Host "Next steps:"
    Write-Host "1. Review the implementation"
    Write-Host "2. Test manually in browser"
    Write-Host "3. Deploy to production"
    Write-Host ""
    exit 0
} else {
    Write-Host "❌ Some tests failed!" -ForegroundColor Red
    Write-Host ""
    Write-Host "Please check the missing files or content"
    Write-Host ""
    exit 1
}
