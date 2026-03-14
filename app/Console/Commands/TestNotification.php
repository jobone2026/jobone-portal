<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Services\NotificationService;
use Illuminate\Console\Command;

class TestNotification extends Command
{
    protected $signature = 'notification:test';
    protected $description = 'Test notification system';

    public function handle()
    {
        $this->info('🔔 Testing Notification System...');
        $this->newLine();
        
        // Get the latest post
        $post = Post::latest()->first();
        
        if (!$post) {
            $this->error('❌ No posts found in database!');
            $this->info('💡 Create a post first in admin panel');
            return 1;
        }
        
        $this->info('📝 Testing with post: ' . $post->title);
        $this->newLine();
        
        // Test Telegram
        $this->info('📱 Testing Telegram...');
        if (env('TELEGRAM_BOT_TOKEN') && env('TELEGRAM_CHANNEL_ID')) {
            try {
                $notificationService = app(NotificationService::class);
                $result = $notificationService->sendNewPostNotifications($post);
                
                if ($result) {
                    $this->info('✅ Telegram notification sent successfully!');
                    $this->info('   Check your Telegram channel: ' . env('TELEGRAM_CHANNEL_ID'));
                } else {
                    $this->warn('⚠️  Telegram notification failed. Check logs.');
                }
            } catch (\Exception $e) {
                $this->error('❌ Telegram error: ' . $e->getMessage());
            }
        } else {
            $this->warn('⚠️  Telegram not configured');
            $this->info('   Add TELEGRAM_BOT_TOKEN and TELEGRAM_CHANNEL_ID to .env');
        }
        
        $this->newLine();
        
        // Test Firebase
        $this->info('📱 Testing Firebase (Android Push)...');
        if (env('FIREBASE_CREDENTIALS')) {
            $credPath = base_path(env('FIREBASE_CREDENTIALS'));
            if (file_exists($credPath)) {
                $this->info('✅ Firebase credentials found');
                $this->info('   Notification will be sent when post is published');
            } else {
                $this->warn('⚠️  Firebase credentials file not found at: ' . $credPath);
            }
        } else {
            $this->warn('⚠️  Firebase not configured');
            $this->info('   Add FIREBASE_CREDENTIALS to .env');
        }
        
        $this->newLine();
        
        // Test WhatsApp
        $this->info('💬 Testing WhatsApp...');
        if (env('WHATSAPP_ACCESS_TOKEN')) {
            $this->info('✅ WhatsApp configured');
        } else {
            $this->warn('⚠️  WhatsApp not configured (optional)');
            $this->info('   Use WhatsApp Channel manually or add API credentials');
        }
        
        $this->newLine();
        $this->info('📊 Test Summary:');
        $this->table(
            ['Service', 'Status', 'Action'],
            [
                ['Telegram', env('TELEGRAM_BOT_TOKEN') ? '✅ Ready' : '❌ Not configured', 'Check channel'],
                ['Firebase', env('FIREBASE_CREDENTIALS') ? '✅ Ready' : '❌ Not configured', 'Publish a post'],
                ['WhatsApp', env('WHATSAPP_ACCESS_TOKEN') ? '✅ Ready' : '⚠️  Optional', 'Manual or API'],
            ]
        );
        
        $this->newLine();
        $this->info('💡 Next Steps:');
        $this->info('1. Set up Telegram: See TELEGRAM_SETUP_QUICK.md');
        $this->info('2. Publish a post in admin panel');
        $this->info('3. Check notifications arrive!');
        
        return 0;
    }
}
