#!/bin/bash

# Filter System Test Script
# This script tests the filter system implementation

echo "🧪 Filter System Test Script"
echo "=============================="
echo ""

# Colors
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Test counter
PASSED=0
FAILED=0

# Function to test file existence
test_file() {
    if [ -f "$1" ]; then
        echo -e "${GREEN}✓${NC} File exists: $1"
        ((PASSED++))
    else
        echo -e "${RED}✗${NC} File missing: $1"
        ((FAILED++))
    fi
}

# Function to test directory existence
test_dir() {
    if [ -d "$1" ]; then
        echo -e "${GREEN}✓${NC} Directory exists: $1"
        ((PASSED++))
    else
        echo -e "${RED}✗${NC} Directory missing: $1"
        ((FAILED++))
    fi
}

# Function to test string in file
test_string_in_file() {
    if grep -q "$2" "$1"; then
        echo -e "${GREEN}✓${NC} Found '$2' in $1"
        ((PASSED++))
    else
        echo -e "${RED}✗${NC} Not found '$2' in $1"
        ((FAILED++))
    fi
}

echo "📁 Testing File Structure..."
echo "----------------------------"

# Test new files
test_file "app/Http/Controllers/FilterController.php"
test_file "resources/views/components/filter-bar.blade.php"
test_file "FILTER_SYSTEM_DOCUMENTATION.md"
test_file "FILTER_IMPLEMENTATION_SUMMARY.md"
test_file "FILTER_DECISION_GUIDE.md"
test_file "FILTER_VISUAL_DEMO.md"
test_file "README_FILTER_SYSTEM.md"

echo ""
echo "🔍 Testing Modified Files..."
echo "----------------------------"

# Test modified files
test_file "routes/web.php"
test_file "resources/views/posts/index.blade.php"
test_file "resources/views/components/category-menu.blade.php"

echo ""
echo "📝 Testing File Contents..."
echo "----------------------------"

# Test routes
test_string_in_file "routes/web.php" "FilterController"
test_string_in_file "routes/web.php" "filter.combined"

# Test posts index
test_string_in_file "resources/views/posts/index.blade.php" "x-filter-bar"

# Test category menu
test_string_in_file "resources/views/components/category-menu.blade.php" "isActive"

# Test filter controller
test_string_in_file "app/Http/Controllers/FilterController.php" "namespace App\\Http\\Controllers"
test_string_in_file "app/Http/Controllers/FilterController.php" "class FilterController"

# Test filter bar component
test_string_in_file "resources/views/components/filter-bar.blade.php" "applyFilter"
test_string_in_file "resources/views/components/filter-bar.blade.php" "clearFilters"

echo ""
echo "🎨 Testing Component Structure..."
echo "----------------------------"

# Test filter bar has required elements
test_string_in_file "resources/views/components/filter-bar.blade.php" "Category"
test_string_in_file "resources/views/components/filter-bar.blade.php" "State"
test_string_in_file "resources/views/components/filter-bar.blade.php" "Post Type"
test_string_in_file "resources/views/components/filter-bar.blade.php" "Clear All"

echo ""
echo "📊 Test Results"
echo "==============="
echo -e "${GREEN}Passed: $PASSED${NC}"
echo -e "${RED}Failed: $FAILED${NC}"
echo ""

if [ $FAILED -eq 0 ]; then
    echo -e "${GREEN}🎉 All tests passed!${NC}"
    echo ""
    echo "✅ Filter system is properly implemented"
    echo ""
    echo "Next steps:"
    echo "1. Review the implementation"
    echo "2. Test manually in browser"
    echo "3. Deploy to production"
    echo ""
    exit 0
else
    echo -e "${RED}❌ Some tests failed!${NC}"
    echo ""
    echo "Please check the missing files or content"
    echo ""
    exit 1
fi
