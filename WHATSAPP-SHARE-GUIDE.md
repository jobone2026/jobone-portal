# WhatsApp Share Feature - User Guide

## Overview
This feature allows you to easily share job posts to WhatsApp channels, groups, or individual chats with pre-formatted messages.

## Features
- ✅ Generate formatted WhatsApp messages for any post
- ✅ One-click copy to clipboard
- ✅ Direct WhatsApp share link
- ✅ Admin interface for easy access
- ✅ CLI command for automation

## Usage

### Method 1: Admin Interface (Recommended)

1. **Access the WhatsApp Share Page:**
   - Login to admin panel: `https://jobone.in/admin`
   - Click on "WhatsApp Share" in the sidebar (📱 icon)

2. **Share a Post:**
   - Find the post you want to share
   - Click "Generate Message" button
   - A modal will open with the formatted message
   - Click "Copy Message" to copy to clipboard
   - Click "Share to WhatsApp" to open WhatsApp directly
   - Paste the message in your WhatsApp channel/group

3. **Message Format:**
   ```
   💼 *Post Title*

   📊 *Vacancies:* 100
   🎓 *Education:* Graduate
   📍 *State:* Punjab
   ⏰ *Last Date:* 15 May 2026

   🔗 *Apply/Details:*
   https://jobone.in/job/post-slug

   ━━━━━━━━━━━━━━━━
   📱 *JoBone.in* - Latest Govt Jobs
   🔔 Join: https://jobone.in
   ```

### Method 2: CLI Command

**Share Latest Post:**
```bash
php artisan share:whatsapp --latest
```

**Share Specific Post:**
```bash
php artisan share:whatsapp 123
```

**Share Latest Result:**
```bash
php artisan share:whatsapp --latest --type=result
```

**Output:**
- WhatsApp share link
- Formatted message preview
- Instructions for sharing to channel

### Method 3: Automated Sharing (Optional)

**Setup Cron Job to Auto-Share New Posts:**

Add to crontab:
```bash
# Share latest job post every hour
0 * * * * cd /var/www/jobone && php artisan share:whatsapp --latest --type=job >> /var/log/whatsapp-share.log 2>&1
```

## WhatsApp Channel Setup

### Option 1: WhatsApp Channel (Recommended)
1. Create a WhatsApp Channel in your WhatsApp Business app
2. Get your channel link (e.g., `https://whatsapp.com/channel/YOUR_CHANNEL_ID`)
3. Update the channel link in:
   - `app/Console/Commands/ShareToWhatsApp.php` (line 48)
   - `resources/views/admin/whatsapp/index.blade.php` (line 10)

### Option 2: WhatsApp Business API
For automated posting, you'll need:
1. WhatsApp Business API account
2. Integration with services like:
   - Twilio WhatsApp API
   - MessageBird
   - 360Dialog
   - Meta Cloud API

## Deployment Steps

1. **Pull Latest Code:**
   ```bash
   cd /var/www/jobone
   git pull origin main
   ```

2. **Clear Cache:**
   ```bash
   sudo -u www-data php artisan cache:clear
   sudo -u www-data php artisan config:clear
   sudo -u www-data php artisan view:clear
   ```

3. **Restart PHP:**
   ```bash
   sudo systemctl restart php8.2-fpm
   ```

4. **Test the Feature:**
   - Visit: `https://jobone.in/admin/whatsapp`
   - Generate a message for any post
   - Verify the message format

## Customization

### Change Message Format
Edit: `app/Http/Controllers/Admin/WhatsAppController.php`
Method: `generateWhatsAppMessage()`

### Change Channel Link
Edit: `resources/views/admin/whatsapp/index.blade.php`
Line 10: Update the channel URL

### Add More Post Types
Edit: `app/Console/Commands/ShareToWhatsApp.php`
Method: `getEmojiForType()` - Add more emoji mappings

## Tips

1. **Best Posting Times:**
   - Morning: 8-10 AM
   - Afternoon: 2-4 PM
   - Evening: 7-9 PM

2. **Message Guidelines:**
   - Keep it concise and clear
   - Use emojis for better engagement
   - Include direct link to post
   - Add call-to-action

3. **Frequency:**
   - Don't spam - max 3-4 posts per day
   - Space out posts by 2-3 hours
   - Focus on high-quality, relevant posts

## Troubleshooting

**Issue: Modal not opening**
- Clear browser cache
- Check browser console for errors
- Ensure JavaScript is enabled

**Issue: Copy button not working**
- Try manual copy (Ctrl+C / Cmd+C)
- Check clipboard permissions in browser

**Issue: WhatsApp link not working**
- Ensure WhatsApp is installed
- Try opening link in different browser
- Check if WhatsApp Web is accessible

## Support

For issues or questions:
- Check Laravel logs: `/var/www/jobone/storage/logs/laravel.log`
- Run diagnostics: `php artisan share:whatsapp --latest`
- Contact: admin@jobone.in
