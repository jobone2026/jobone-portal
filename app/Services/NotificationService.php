<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    /**
     * Send notifications when a new post is published
     */
    public function sendNewPostNotifications(Post $post)
    {
        try {
            // Send to Telegram
            $this->sendToTelegram($post);
            
            // Send to WhatsApp (if configured)
            $this->sendToWhatsApp($post);
            
            // Send Android Push Notification
            $this->sendAndroidPushNotification($post);
            
            Log::info('Notifications sent successfully for post: ' . $post->id);
            
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to send notifications: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Send notification to Telegram Channel
     */
    protected function sendToTelegram(Post $post)
    {
        $botToken = config('notifications.telegram.bot_token');
        $channelId = config('notifications.telegram.channel_id'); // e.g., @yourchannel or -1001234567890
        
        if (!$botToken || !$channelId) {
            Log::warning('Telegram credentials not configured');
            return false;
        }
        
        try {
            $postUrl = route('posts.show', [$post->type, $post]);
            
            // Get type-specific header and emoji
            $typeInfo = $this->getTypeInfo($post->type);
            
            // Format message with type-specific header
            $message = "{$typeInfo['emoji']} *{$typeInfo['title']}* {$typeInfo['emoji']}\n";
            $message .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
            $message .= "🔥 *" . $this->escapeMarkdown($post->title) . "*\n\n";
            
            // Add organization if available
            if ($post->organization) {
                $message .= "🏢 *Organization:* " . $this->escapeMarkdown($post->organization) . "\n";
            }
            
            // Add total posts if available (only for jobs)
            if ($post->total_posts && $post->type === 'job') {
                $message .= "👥 *Total Posts:* " . $post->total_posts . "\n";
            }
            
            // Add notification date if available
            if ($post->notification_date) {
                $message .= "🟣 *{$typeInfo['date_label']}:* " . $post->notification_date->format('d-m-Y') . "\n";
            }
            
            // Add last date if available
            if ($post->last_date) {
                $message .= "🟢 *Last Date:* " . $post->last_date->format('d-m-Y') . "\n";
            } else {
                $message .= "🟢 *Last Date:* -\n";
            }
            
            $message .= "\n➡️ *{$typeInfo['action']}:* [Click Here](" . $postUrl . ")\n";
            
            // Add hashtags
            $message .= "\n#jobone2026 #jobone #{$post->type}";
            
            $response = Http::post("https://api.telegram.org/bot{$botToken}/sendMessage", [
                'chat_id' => $channelId,
                'text' => $message,
                'parse_mode' => 'Markdown',
                'disable_web_page_preview' => true,  // Disable preview to show only formatted text
            ]);
            
            if ($response->successful()) {
                Log::info('Telegram notification sent for post: ' . $post->id);
                return true;
            } else {
                Log::error('Telegram API error: ' . $response->body());
                return false;
            }
        } catch (\Exception $e) {
            Log::error('Telegram notification failed: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Get type-specific information for notifications
     */
    protected function getTypeInfo($type)
    {
        return match($type) {
            'job' => [
                'emoji' => '💼',
                'title' => 'New Job Vacancy',
                'date_label' => 'Application Start',
                'action' => 'Apply Here'
            ],
            'admit_card' => [
                'emoji' => '🎫',
                'title' => 'New Admit Card',
                'date_label' => 'Release Date',
                'action' => 'Download Here'
            ],
            'result' => [
                'emoji' => '📊',
                'title' => 'New Result',
                'date_label' => 'Result Date',
                'action' => 'Check Here'
            ],
            'answer_key' => [
                'emoji' => '🔑',
                'title' => 'New Answer Key',
                'date_label' => 'Release Date',
                'action' => 'Download Here'
            ],
            'syllabus' => [
                'emoji' => '📚',
                'title' => 'New Syllabus',
                'date_label' => 'Release Date',
                'action' => 'Download Here'
            ],
            'blog' => [
                'emoji' => '📝',
                'title' => 'New Article',
                'date_label' => 'Published Date',
                'action' => 'Read Here'
            ],
            default => [
                'emoji' => '📢',
                'title' => 'New Update',
                'date_label' => 'Date',
                'action' => 'View Here'
            ],
        };
    }
    
    /**
     * Send notification to WhatsApp Channel using WhatsApp Business API
     */
    protected function sendToWhatsApp(Post $post)
    {
        $accessToken = config('notifications.whatsapp.access_token');
        $phoneNumberId = config('notifications.whatsapp.phone_number_id');
        $channelId = config('notifications.whatsapp.channel_id'); // Your WhatsApp Channel ID
        
        if (!$accessToken || !$phoneNumberId || !$channelId) {
            Log::warning('WhatsApp credentials not configured');
            return false;
        }
        
        try {
            $postUrl = route('posts.show', [$post->type, $post]);
            
            // Format message
            $emoji = $this->getEmojiForType($post->type);
            $message = "{$emoji} *{$post->title}*\n\n";
            
            if ($post->short_description) {
                $message .= $post->short_description . "\n\n";
            }
            
            if ($post->last_date) {
                $message .= "📅 Last Date: " . $post->last_date->format('d M Y') . "\n";
            }
            
            if ($post->total_posts) {
                $message .= "📊 Total Posts: " . $post->total_posts . "\n";
            }
            
            $message .= "\n🔗 Apply Now: " . $postUrl;
            
            $response = Http::withToken($accessToken)
                ->post("https://graph.facebook.com/v18.0/{$phoneNumberId}/messages", [
                    'messaging_product' => 'whatsapp',
                    'to' => $channelId,
                    'type' => 'text',
                    'text' => [
                        'preview_url' => true,
                        'body' => $message
                    ]
                ]);
            
            if ($response->successful()) {
                Log::info('WhatsApp notification sent for post: ' . $post->id);
                return true;
            } else {
                Log::error('WhatsApp API error: ' . $response->body());
                return false;
            }
        } catch (\Exception $e) {
            Log::error('WhatsApp notification failed: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Send Android Push Notification using Firebase Admin SDK
     */
    protected function sendAndroidPushNotification(Post $post)
    {
        $firebaseCredentials = config('notifications.firebase.credentials');
        
        if (!$firebaseCredentials || !file_exists(base_path($firebaseCredentials))) {
            Log::warning('Firebase credentials not configured');
            return false;
        }
        
        try {
            // Initialize Firebase Admin SDK
            $factory = (new \Kreait\Firebase\Factory)->withServiceAccount(base_path($firebaseCredentials));
            $messaging = $factory->createMessaging();
            
            $postUrl = route('posts.show', [$post->type, $post]);
            $emoji = $this->getEmojiForType($post->type);
            
            // Create notification message with clickable link
            $message = \Kreait\Firebase\Messaging\CloudMessage::withTarget('topic', 'all_posts')
                ->withNotification(\Kreait\Firebase\Messaging\Notification::create(
                    $emoji . ' New ' . ucfirst(str_replace('_', ' ', $post->type)),
                    $post->title
                ))
                ->withData([
                    'post_id' => (string) $post->id,
                    'post_type' => $post->type,
                    'post_slug' => $post->slug,
                    'url' => $postUrl,
                    'title' => $post->title,
                    'click_action' => 'OPEN_POST',
                ])
                ->withAndroidConfig([
                    'priority' => 'high',
                    'notification' => [
                        'icon' => 'ic_notification',
                        'color' => '#2563eb',
                        'sound' => 'default',
                        'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
                        'channel_id' => 'high_importance_channel',
                        'tag' => 'post_' . $post->id,
                    ],
                    'data' => [
                        'url' => $postUrl,
                        'action' => 'open_url',
                    ]
                ]);
            
            $messaging->send($message);
            
            Log::info('Android push notification sent for post: ' . $post->id . ' with URL: ' . $postUrl);
            return true;
            
        } catch (\Exception $e) {
            Log::error('Android push notification failed: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Send Web Push Notification using Firebase Admin SDK
     */
    protected function sendWebPushNotification(Post $post)
    {
        $firebaseCredentials = config('notifications.firebase.credentials');
        
        if (!$firebaseCredentials || !file_exists(base_path($firebaseCredentials))) {
            Log::warning('Firebase credentials not configured');
            return false;
        }
        
        try {
            // Initialize Firebase Admin SDK
            $factory = (new \Kreait\Firebase\Factory)->withServiceAccount(base_path($firebaseCredentials));
            $messaging = $factory->createMessaging();
            
            $postUrl = route('posts.show', [$post->type, $post]);
            
            // Create notification message
            $message = \Kreait\Firebase\Messaging\CloudMessage::withTarget('topic', 'all_posts')
                ->withNotification([
                    'title' => '🔔 New ' . ucfirst(str_replace('_', ' ', $post->type)),
                    'body' => $post->title,
                    'image' => asset('images/jobone-logo.png'),
                ])
                ->withData([
                    'post_id' => (string) $post->id,
                    'post_type' => $post->type,
                    'url' => $postUrl,
                    'click_action' => $postUrl,
                ]);
            
            $messaging->send($message);
            
            Log::info('Web push notification sent for post: ' . $post->id);
            return true;
            
        } catch (\Exception $e) {
            Log::error('Web push notification failed: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Get emoji based on post type
     */
    protected function getEmojiForType($type)
    {
        return match($type) {
            'job' => '💼',
            'admit_card' => '🎫',
            'result' => '📊',
            'answer_key' => '🔑',
            'syllabus' => '📚',
            'blog' => '📝',
            default => '📢',
        };
    }
    
    /**
     * Escape markdown special characters for Telegram
     */
    protected function escapeMarkdown($text)
    {
        $specialChars = ['_', '*', '[', ']', '(', ')', '~', '`', '>', '#', '+', '-', '=', '|', '{', '}', '.', '!'];
        foreach ($specialChars as $char) {
            $text = str_replace($char, '\\' . $char, $text);
        }
        return $text;
    }
}