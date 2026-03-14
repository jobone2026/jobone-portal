# 🚀 Notification System - Quick Start

## ✅ What's Done

Your notification system is now ready! Here's what's been set up:

1. ✅ Admin notification page at `/admin/notifications`
2. ✅ Auto-send notifications when posts are published
3. ✅ Manual notification sending from admin panel
4. ✅ Support for Telegram, Android Push (Firebase), and WhatsApp
5. ✅ Test command: `php artisan notification:test`

## 📦 What You Need to Do on Server

### Quick Setup (5 minutes)

```bash
# 1. SSH to server
ssh ubuntu@3.108.161.67

# 2. Go to project
cd /var/www/jobone

# 3. Pull latest code
git pull portal main

# 4. Create Firebase directory
mkdir -p storage/app/firebase
chmod 755 storage/app/firebase

# 5. Create Firebase credentials file
nano storage/app/firebase/jobone-firebase-adminsdk.json
# Paste content from local file: jobone-firebase-adminsdk.json
# Press Ctrl+X, Y, Enter to save

# 6. Set permissions
chmod 644 storage/app/firebase/jobone-firebase-adminsdk.json
chown www-data:www-data storage/app/firebase/jobone-firebase-adminsdk.json

# 7. Install Firebase SDK
composer require kreait/firebase-php

# 8. Setup Telegram (see TELEGRAM_SETUP_QUICK.md)
# Add to .env:
# TELEGRAM_BOT_TOKEN=your_token
# TELEGRAM_CHANNEL_ID=@your_channel

# 9. Clear cache
php artisan config:clear
php artisan cache:clear
sudo systemctl restart php8.2-fpm

# 10. Test it!
php artisan notification:test
```

## 🎯 How to Use

### Auto Notifications (Already Working!)

When you publish a post in admin panel, notifications automatically go to:
- 📱 Telegram channel
- 📱 Android app users
- 💬 WhatsApp (if configured)

### Manual Notifications

1. Go to: https://jobone.in/admin/notifications
2. Fill the form:
   - Title: "New Job Alert!"
   - Message: "Check latest government jobs"
   - URL: https://jobone.in/job/example (optional)
   - Select channels: Telegram, Android, WhatsApp
3. Click "Send Notification"

## 📁 Important Files

- `jobone-firebase-adminsdk.json` - Firebase credentials (in project root, NOT in git)
- `DEPLOY_NOTIFICATIONS.md` - Full deployment guide
- `TELEGRAM_SETUP_QUICK.md` - Telegram setup (5 minutes)
- `ANDROID_PUSH_SETUP.md` - Android app integration

## 🔍 Troubleshooting

### Test notifications not working?

```bash
# Check if Firebase file exists
ls -la storage/app/firebase/jobone-firebase-adminsdk.json

# Check .env
grep FIREBASE_CREDENTIALS .env
grep TELEGRAM .env

# View logs
tail -f storage/logs/laravel.log
```

### Firebase not configured?

Make sure:
1. File exists: `storage/app/firebase/jobone-firebase-adminsdk.json`
2. .env has: `FIREBASE_CREDENTIALS=storage/app/firebase/jobone-firebase-adminsdk.json`
3. Composer package installed: `composer require kreait/firebase-php`

### Telegram not configured?

Make sure .env has:
```env
TELEGRAM_BOT_TOKEN=your_bot_token_here
TELEGRAM_CHANNEL_ID=@your_channel_username
```

## 🎉 That's It!

Once set up, every time you publish a post, notifications will automatically go out to your users!

Access admin panel: https://jobone.in/admin/notifications
