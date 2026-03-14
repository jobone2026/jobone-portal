# 🚀 Deploy Notification System

Quick guide to deploy the notification system on your server.

## 📋 What's Included

- ✅ Admin notification page at `/admin/notifications`
- ✅ Auto-send notifications when posts are published
- ✅ Manual notification sending from admin panel
- ✅ Support for Telegram, Android Push (Firebase), and WhatsApp

## 🔧 Server Setup Steps

### 1. Push Code to Server

```bash
# On your local machine
git add .
git commit -m "Add notification system"
git push portal main
```

### 2. Pull on Server

```bash
# SSH to server
ssh ubuntu@3.108.161.67

# Navigate to project
cd /var/www/jobone

# Pull latest code
git pull portal main
```

### 3. Create Firebase Directory

```bash
# Create directory for Firebase credentials
mkdir -p storage/app/firebase
chmod 755 storage/app/firebase
```

### 4. Create Firebase Credentials File

```bash
# On server, create the Firebase credentials file
nano storage/app/firebase/jobone-firebase-adminsdk.json
```

**Important:** Paste your Firebase service account JSON content here. 

The file should contain your Firebase credentials with these fields:
- type: "service_account"
- project_id: "jobone-ea4e2"
- private_key: (your private key)
- client_email: (your service account email)
- And other Firebase configuration fields

You can find this file in your Firebase Console:
1. Go to Project Settings → Service Accounts
2. Click "Generate New Private Key"
3. Copy the entire JSON content and paste it into the file

Press `Ctrl+X`, then `Y`, then `Enter` to save.

**Note:** The Firebase credentials file `jobone-firebase-adminsdk.json` is already in your local project root. You can copy its content to the server.

### 5. Set File Permissions

```bash
# On server
chmod 644 storage/app/firebase/jobone-firebase-adminsdk.json
chown www-data:www-data storage/app/firebase/jobone-firebase-adminsdk.json
```

### 6. Install Firebase PHP SDK

```bash
# On server
cd /var/www/jobone
composer require kreait/firebase-php
```

### 7. Configure Telegram (5 minutes)

Follow the quick setup guide: `TELEGRAM_SETUP_QUICK.md`

Then add to `.env`:
```env
TELEGRAM_BOT_TOKEN=your_bot_token_here
TELEGRAM_CHANNEL_ID=@your_channel_username
```

### 8. Clear Cache & Restart

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
sudo systemctl restart php8.2-fpm
```

### 9. Test Notifications

```bash
# Test all notification channels
php artisan notification:test
```

Expected output:
```
Testing Notification System...
Testing Telegram... ✅ Sent
Testing Firebase... ✅ Sent
Testing WhatsApp... ⚠️ Optional

Test Summary:
+----------+--------+
| Service  | Status |
+----------+--------+
| Telegram | ✅ OK  |
| Firebase | ✅ OK  |
| WhatsApp | ⚠️ N/A |
+----------+--------+
```

## 🎯 How to Use

### Auto Notifications (Already Working)

When you publish a post in admin panel, notifications are automatically sent to:
- Telegram channel
- Android app users (via Firebase)
- WhatsApp channel (if configured)

### Manual Notifications

1. Go to admin panel: https://jobone.in/admin/notifications
2. Fill in the form:
   - Title (e.g., "New Job Alert!")
   - Message (e.g., "Check out the latest government jobs")
   - URL (optional, e.g., https://jobone.in/job/example)
   - Select channels (Telegram, Android, WhatsApp)
3. Click "Send Notification"

## 🔍 Troubleshooting

### Firebase Not Working?

```bash
# Check if file exists
ls -la storage/app/firebase/jobone-firebase-adminsdk.json

# Check .env configuration
grep FIREBASE_CREDENTIALS .env

# Should show: FIREBASE_CREDENTIALS=storage/app/firebase/jobone-firebase-adminsdk.json
```

### Telegram Not Working?

```bash
# Check .env configuration
grep TELEGRAM .env

# Test bot token manually
curl "https://api.telegram.org/bot<YOUR_BOT_TOKEN>/getMe"
```

### Check Logs

```bash
# View Laravel logs
tail -f storage/logs/laravel.log
```

## 📱 Android App Setup

For Android push notifications to work, users need to:
1. Install your Android app
2. Grant notification permissions
3. App will auto-subscribe to "all_posts" topic

See `ANDROID_PUSH_SETUP.md` for full Android app integration.

## ✅ Verification Checklist

- [ ] Code pushed to GitHub
- [ ] Code pulled on server
- [ ] Firebase directory created
- [ ] Firebase credentials uploaded
- [ ] Firebase PHP SDK installed
- [ ] Telegram bot configured in .env
- [ ] Cache cleared
- [ ] Test command runs successfully
- [ ] Admin notification page accessible
- [ ] Test notification sent successfully

## 🎉 You're Done!

Your notification system is now live. Every time you publish a post, notifications will automatically go out to your users on Telegram and Android app!

Access admin panel: https://jobone.in/admin/notifications
