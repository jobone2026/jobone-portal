# Git Setup & Push Guide

Complete guide to push your code to GitHub and deploy to AWS.

## Step 1: Create GitHub Repository

### Option A: Using GitHub Website

1. Go to https://github.com
2. Click the "+" icon in the top right
3. Select "New repository"
4. Fill in:
   - Repository name: `govt-job-portal` or `jobone-portal`
   - Description: "Government Job Portal - JobOne.in"
   - Visibility: Private (recommended) or Public
   - **DO NOT** initialize with README, .gitignore, or license
5. Click "Create repository"

### Option B: Using GitHub CLI (if installed)

```bash
gh repo create govt-job-portal --private --source=. --remote=origin
```

## Step 2: Connect Local Repository to GitHub

After creating the repository on GitHub, you'll see a page with commands. Use these:

```bash
# Add remote repository
git remote add origin https://github.com/YOUR_USERNAME/govt-job-portal.git

# Verify remote was added
git remote -v

# Push code to GitHub
git push -u origin master
```

Replace `YOUR_USERNAME` with your actual GitHub username.

### If you get authentication errors:

#### For HTTPS (Recommended):
You'll need a Personal Access Token (PAT):

1. Go to GitHub Settings → Developer settings → Personal access tokens → Tokens (classic)
2. Click "Generate new token (classic)"
3. Give it a name: "JobOne Deployment"
4. Select scopes: `repo` (full control of private repositories)
5. Click "Generate token"
6. **Copy the token immediately** (you won't see it again!)

When pushing, use:
```bash
git push -u origin master
```

When prompted for password, paste your Personal Access Token (not your GitHub password).

#### For SSH:
```bash
# Generate SSH key (if you don't have one)
ssh-keygen -t ed25519 -C "jobone2026@gmail.com"

# Copy public key
cat ~/.ssh/id_ed25519.pub

# Add to GitHub: Settings → SSH and GPG keys → New SSH key
# Paste the key and save

# Change remote to SSH
git remote set-url origin git@github.com:YOUR_USERNAME/govt-job-portal.git

# Push
git push -u origin master
```

## Step 3: Verify Push

```bash
# Check status
git status

# View commit history
git log --oneline

# Check remote
git remote -v
```

Visit your GitHub repository URL to see your code online!

## Step 4: Deploy to AWS

### Prerequisites

1. **AWS EC2 Instance** running Ubuntu 22.04 LTS
2. **SSH access** to your server
3. **Domain name** pointed to your server IP (optional but recommended)

### Deployment Steps

1. **Connect to your server:**
```bash
ssh ubuntu@your-server-ip
```

2. **Follow the deployment guide:**
```bash
# The complete deployment guide is in DEPLOYMENT.md
# Follow all steps in order
```

3. **Clone your repository on the server:**
```bash
cd /var/www
sudo git clone https://github.com/YOUR_USERNAME/govt-job-portal.git jobone
sudo chown -R $USER:www-data /var/www/jobone
cd /var/www/jobone
```

4. **Run deployment:**
```bash
# Make deploy script executable
chmod +x deploy.sh

# Run initial setup (follow DEPLOYMENT.md for first-time setup)
# Then use deploy script for updates:
./deploy.sh
```

## Future Updates

### Making Changes

1. **Make your changes locally**
2. **Test locally:**
```bash
php artisan serve
# Visit http://localhost:8000
```

3. **Commit changes:**
```bash
git add .
git commit -m "Description of changes"
```

4. **Push to GitHub:**
```bash
git push origin master
```

5. **Deploy to server:**
```bash
# SSH to server
ssh ubuntu@your-server-ip

# Navigate to project
cd /var/www/jobone

# Run deployment script
./deploy.sh
```

## Common Git Commands

### Check Status
```bash
git status
```

### View Changes
```bash
git diff
```

### View Commit History
```bash
git log --oneline
git log --graph --oneline --all
```

### Create a Branch
```bash
git checkout -b feature-name
```

### Switch Branches
```bash
git checkout master
git checkout feature-name
```

### Merge Branch
```bash
git checkout master
git merge feature-name
```

### Undo Changes
```bash
# Discard changes in working directory
git checkout -- filename

# Undo last commit (keep changes)
git reset --soft HEAD~1

# Undo last commit (discard changes)
git reset --hard HEAD~1
```

### Pull Latest Changes
```bash
git pull origin master
```

## Branching Strategy (Recommended)

### For Production:

```
master (main) → Production-ready code
  ↑
develop → Development branch
  ↑
feature/* → Feature branches
```

### Workflow:

1. **Create feature branch:**
```bash
git checkout -b feature/new-feature
```

2. **Make changes and commit:**
```bash
git add .
git commit -m "Add new feature"
```

3. **Push feature branch:**
```bash
git push origin feature/new-feature
```

4. **Create Pull Request on GitHub**

5. **Merge to develop, then to master**

6. **Deploy master to production**

## .gitignore Important Files

Already configured in `.gitignore`:
- `.env` (environment variables)
- `/vendor` (Composer dependencies)
- `/node_modules` (NPM dependencies)
- `database.sqlite` (local database)
- `/storage/*.key` (encryption keys)
- Test files (`test-*.php`)

**Never commit:**
- Database credentials
- API keys
- Passwords
- Local configuration files

## Troubleshooting

### "Permission denied (publickey)"
- Check SSH key is added to GitHub
- Verify SSH agent: `ssh-add -l`
- Add key: `ssh-add ~/.ssh/id_ed25519`

### "fatal: remote origin already exists"
```bash
git remote remove origin
git remote add origin https://github.com/YOUR_USERNAME/govt-job-portal.git
```

### "Updates were rejected"
```bash
# Pull first, then push
git pull origin master --rebase
git push origin master
```

### Large files error
```bash
# Remove large files from git history
git rm --cached path/to/large/file
git commit -m "Remove large file"
```

## GitHub Repository Settings

### Recommended Settings:

1. **Branch Protection** (Settings → Branches):
   - Protect `master` branch
   - Require pull request reviews
   - Require status checks to pass

2. **Secrets** (Settings → Secrets and variables → Actions):
   - Add deployment secrets if using GitHub Actions
   - `AWS_SSH_KEY`
   - `SERVER_IP`
   - `DB_PASSWORD`

3. **Collaborators** (Settings → Collaborators):
   - Add team members if needed

## Continuous Deployment (Optional)

### Using GitHub Actions:

Create `.github/workflows/deploy.yml`:

```yaml
name: Deploy to AWS

on:
  push:
    branches: [ master ]

jobs:
  deploy:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v2
      
      - name: Deploy to Server
        uses: appleboy/ssh-action@master
        with:
          host: ${{ secrets.SERVER_IP }}
          username: ubuntu
          key: ${{ secrets.AWS_SSH_KEY }}
          script: |
            cd /var/www/jobone
            ./deploy.sh
```

## Backup Strategy

### Before Major Changes:

```bash
# Create a tag
git tag -a v1.0.0 -m "Version 1.0.0 - Initial Release"
git push origin v1.0.0

# Create a branch
git checkout -b backup-before-major-change
git push origin backup-before-major-change
```

## Support

For issues:
- Check GitHub Issues: https://github.com/YOUR_USERNAME/govt-job-portal/issues
- Email: jobone2026@gmail.com

---

**Happy Coding! 🚀**
