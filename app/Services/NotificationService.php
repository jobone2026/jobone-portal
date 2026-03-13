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
            
            // Send to WhatsApp
            $this->sendToWhatsApp($post);
            
            // Send Web Push Notification
            $this->sendWebPushNotification($post);
            
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
        $botToken = env('TELEGRAM_BOT_TOKEN');
        $channelId = env('TELEGRAM_CHANNEL_ID'); // e.g., @yourchannel or -1001234567890
        
        if (!$botToken || !$channelId) {
            Log::warning('Telegram credentials not configured');
            return false;
        }
        
        $postUrl = route('posts.show', [$post->type, $post->slug]);
        
        // Format message with emojis
        $emoji = $this->getEmojiForType($post->type);
        $message = "{$emoji} *" . $this->escapeMarkdown($post->title) . "*\n\n";
        
        if ($post->short_description) {
            $message .= $this->escapeMarkdown($post->short_description) . "\n\n";
        }
        
        if ($post->last_date) {
            $message .= "📅 *Last Date:* " . $post->last_date->format('d M Y') . "\n";
        }
        
        if ($post->total_posts) {
            $message .= "📊 *Total Posts:* " . $post->total_posts . "\n";
        }
        
        $message .= "\n🔗 [Apply Now](" . $postUrl . ")";
        $message .= "\n\n#" . str_replace(' ', '', ucwords(str_replace('_', ' ', $post->type)));
        
        if ($post->state) {
            $message .= " #" . str_replace(' ', '', $post->state->name);
        }
        
        try {
            $response = Http::post("https://api.telegram.org/bot{$botToken}/sendMessage", [
                'chat_id' => $channelId,
                'text' => $message,
                'parse_mode' => 'Markdown',
                'disable_web_page_preview' => false,
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
     * Send notification to WhatsApp Channel using WhatsApp Business API
     */
    protected function sendToWhatsApp(Post $post)
    {
        $accessToken = env('WHATSAPP_ACCESS_TOKEN');
        $phoneNumberId = env('WHATSAPP_PHONE_NUMBER_ID');
        $channelId = env('WHATSAPP_CHANNEL_ID'); // Your WhatsApp Channel ID
        
        if (!$accessToken || !$phoneNumberId || !$channelId) {
            Log::warning('WhatsApp credentials not configured');
            return false;
        }
        
        $postUrl = route('posts.show', [$post->type, $post->slug]);
        
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
        
        try {
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
     * Send Web Push Notification using Firebase Admin SDK
     */
    protected function sendWebPushNotification(Post $post)
    {
        $firebaseCredentials = env('FIREBASE_CREDENTIALS');
        
        if (!$firebaseCredentials || !file_exists(base_path($firebaseCredentials))) {
            Log::warning('Firebase credentials not configured');
            return false;
        }
        
        try {
            // Initialize Firebase Admin SDK
            $factory = (new \Kreait\Firebase\Factory)->withServiceAccount(base_path($firebaseCredentials));
            $messaging = $factory->createMessaging();
            
            $postUrl = route('posts.show', [$post->type, $post->slug]);
            
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
