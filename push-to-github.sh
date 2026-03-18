#!/bin/bash

echo "=========================================="
echo "Push Domain Filtering to GitHub"
echo "=========================================="
echo ""

# Check if git is initialized
if [ ! -d ".git" ]; then
    echo "❌ Error: Not a git repository"
    echo "Run: git init"
    exit 1
fi

# Check git status
echo "1. Checking git status..."
git status
echo ""

# Add all changes
echo "2. Adding all changes..."
git add .
echo "✓ Changes staged"
echo ""

# Show what will be committed
echo "3. Changes to be committed:"
git diff --cached --name-only
echo ""

# Commit
echo "4. Committing changes..."
git commit -m "feat: Add domain-based state filtering for karnatakajob.online

- Add DomainStateFilter middleware for automatic domain detection
- Update HomeController with state-based caching
- Update PostController with domain filtering
- Update SearchController with domain filtering
- Update CategoryController with domain filtering
- Remove AntiScraping middleware
- Add DOMAIN_STATE_MAP configuration to .env
- Configure Nginx for karnatakajob.online domain
- Add SSL certificate support for multiple domains
- Add comprehensive documentation and deployment guides"

echo "✓ Changes committed"
echo ""

# Push to GitHub
echo "5. Pushing to GitHub..."
git push origin main

if [ $? -eq 0 ]; then
    echo "✓ Successfully pushed to GitHub"
    echo ""
    echo "=========================================="
    echo "✅ Push Complete!"
    echo "=========================================="
    echo ""
    echo "Next steps:"
    echo "1. Verify on GitHub: https://github.com/your-repo"
    echo "2. Pull on server: cd /var/www/jobone && git pull origin main"
    echo "3. Run deployment: php artisan config:clear && sudo systemctl restart php8.2-fpm"
else
    echo "❌ Push failed"
    echo "Check your GitHub credentials and try again"
    exit 1
fi
