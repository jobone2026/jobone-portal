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
            // Load state relationship if not already loaded
            if (!$post->relationLoaded('state')) {
                $post->load('state');
            }
            
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
            $typeInfo = $this->getTypeInfo($post->type);
            
            // Format message - Unified Fancy Style
            $message = "{$typeInfo['emoji']} *{$typeInfo['title']}* {$typeInfo['emoji']}\n";
            $message .= "━━━━━━━━━━━━━━━━\n\n";
            $message .= "🔥 *" . $this->escapeMarkdown($post->title) . "*\n\n";
            
            // Add state
            $stateName = $post->state ? $post->state->name : 'All India';
            $message .= "📍 *State:* " . $this->escapeMarkdown($stateName) . "\n";
            
            // Add total posts if available
            if ($post->total_posts) {
                $message .= "👥 *Total Posts:* " . $post->total_posts . "\n";
            }
            
            // Add application start (notification date)
            if ($post->notification_date) {
                $message .= "🟣 *{$typeInfo['date_label']}:* " . $post->notification_date->format('d-m-Y') . "\n";
            }
            
            // Add last date
            if ($post->last_date) {
                $message .= "🟢 *Last Date:* " . $post->last_date->format('d-m-Y') . "\n";
            } else {
                $message .= "🟢 *Last Date:* -\n";
            }
            
            // Add education
            if (!empty($post->education) && is_array($post->education)) {
                $educationLabels = $this->getEducationLabels($post->education);
                if (!empty($educationLabels)) {
                    $message .= "🎓 *Education:* " . $this->escapeMarkdown(implode(', ', $educationLabels)) . "\n";
                }
            }
            
            $message .= "\n➡️ *Apply Here:* [Click Here](" . $postUrl . ")\n";
            
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
            
            $typeInfo = $this->getTypeInfo($post->type);
            
            // Format message - Unified Fancy Style (matches Telegram exactly)
            $message = "{$typeInfo['emoji']} *{$typeInfo['title']}* {$typeInfo['emoji']}\n";
            $message .= "━━━━━━━━━━━━━━━━\n\n";
            $message .= "🔥 *{$post->title}*\n\n";
            
            // Add state
            $stateName = $post->state ? $post->state->name : 'All India';
            $message .= "📍 *State:* " . $stateName . "\n";
            
            // Add total posts if available
            if ($post->total_posts) {
                $message .= "👥 *Total Posts:* " . $post->total_posts . "\n";
            }
            
            // Add application start (notification date)
            if ($post->notification_date) {
                $message .= "🟣 *{$typeInfo['date_label']}:* " . $post->notification_date->format('d-m-Y') . "\n";
            }
            
            // Add last date
            if ($post->last_date) {
                $message .= "🟢 *Last Date:* " . $post->last_date->format('d-m-Y') . "\n";
            } else {
                $message .= "🟢 *Last Date:* -\n";
            }
            
            // Add education
            if (!empty($post->education) && is_array($post->education)) {
                $educationLabels = $this->getEducationLabels($post->education);
                if (!empty($educationLabels)) {
                    $message .= "🎓 *Education:* " . implode(', ', $educationLabels) . "\n";
                }
            }
            
            $message .= "\n➡️ *Apply Here:* " . $postUrl . "\n";
            
            // Add hashtags
            $message .= "\n#jobone2026 #jobone #{$post->type}";
            
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
    
    /**
     * Get readable education labels from education codes
     */
    protected function getEducationLabels($educationArray)
    {
        $labels = [
            '10th_pass' => '10th Pass',
            '12th_pass' => '12th Pass',
            'graduate' => 'Graduate',
            'post_graduate' => 'Post Graduate',
            'diploma' => 'Diploma',
            'iti' => 'ITI',
            'btech' => 'B.Tech/B.E',
            'mtech' => 'M.Tech/M.E',
            'bsc' => 'B.Sc',
            'msc' => 'M.Sc',
            'bcom' => 'B.Com',
            'mcom' => 'M.Com',
            'ba' => 'B.A',
            'ma' => 'M.A',
            'bba' => 'BBA',
            'mba' => 'MBA',
            'ca' => 'CA',
            'cs' => 'CS',
            'cma' => 'CMA',
            'llb' => 'LLB',
            'llm' => 'LLM',
            'mbbs' => 'MBBS',
            'bds' => 'BDS',
            'bpharm' => 'B.Pharm',
            'mpharm' => 'M.Pharm',
            'nursing' => 'Nursing',
            'bed' => 'B.Ed',
            'med' => 'M.Ed',
            'phd' => 'PhD',
            'any_qualification' => 'Any Qualification',
        ];
        
        $result = [];
        foreach ($educationArray as $code) {
            if (isset($labels[$code])) {
                $result[] = $labels[$code];
            }
        }
        
        return $result;
    }
}