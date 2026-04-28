<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramService
{
    private string $botToken;
    private string $chatId;
    private string $apiBase;

    public function __construct()
    {
        $this->botToken = config('services.telegram.bot_token', '');
        $this->chatId   = config('services.telegram.chat_id', '');
        $this->apiBase  = "https://api.telegram.org/bot{$this->botToken}";
    }

    public function isConfigured(): bool
    {
        return !empty($this->botToken) && !empty($this->chatId);
    }

    /**
     * Send a message to the Telegram channel.
     */
    public function sendMessage(string $text, array $options = []): bool
    {
        if (!$this->isConfigured()) {
            Log::warning('TelegramService: BOT_TOKEN or CHANNEL_ID not configured.');
            return false;
        }

        try {
            $payload = array_merge([
                'chat_id'                  => $this->chatId,
                'text'                     => $text,
                'parse_mode'               => 'HTML',
                'disable_web_page_preview' => false,
            ], $options);

            $response = Http::timeout(10)
                ->post("{$this->apiBase}/sendMessage", $payload);

            if (!$response->successful()) {
                Log::error('Telegram sendMessage failed', [
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);
                return false;
            }

            return true;
        } catch (\Exception $e) {
            Log::error('TelegramService exception: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Build a deadline alert message for a post.
     */
    public static function buildDeadlineMessage(\App\Models\Post $post, int $daysLeft): string
    {
        $url      = route('posts.show', [$post->type, $post->slug]);
        $cleanTitle = \App\Helpers\PostHelper::cleanTitle($post->title);

        // Urgency header
        if ($daysLeft === 0) {
            $header = "🔥🔥 <b>LAST DATE TODAY!</b> 🔥🔥";
            $urgencyNote = "⚠️ <b>Apply RIGHT NOW — form closes tonight!</b>";
        } elseif ($daysLeft === 1) {
            $header = "🔥 <b>LAST DATE TOMORROW!</b>";
            $urgencyNote = "⚠️ Only <b>1 day left</b> — don't miss it!";
        } else {
            $header = "🔥 <b>DEADLINE APPROACHING</b>";
            $urgencyNote = "⏳ Only <b>{$daysLeft} days left</b> to apply!";
        }

        $typeEmoji = match($post->type) {
            'job'         => '💼',
            'admit_card'  => '🎟️',
            'result'      => '🏆',
            'answer_key'  => '🔑',
            'syllabus'    => '📚',
            'scholarship' => '🎓',
            default       => '📢',
        };

        $typeLabel = match($post->type) {
            'job'         => 'Job',
            'admit_card'  => 'Admit Card',
            'result'      => 'Result',
            'answer_key'  => 'Answer Key',
            'syllabus'    => 'Syllabus',
            'scholarship' => 'Scholarship',
            default       => ucfirst($post->type),
        };

        $msg  = "{$header}\n\n";
        $msg .= "{$typeEmoji} <b>{$cleanTitle}</b>\n\n";

        if ($post->organization) {
            $msg .= "🏛️ <b>Organisation:</b> {$post->organization}\n";
        }
        if ($post->type === 'job' || $post->type === 'scholarship') {
            if ($post->total_posts) {
                $msg .= "📊 <b>Vacancies:</b> " . number_format($post->total_posts) . " Posts\n";
            }
            if ($post->salary) {
                $msg .= "💰 <b>Salary:</b> {$post->salary}\n";
            }
        }
        if ($post->state) {
            $msg .= "📍 <b>State:</b> {$post->state->name}\n";
        } else {
            $msg .= "📍 <b>Location:</b> All India\n";
        }

        $lastDateStr = $post->last_date->format('d M Y');
        $msg .= "📅 <b>Last Date:</b> <u>{$lastDateStr}</u>\n\n";
        $msg .= "{$urgencyNote}\n\n";
        $msg .= "🔗 <b>View {$typeLabel}:</b>\n{$url}\n\n";
        $msg .= "━━━━━━━━━━━━━━━━━━━━\n";
        $msg .= "📌 <a href=\"https://jobone.in\">JobOne.in</a> — Sarkari Naukri & Govt Jobs\n";
        $msg .= "🔔 <a href=\"https://t.me/jobone2026\">Join Telegram @jobone2026</a>";

        return $msg;
    }

    /**
     * Build a "Date Extended" alert message.
     */
    public static function buildDateExtendedMessage(\App\Models\Post $post): string
    {
        $url        = route('posts.show', [$post->type, $post->slug]);
        $cleanTitle = \App\Helpers\PostHelper::cleanTitle($post->title);
        $newDate    = $post->last_date->format('d M Y');

        $typeEmoji = match($post->type) {
            'job'         => '💼',
            'admit_card'  => '🎟️',
            'result'      => '🏆',
            'answer_key'  => '🔑',
            'syllabus'    => '📚',
            'scholarship' => '🎓',
            default       => '📢',
        };

        $msg  = "🔥 <b>DATE EXTENDED!</b> ✅\n\n";
        $msg .= "{$typeEmoji} <b>{$cleanTitle}</b>\n\n";

        if ($post->organization) {
            $msg .= "🏛️ <b>Organisation:</b> {$post->organization}\n";
        }
        if (in_array($post->type, ['job', 'scholarship'])) {
            if ($post->total_posts) {
                $msg .= "📊 <b>Vacancies:</b> " . number_format($post->total_posts) . " Posts\n";
            }
            if ($post->salary) {
                $msg .= "💰 <b>Salary:</b> {$post->salary}\n";
            }
        }
        if ($post->state) {
            $msg .= "📍 <b>State:</b> {$post->state->name}\n";
        } else {
            $msg .= "📍 <b>Location:</b> All India\n";
        }

        $msg .= "📅 <b>New Last Date:</b> <u>{$newDate}</u>\n\n";
        $msg .= "✅ <b>Good news! You still have time to apply.</b>\n";
        $msg .= "⚡ Apply before the new deadline!\n\n";
        $msg .= "🔗 <b>Apply / View Details:</b>\n{$url}\n\n";
        $msg .= "━━━━━━━━━━━━━━━━━━━━\n";
        $msg .= "📌 <a href=\"https://jobone.in\">JobOne.in</a> — Sarkari Naukri & Govt Jobs\n";
        $msg .= "🔔 <a href=\"https://t.me/jobone2026\">Join Telegram @jobone2026</a>";

        return $msg;
    }
}
