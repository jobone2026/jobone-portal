# JobOne.in - GitHub Repositories

Your code is now available on GitHub in two repositories.

## Primary Repository (Recommended)

**Repository:** https://github.com/jobone2026/jobone-portal

This is the main repository for deployment and production use.

### Clone Command:
```bash
git clone https://github.com/jobone2026/jobone-portal.git
```

### One-Click Installation:
```bash
wget https://raw.githubusercontent.com/jobone2026/jobone-portal/main/install.sh
chmod +x install.sh
bash install.sh
```

## Secondary Repository

**Repository:** https://github.com/jobone2026/jobone

This is the original repository (also contains the same code).

### Clone Command:
```bash
git clone https://github.com/jobone2026/jobone.git
```

## Which One to Use?

**Use `jobone-portal`** - This is the primary repository with the correct naming convention.

All documentation (DEPLOYMENT.md, ONE_CLICK_INSTALL.md, etc.) now points to the `jobone-portal` repository.

## Repository Contents

Both repositories contain:
- ✅ Complete Laravel 12 application
- ✅ SEO optimization (250+ keywords)
- ✅ Admin panel with backup/restore
- ✅ REST API with authentication
- ✅ One-click installation script
- ✅ Complete documentation
- ✅ Deployment scripts
- ✅ 11 commits with full history

## Deployment

### Option 1: One-Click Installation (Recommended)

```bash
wget https://raw.githubusercontent.com/jobone2026/jobone-portal/main/install.sh
chmod +x install.sh
bash install.sh
```

### Option 2: Manual Installation

Follow the guide in `DEPLOYMENT.md`

## Local Development

```bash
# Clone repository
git clone https://github.com/jobone2026/jobone-portal.git
cd jobone-portal

# Install dependencies
composer install
npm install

# Configure environment
cp .env.example .env
php artisan key:generate

# Run migrations
php artisan migrate

# Build assets
npm run dev

# Start development server
php artisan serve
```

## Updating Your Local Repository

If you want to switch to the new repository URL:

```bash
cd govt-job-portal-new

# Update remote URL
git remote set-url origin https://github.com/jobone2026/jobone-portal.git

# Verify
git remote -v

# Push/pull as normal
git push origin main
git pull origin main
```

## Repository Statistics

- **Total Files:** 341
- **Total Commits:** 11
- **Size:** ~325 KB
- **Language:** PHP (Laravel 12)
- **License:** Not specified

## Support

- **Email:** jobone2026@gmail.com
- **Primary Repo:** https://github.com/jobone2026/jobone-portal
- **Issues:** https://github.com/jobone2026/jobone-portal/issues

---

**Last Updated:** March 9, 2026  
**Version:** 1.0.0
