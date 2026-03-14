# 📱 Android Push Notification Setup

Complete guide to set up push notifications for your Android app.

---

## Part 1: Firebase Setup (Backend)

### Step 1: Create Firebase Project
1. Go to: https://console.firebase.google.com
2. Click **Add Project**
3. Project name: `JobOne`
4. Disable Google Analytics (optional)
5. Click **Create Project**

### Step 2: Add Android App to Firebase
1. In Firebase Console, click **Add app** → Android icon
2. **Android package name**: `com.jobone.app` (use your actual package name)
3. **App nickname**: `JobOne App`
4. Click **Register app**
5. **Download** `google-services.json` file
6. Click **Next** → **Next** → **Continue to console**

### Step 3: Get Firebase Service Account (for Backend)
1. In Firebase Console → **Project Settings** (gear icon)
2. Go to **Service Accounts** tab
3. Click **Generate New Private Key** button
4. Download the JSON file (e.g., `jobone-firebase-adminsdk.json`)
5. Save it to your Laravel project: `storage/app/firebase/jobone-firebase-adminsdk.json`

### Step 4: Install Firebase Admin SDK in Laravel
```bash
composer require kreait/firebase-php
```

### Step 5: Add to Laravel .env
```env
FIREBASE_CREDENTIALS=storage/app/firebase/jobone-firebase-adminsdk.json
```

---

## Part 2: Android App Setup

### Step 1: Add Firebase to Android Project

**In `build.gradle` (Project level):**
```gradle
buildscript {
    dependencies {
        classpath 'com.google.gms:google-services:4.4.0'
    }
}
```

**In `build.gradle` (App level):**
```gradle
plugins {
    id 'com.android.application'
    id 'com.google.gms.google-services'
}

dependencies {
    implementation platform('com.google.firebase:firebase-bom:32.7.0')
    implementation 'com.google.firebase:firebase-messaging'
    implementation 'com.google.firebase:firebase-analytics'
}
```

### Step 2: Add google-services.json
1. Copy `google-services.json` to `app/` folder
2. Sync project

### Step 3: Add Permissions (AndroidManifest.xml)
```xml
<manifest>
    <uses-permission android:name="android.permission.INTERNET"/>
    <uses-permission android:name="android.permission.POST_NOTIFICATIONS"/>
    
    <application>
        <!-- Firebase Messaging Service -->
        <service
            android:name=".MyFirebaseMessagingService"
            android:exported="false">
            <intent-filter>
                <action android:name="com.google.firebase.MESSAGING_EVENT"/>
            </intent-filter>
        </service>
        
        <!-- Default notification channel -->
        <meta-data
            android:name="com.google.firebase.messaging.default_notification_channel_id"
            android:value="job_notifications"/>
    </application>
</manifest>
```

### Step 4: Create Firebase Messaging Service

**Create file: `MyFirebaseMessagingService.java`**
```java
package com.jobone.app;

import android.app.NotificationChannel;
import android.app.NotificationManager;
import android.app.PendingIntent;
import android.content.Intent;
import android.os.Build;
import android.util.Log;
import androidx.core.app.NotificationCompat;
import com.google.firebase.messaging.FirebaseMessagingService;
import com.google.firebase.messaging.RemoteMessage;

public class MyFirebaseMessagingService extends FirebaseMessagingService {
    
    private static final String TAG = "FCM Service";
    private static final String CHANNEL_ID = "job_notifications";
    
    @Override
    public void onMessageReceived(RemoteMessage remoteMessage) {
        Log.d(TAG, "From: " + remoteMessage.getFrom());
        
        // Check if message contains notification payload
        if (remoteMessage.getNotification() != null) {
            String title = remoteMessage.getNotification().getTitle();
            String body = remoteMessage.getNotification().getBody();
            
            // Get post URL from data
            String postUrl = remoteMessage.getData().get("url");
            
            sendNotification(title, body, postUrl);
        }
    }
    
    @Override
    public void onNewToken(String token) {
        Log.d(TAG, "New FCM token: " + token);
        
        // Send token to your server
        sendTokenToServer(token);
    }
    
    private void sendNotification(String title, String body, String url) {
        Intent intent = new Intent(this, MainActivity.class);
        intent.putExtra("url", url);
        intent.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
        
        PendingIntent pendingIntent = PendingIntent.getActivity(
            this, 0, intent, PendingIntent.FLAG_IMMUTABLE
        );
        
        NotificationCompat.Builder notificationBuilder =
            new NotificationCompat.Builder(this, CHANNEL_ID)
                .setSmallIcon(R.drawable.ic_notification)
                .setContentTitle(title)
                .setContentText(body)
                .setAutoCancel(true)
                .setContentIntent(pendingIntent)
                .setPriority(NotificationCompat.PRIORITY_HIGH);
        
        NotificationManager notificationManager =
            (NotificationManager) getSystemService(NOTIFICATION_SERVICE);
        
        // Create notification channel for Android O+
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.O) {
            NotificationChannel channel = new NotificationChannel(
                CHANNEL_ID,
                "Job Notifications",
                NotificationManager.IMPORTANCE_HIGH
            );
            notificationManager.createNotificationChannel(channel);
        }
        
        notificationManager.notify(0, notificationBuilder.build());
    }
    
    private void sendTokenToServer(String token) {
        // TODO: Send token to your Laravel backend
        // Use Retrofit or Volley to POST to: https://jobone.in/api/save-fcm-token
    }
}
```

