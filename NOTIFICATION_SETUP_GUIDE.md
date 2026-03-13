# 🔔 Notification System Setup Guide

Complete guide to set up automatic notifications when new posts are published.

## Features
- ✅ Telegram Channel notifications
- ✅ WhatsApp Channel notifications  
- ✅ Web Push notifications (Browser & App)
- ✅ Auto-send when post is published
- ✅ Beautiful formatted messages with emojis

---

## 1. Telegram Channel Setup

### Step 1: Create Telegram Bot
1. Open Telegram and search for `@BotFather`
2. Send `/newbot` command
3. Choose a name: `JobOne Notification Bot`
4. Choose username: `jobone_notify_bot`
5. Copy the **Bot Token** (looks like: `123456789:ABCdefGHIjklMNOpqrsTUVwxyz`)

### Step 2: Create Telegram Channel
1. Create a new channel in Telegram
2. Make it public with username like `@jobone_updates`
3. Add your bot as administrator:
   - Go to channel settings
   - Click "Administrators"
   - Add your bot
   - Give "Post Messages" permission

### Step 3: Get Channel ID
1. Send a message to your channel
2. Visit: `https://api.telegram.org/bot<YOUR_BOT_TOKEN>/getUpdates`
3. Find `"chat":{"id":-1001234567890}` - this is your channel ID
4. Or use channel username: `@jobone_updates`

### Step 4: Add to .env
```env
TELEGRAM_BOT_TOKEN=123456789:ABCdefGHIjklMNOpqrsTUVwxyz
TELEGRAM_CHANNEL_ID=@jobone_updates
```

---

## 2. WhatsApp Channel Setup

### Option A: WhatsApp Business API (Official)

1. **Create Meta Business Account**
   - Go to: https://business.facebook.com
   - Create business account

2. **Set up WhatsApp Business API**
   - Go to: https://developers.facebook.com
   - Create app → Business → WhatsApp
   - Get Phone Number ID and Access Token

3. **Add to .env**
```env
WHATSAPP_ACCESS_TOKEN=your_access_token_here
WHATSAPP_PHONE_NUMBER_ID=your_phone_number_id
WHATSAPP_CHANNEL_ID=your_channel_id
```

### Option B: Third-Party Services (Easier)

Use services like:
- **Twilio**: https://www.twilio.com/whatsapp
- **MessageBird**: https://messagebird.com
- **Vonage**: https://www.vonage.com

---

## 3. Web Push Notifications Setup

### Step 1: Create Firebase Project
1. Go to: https://console.firebase.google.com
2. Click "Add Project"
3. Name it: `JobOne Notifications`
4. Disable Google Analytics (optional)

### Step 2: Get FCM Server Key
1. In Firebase Console, go to Project Settings
2. Click "Cloud Messaging" tab
3. Copy "Server key"

### Step 3: Add to .env
```env
FCM_SERVER_KEY=your_fcm_server_key_here
```

### Step 4: Add Firebase to Website
Create `public/firebase-messaging-sw.js`:
```javascript
importScripts('https://www.gstatic.com/firebasejs/9.0.0/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/9.0.0/firebase-messaging-compat.js');

firebase.initializeApp({
  apiKey: "YOUR_API_KEY",
  authDomain: "YOUR_PROJECT.firebaseapp.com",
  projectId: "YOUR_PROJECT_ID",
  storageBucket: "YOUR_PROJECT.appspot.com",
  messagingSenderId: "YOUR_SENDER_ID",
  appId: "YOUR_APP_ID"
});

const messaging = firebase.messaging();

messaging.onBackgroundMessage((payload) => {
  const notificationTitle = payload.notification.title;
  const notificationOptions = {
    body: payload.notification.body,
    icon: payload.notification.icon
  };

  self.registration.showNotification(notificationTitle, notificationOptions);
});
```

---

## 4. Testing Notifications

### Test Telegram
```bash
php artisan tinker
```
```php
$post = App\Models\Post::first();
app(App\Services\NotificationService::class)->sendToTelegram($post);
```

### Test WhatsApp
```php
$post = App\Models\Post::first();
app(App\Services\NotificationService::class)->sendToWhatsApp($post);
```

### Test Web Push
```php
$post = App\Models\Post::first();
app(App\Services\NotificationService::class)->sendWebPushNotification($post);
```

---

## 5. How It Works

When you publish a post in admin panel:
1. ✅ Post is saved to database
2. ✅ Notification sent to Telegram channel
3. ✅ Notification sent to WhatsApp channel
4. ✅ Web push notification sent to all subscribers
5. ✅ Users receive instant notification

### Message Format

**Telegram/WhatsApp:**
```
💼 RGNAU Recruitment 2026 - Apply Online for 100 Posts

Applications are invited for various posts in RGNAU. 
Eligible candidates can apply online.

📅 Last Date: 15 Apr 2026
📊 Total Posts: 100

🔗 Apply Now: https://jobone.in/job/rgnau-recruitment-2026

#Job #Karnataka
```

**Web Push:**
```
🔔 New Job
RGNAU Recruitment 2026 - Apply Online for 100 Posts
[Click to view]
```

---

## 6. Troubleshooting

### Telegram not working?
- Check bot token is correct
- Verify bot is admin in channel
- Check channel ID format (@username or -100...)

### WhatsApp not working?
- Verify access token is valid
- Check phone number is verified
- Ensure WhatsApp Business API is approved

### Web Push not working?
- Check FCM server key
- Verify firebase-messaging-sw.js is accessible
- Check browser permissions

---

## 7. Advanced Features

### Customize Messages
Edit `app/Services/NotificationService.php`:
- Change message format
- Add more details
- Customize emojis

### Schedule Notifications
Use Laravel Queue to delay notifications:
```php
dispatch(function() use ($post) {
    app(NotificationService::class)->sendNewPostNotifications($post);
})->delay(now()->addMinutes(5));
```

### Notification Logs
Check logs at: `storage/logs/laravel.log`

---

## 8. Cost Estimate

| Service | Free Tier | Paid |
|---------|-----------|------|
| Telegram | ✅ Unlimited | Free forever |
| WhatsApp Business API | ❌ | $0.005-0.01 per message |
| Firebase FCM | ✅ Unlimited | Free forever |
| Twilio WhatsApp | ✅ 1000 msgs | $0.005 per message |

**Recommendation:** Start with Telegram (free) + Web Push (free)

---

## Need Help?

Contact: marutikd91@gmail.com
