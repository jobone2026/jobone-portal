# Web Push Notifications & Feedback System

## Overview
Complete web push notification system with enable/disable functionality and user feedback form.

## Features Implemented

### 1. Web Push Notifications
- ✅ Enable/Disable notifications with one click
- ✅ Browser permission handling
- ✅ Subscription management
- ✅ Visual feedback (button changes color when enabled)
- ✅ Toast notifications for user actions
- ✅ Service worker integration

### 2. Feedback System
- ✅ Feedback modal with form
- ✅ Three feedback types: General, Bug Report, Feature Request
- ✅ Optional email field
- ✅ Character limit (1000 chars)
- ✅ Logs feedback to Laravel logs
- ✅ Beautiful UI with animations

### 3. Database
- ✅ `notification_subscriptions` table
- ✅ Stores endpoint, keys, user agent, IP
- ✅ Active/inactive status tracking
- ✅ Last notified timestamp

## Files Created

### Backend
1. **Migration**: `database/migrations/2026_04_12_060000_create_notification_subscriptions_table.php`
2. **Model**: `app/Models/NotificationSubscription.php`
3. **Controller**: `app/Http/Controllers/NotificationController.php`
4. **Routes**: Added to `routes/web.php`

### Frontend
1. **JavaScript**: `public/js/web-notifications.js`
2. **Component**: `resources/views/components/notification-controls.blade.php`
3. **Layout**: Updated `resources/views/layouts/app.blade.php`

## API Endpoints

### Notification Endpoints
```
POST /notifications/subscribe    - Subscribe to notifications
POST /notifications/unsubscribe  - Unsubscribe from notifications
POST /notifications/status       - Check subscription status
```

### Feedback Endpoint
```
POST /feedback                   - Submit user feedback
```

## UI Components

### Notification Button
- Fixed position: bottom-right corner
- Blue button when disabled: "Enable Notifications"
- Green button when enabled: "Notifications ON"
- Smooth animations and hover effects

### Feedback Button
- Fixed position: below notification button
- Purple color scheme
- Opens modal on click

### Feedback Modal
- Clean, modern design
- Form validation
- Smooth animations
- Close on outside click or X button

## How It Works

### 1. User Enables Notifications
```
1. User clicks "Enable Notifications" button
2. Browser asks for permission
3. If granted, subscription is created
4. Subscription sent to server via POST /notifications/subscribe
5. Stored in database
6. Button changes to green "Notifications ON"
```

### 2. Sending Notifications (Backend)
```php
// In NotificationService.php or PostController.php
use App\Models\NotificationSubscription;

$subscriptions = NotificationSubscription::active()->get();

foreach ($subscriptions as $subscription) {
    // Send push notification using Firebase or Web Push library
    // Mark as notified
    $subscription->markAsNotified();
}
```

### 3. User Submits Feedback
```
1. User clicks "Feedback" button
2. Modal opens with form
3. User fills type, message, optional email
4. Submits form
5. Logged to storage/logs/laravel.log
6. Success toast shown
```

## Deployment Steps

### 1. Run Migration
```bash
ssh -i .ssh/jobone2026.pem ubuntu@3.108.161.67
cd /var/www/jobone
sudo -u www-data php artisan migrate
```