### Step 5: Get FCM Token in MainActivity

**In `MainActivity.java`:**
```java
import com.google.firebase.messaging.FirebaseMessaging;

public class MainActivity extends AppCompatActivity {
    
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        
        // Get FCM token
        FirebaseMessaging.getInstance().getToken()
            .addOnCompleteListener(task -> {
                if (task.isSuccessful()) {
                    String token = task.getResult();
                    Log.d("FCM Token", token);
                    
                    // Send token to server
                    sendTokenToServer(token);
                }
            });
        
        // Subscribe to topic for all users
        FirebaseMessaging.getInstance().subscribeToTopic("all_posts")
            .addOnCompleteListener(task -> {
                Log.d("FCM", "Subscribed to all_posts topic");
            });
    }
    
    private void sendTokenToServer(String token) {
        // TODO: Implement API call to save token
    }
}
```

### Step 6: Request Notification Permission (Android 13+)

**In `MainActivity.java`:**
```java
import android.Manifest;
import android.content.pm.PackageManager;
import android.os.Build;
import androidx.core.app.ActivityCompat;
import androidx.core.content.ContextCompat;

private static final int PERMISSION_REQUEST_CODE = 123;

@Override
protected void onCreate(Bundle savedInstanceState) {
    super.onCreate(savedInstanceState);
    
    // Request notification permission for Android 13+
    if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.TIRAMISU) {
        if (ContextCompat.checkSelfPermission(this, Manifest.permission.POST_NOTIFICATIONS)
                != PackageManager.PERMISSION_GRANTED) {
            ActivityCompat.requestPermissions(this,
                new String[]{Manifest.permission.POST_NOTIFICATIONS},
                PERMISSION_REQUEST_CODE);
        }
    }
}
```

---

## Part 3: Backend API (Already Done!)

The Laravel backend is already set up to send notifications when you publish a post.

**What happens:**
1. You publish a post in admin panel
2. Laravel sends notification to Firebase
3. Firebase sends push to all Android devices
4. Users see notification instantly! 🎉

---

## Testing

### Test 1: Check FCM Token
Run your Android app and check Logcat for:
```
FCM Token: dxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
```

### Test 2: Send Test Notification from Firebase
1. Firebase Console → **Cloud Messaging**
2. Click **Send your first message**
3. Notification title: `Test`
4. Notification text: `Testing push notification`
5. Click **Send test message**
6. Paste your FCM token
7. Click **Test**

### Test 3: Publish a Post
1. Go to admin panel
2. Create and publish a new post
3. Check your Android device - notification should appear!

---

## Notification Icon

Create notification icon:
1. Right-click `res` → **New** → **Image Asset**
2. Icon Type: **Notification Icons**
3. Name: `ic_notification`
4. Choose your icon image
5. Click **Next** → **Finish**

---

## Troubleshooting

**No notification received?**
- Check FCM token is generated
- Verify `google-services.json` is in `app/` folder
- Check Firebase Console for delivery status
- Look at Laravel logs: `storage/logs/laravel.log`
- Ensure app is subscribed to `all_posts` topic

**App crashes?**
- Check all dependencies are added
- Sync Gradle files
- Clean and rebuild project

---

## Summary

✅ Firebase project created
✅ Android app registered
✅ FCM integrated in app
✅ Laravel backend ready
✅ Notifications work automatically!

When you publish a post, all Android app users get instant push notification! 📱🔔
