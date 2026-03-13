# 📱 Telegram Notification - Quick Setup (5 Minutes)

## Step 1: Create Telegram Bot (2 minutes)

1. Open Telegram app
2. Search for: `@BotFather`
3. Send: `/newbot`
4. Bot name: `JobOne Notification Bot`
5. Username: `jobone_notify_bot` (or any available name)
6. **Copy the token** (looks like: `123456789:ABCdefGHIjklMNOpqrsTUVwxyz`)

## Step 2: Create Telegram Channel (1 minute)

1. In Telegram, click **New Channel**
2. Channel name: `JobOne Updates`
3. Make it **Public**
4. Username: `@jobone_updates` (or any available)
5. Click **Create**

## Step 3: Add Bot to Channel (1 minute)

1. Open your channel
2. Click channel name → **Administrators**
3. Click **Add Administrator**
4. Search for your bot: `jobone_notify_bot`
5. Add it and give **Post Messages** permission
6. Click **Save**

## Step 4: Add to .env File (1 minute)

Open `.env` file and add these two lines:

```env
TELEGRAM_BOT_TOKEN=123456789:ABCdefGHIjklMNOpqrsTUVwxyz
TELEGRAM_CHANNEL_ID=@jobone_updates
```

Replace with your actual bot token and channel username.

## Step 5: Test It!

1. Go to admin panel
2. Create a new post
3. Click **Publish**
4. Check your Telegram channel - notification should appear! 🎉

## Example Notification:

```
💼 RGNAU Recruitment 2026 - Apply Online for 100 Posts

Applications are invited for various posts in RGNAU.

📅 Last Date: 15 Apr 2026
📊 Total Posts: 100

🔗 Apply Now: https://jobone.in/job/rgnau-recruitment-2026

#Job #Karnataka
```

## Troubleshooting:

**Notification not appearing?**
- Check bot token is correct in `.env`
- Verify bot is administrator in channel
- Check channel username starts with `@`
- Look at logs: `storage/logs/laravel.log`

**Still not working?**
Run this command to test:
```bash
php artisan tinker
```
Then:
```php
$post = App\Models\Post::first();
app(App\Services\NotificationService::class)->sendToTelegram($post);
```

---

## For Android App Later:

When you develop the Android app, you can:
1. Use Firebase Cloud Messaging (FCM)
2. Or create a simple API endpoint
3. App will poll for new posts
4. Show local notifications

We'll add that integration when your app is ready!