### 2. Upload Files
```bash
# Upload new files
scp -i .ssh/jobone2026.pem -r public/js/web-notifications.js ubuntu@3.108.161.67:/tmp/
scp -i .ssh/jobone2026.pem -r app/Http/Controllers/NotificationController.php ubuntu@3.108.161.67:/tmp/
scp -i .ssh/jobone2026.pem -r app/Models/NotificationSubscription.php ubuntu@3.108.161.67:/tmp/
scp -i .ssh/jobone2026.pem -r resources/views/components/notification-controls.blade.php ubuntu@3.108.161.67:/tmp/
scp -i .ssh/jobone2026.pem -r resources/views/layouts/app.blade.php ubuntu@3.108.161.67:/tmp/
scp -i .ssh/jobone2026.pem -r routes/web.php ubuntu@3.108.161.67:/tmp/
scp -i .ssh/jobone2026.pem -r database/migrations/2026_04_12_060000_create_notification_subscriptions_table.php ubuntu@3.108.161.67:/tmp/

# SSH and move files
ssh -i .ssh/jobone2026.pem ubuntu@3.108.161.67
sudo mv /tmp/web-notifications.js /var/www/jobone/public/js/
sudo mv /tmp/NotificationController.php /var/www/jobone/app/Http/Controllers/
sudo mv /tmp/NotificationSubscription.php /var/www/jobone/app/Models/
sudo mv /tmp/notification-controls.blade.php /var/www/jobone/resources/views/components/
sudo mv /tmp/app.blade.php /var/www/jobone/resources/views/layouts/
sudo mv /tmp/web.php /var/www/jobone/routes/
sudo mv /tmp/2026_04_12_060000_create_notification_subscriptions_table.php /var/www/jobone/database/migrations/

# Fix permissions
sudo chown -R www-data:www-data /var/www/jobone
sudo chmod -R 755 /var/www/jobone/public/js

# Run migration
cd /var/www/jobone
sudo -u www-data php artisan migrate

# Clear cache
sudo -u www-data php artisan optimize:clear
sudo -u www-data php artisan route:cache
sudo systemctl restart php8.2-fpm
```

## Testing

### 1. Test Notification Enable
1. Visit https://jobone.in
2. Look for blue "Enable Notifications" button in bottom-right
3. Click it
4. Allow browser permission
5. Button should turn green "Notifications ON"

### 2. Test Notification Disable
1. Click green "Notifications ON" button
2. Should turn back to blue "Enable Notifications"
3. Toast message: "Notifications disabled"

### 3. Test Feedback
1. Click purple "Feedback" button
2. Fill form
3. Submit
4. Check logs: `tail -f /var/www/jobone/storage/logs/laravel.log`

## Viewing Feedback

Feedback is logged to Laravel logs:
```bash
ssh -i .ssh/jobone2026.pem ubuntu@3.108.161.67
tail -f /var/www/jobone/storage/logs/laravel.log | grep "User Feedback"
```

## Database Queries

### View all subscriptions
```sql
SELECT * FROM notification_subscriptions ORDER BY created_at DESC;
```

### Count active subscriptions
```sql
SELECT COUNT(*) FROM notification_subscriptions WHERE is_active = 1;
```

### View recent subscriptions
```sql
SELECT * FROM notification_subscriptions 
WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
ORDER BY created_at DESC;
```

## Future Enhancements

1. **Admin Dashboard**
   - View subscription statistics
   - View feedback submissions
   - Send test notifications

2. **Notification Preferences**
   - Let users choose notification types
   - Frequency settings
   - Quiet hours

3. **Email Integration**
   - Send feedback to admin email
   - Email notifications for critical feedback

4. **Analytics**
   - Track notification click rates
   - Feedback response rates
   - User engagement metrics

## Troubleshooting

### Notifications not working
1. Check browser console for errors
2. Verify service worker is registered
3. Check database for subscription entry
4. Verify VAPID keys are configured

### Feedback not submitting
1. Check Laravel logs for errors
2. Verify CSRF token is present
3. Check network tab for API response

### Button not showing
1. Clear browser cache
2. Check if JavaScript file is loaded
3. Verify component is included in layout

## Browser Support

- ✅ Chrome 50+
- ✅ Firefox 44+
- ✅ Edge 17+
- ✅ Safari 16+ (macOS 13+)
- ❌ IE (not supported)

## Security Notes

- CSRF protection enabled on all endpoints
- IP address and user agent logged for security
- Subscription endpoints require valid tokens
- Feedback limited to 1000 characters
- Rate limiting recommended for production

---

**Status**: ✅ Fully implemented and ready for deployment
**Last Updated**: April 12, 2026
