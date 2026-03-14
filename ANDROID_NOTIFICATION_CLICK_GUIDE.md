# Android App - Handle Notification Click to Open Post

## Overview
When users tap a push notification, the Android app should open the specific post page in a WebView or browser.

## What's Included in Notification

The notification payload includes:
```json
{
  "notification": {
    "title": "💼 New Job",
    "body": "Post Title Here"
  },
  "data": {
    "post_id": "123",
    "post_type": "job",
    "post_slug": "post-slug-here",
    "url": "https://jobone.in/jobs/post-slug-here",
    "title": "Post Title",
    "click_action": "OPEN_POST",
    "action": "open_url"
  }
}
```

## Android App Implementation

### 1. Update MainActivity.dart (Flutter)

```dart
import 'package:firebase_messaging/firebase_messaging.dart';
import 'package:url_launcher/url_launcher.dart';

class _MyAppState extends State<MyApp> {
  final FirebaseMessaging _firebaseMessaging = FirebaseMessaging.instance;

  @override
  void initState() {
    super.initState();
    _configureFirebaseMessaging();
  }

  void _configureFirebaseMessaging() {
    // Request permission for iOS
    _firebaseMessaging.requestPermission(
      alert: true,
      badge: true,
      sound: true,
    );

    // Subscribe to topic
    _firebaseMessaging.subscribeToTopic('all_posts');

    // Handle notification when app is in foreground
    FirebaseMessaging.onMessage.listen((RemoteMessage message) {
      print('Got a message whilst in the foreground!');
      print('Message data: ${message.data}');

      if (message.notification != null) {
        print('Message also contained a notification: ${message.notification}');
        // Show local notification or update UI
      }
    });

    // Handle notification click when app is in background or terminated
    FirebaseMessaging.onMessageOpenedApp.listen((RemoteMessage message) {
      print('A new onMessageOpenedApp event was published!');
      _handleNotificationClick(message.data);
    });

    // Check if app was opened from a notification (when app was terminated)
    _firebaseMessaging.getInitialMessage().then((RemoteMessage? message) {
      if (message != null) {
        _handleNotificationClick(message.data);
      }
    });
  }

  void _handleNotificationClick(Map<String, dynamic> data) {
    print('Notification clicked with data: $data');
    
    if (data.containsKey('url')) {
      String url = data['url'];
      _openUrl(url);
    }
  }

  Future<void> _openUrl(String url) async {
    final Uri uri = Uri.parse(url);
    
    if (await canLaunchUrl(uri)) {
      await launchUrl(
        uri,
        mode: LaunchMode.externalApplication, // Opens in browser
        // OR use LaunchMode.inAppWebView to open in WebView
      );
    } else {
      print('Could not launch $url');
    }
  }
}
```

### 2. Add Dependencies to pubspec.yaml

```yaml
dependencies:
  flutter:
    sdk: flutter
  firebase_core: ^2.24.2
  firebase_messaging: ^14.7.9
  url_launcher: ^6.2.2
```

### 3. Update AndroidManifest.xml

Add intent filter to handle notification clicks:

```xml
<activity
    android:name=".MainActivity"
    android:launchMode="singleTop"
    android:theme="@style/LaunchTheme"
    android:configChanges="orientation|keyboardHidden|keyboard|screenSize|smallestScreenSize|locale|layoutDirection|fontScale|screenLayout|density|uiMode"
    android:hardwareAccelerated="true"
    android:windowSoftInputMode="adjustResize">
    
    <!-- Deep Links -->
    <intent-filter>
        <action android:name="android.intent.action.VIEW" />
        <category android:name="android.intent.category.DEFAULT" />
        <category android:name="android.intent.category.BROWSABLE" />
        <data
            android:scheme="https"
            android:host="jobone.in" />
    </intent-filter>
    
    <!-- Notification Click -->
    <intent-filter>
        <action android:name="FLUTTER_NOTIFICATION_CLICK" />
        <category android:name="android.intent.category.DEFAULT" />
    </intent-filter>
</activity>
```

### 4. Alternative: Open in WebView Inside App

If you want to open the post inside the app using WebView:

```dart
import 'package:webview_flutter/webview_flutter.dart';

class PostWebView extends StatefulWidget {
  final String url;
  
  const PostWebView({Key? key, required this.url}) : super(key: key);

  @override
  State<PostWebView> createState() => _PostWebViewState();
}

class _PostWebViewState extends State<PostWebView> {
  late final WebViewController controller;

  @override
  void initState() {
    super.initState();
    controller = WebViewController()
      ..setJavaScriptMode(JavaScriptMode.unrestricted)
      ..loadRequest(Uri.parse(widget.url));
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('JobOne.in'),
      ),
      body: WebViewWidget(controller: controller),
    );
  }
}

// Then in _handleNotificationClick:
void _handleNotificationClick(Map<String, dynamic> data) {
  if (data.containsKey('url')) {
    String url = data['url'];
    Navigator.push(
      context,
      MaterialPageRoute(
        builder: (context) => PostWebView(url: url),
      ),
    );
  }
}
```

## Testing

### 1. Test from Admin Panel
1. Go to `/admin/notifications`
2. Send a test notification
3. Tap the notification on your Android device
4. The post page should open

### 2. Test from Command Line
```bash
php artisan notification:test
```

### 3. Check Logs
```bash
# On server
tail -f storage/logs/laravel.log | grep "Android push"

# In Android Studio
# Check Logcat for Firebase messages
```

## Troubleshooting

### Notification doesn't open URL
- Check that `url_launcher` package is installed
- Verify the URL is valid and accessible
- Check Android permiss