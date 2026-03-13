# Auto Deployment Setup Guide

This guide will help you set up automatic deployment from GitHub to your server.

## What This Does
Whenever you push changes to the `main` branch, GitHub Actions will automatically:
1. Connect to your server via SSH
2. Pull the latest code
3. Clear caches
4. Restart PHP-FPM

## Setup Steps

### Step 1: Generate SSH Key on Your Local Machine
```bash
ssh-keygen -t rsa -b 4096 -C "github-deploy" -f ~/.ssh/github_deploy
```

This creates two files:
- `~/.ssh/github_deploy` (private key)
- `~/.ssh/github_deploy.pub` (public key)

### Step 2: Add Public Key to Server
Copy the public key to your server:
```bash
cat ~/.ssh/github_deploy.pub
```

Then on your server:
```bash
ssh ubuntu@3.108.161.67
mkdir -p ~/.ssh
nano ~/.ssh/authorized_keys
# Paste the public key content here
# Save and exit (Ctrl+X, Y, Enter)
chmod 600 ~/.ssh/authorized_keys
chmod 700 ~/.ssh
```

### Step 3: Add Secrets to GitHub Repository

1. Go to your GitHub repository: https://github.com/jobone2026/jobone-portal
2. Click on "Settings" tab
3. Click on "Secrets and variables" → "Actions"
4. Click "New repository secret" and add these three secrets:

**Secret 1: SERVER_HOST**
- Name: `SERVER_HOST`
- Value: `3.108.161.67`

**Secret 2: SERVER_USER**
- Name: `SERVER_USER`
- Value: `ubuntu`

**Secret 3: SSH_PRIVATE_KEY**
- Name: `SSH_PRIVATE_KEY`
- Value: Copy the entire content of your private key
```bash
cat ~/.ssh/github_deploy
```
Copy everything including:
```
-----BEGIN OPENSSH PRIVATE KEY-----
...
-----END OPENSSH PRIVATE KEY-----
```

### Step 4: Configure Server Permissions

On your server, allow the ubuntu user to restart PHP-FPM without password:
```bash
sudo visudo
```

Add this line at the end:
```
ubuntu ALL=(ALL) NOPASSWD: /bin/systemctl restart php8.2-fpm
```

Save and exit (Ctrl+X, Y, Enter)

### Step 5: Test the Setup

1. Make a small change to any file
2. Commit and push to main branch:
```bash
git add -A
git commit -m "Test auto deployment"
git push portal main
```

3. Go to your GitHub repository → "Actions" tab
4. You should see the workflow running
5. Check your website to verify the changes are live

## Troubleshooting

### If deployment fails:
1. Check the GitHub Actions logs for error messages
2. Verify SSH connection manually:
```bash
ssh -i ~/.ssh/github_deploy ubuntu@3.108.161.67
```

### If PHP-FPM restart fails:
Make sure you added the sudoers entry correctly (Step 4)

### If git pull fails:
Check git permissions on server:
```bash
cd /var/www/jobone
sudo chown -R ubuntu:ubuntu .git
```

## Current Manual Deployment (Backup Method)

If auto-deployment fails, you can still deploy manually:
```bash
cd /var/www/jobone
git pull portal main
php artisan view:clear
php artisan config:clear
sudo systemctl restart php8.2-fpm
```

## Benefits of Auto Deployment

✅ No need to SSH into server for every change
✅ Faster deployment (happens automatically)
✅ Consistent deployment process
✅ Deployment history in GitHub Actions
✅ Can rollback easily if needed

## Security Notes

- Private SSH key is stored securely in GitHub Secrets (encrypted)
- Only the ubuntu user can deploy
- Only main branch triggers deployment
- Server access is limited to deployment commands only
