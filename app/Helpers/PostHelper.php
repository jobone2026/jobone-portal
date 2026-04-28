<?php

namespace App\Helpers;

use App\Models\Post;
use Carbon\Carbon;

class PostHelper
{
    /**
     * Strip leading emoji / symbol prefixes that scrapers inject into titles.
     * e.g. "🔥 SSC CGL Result 2025 ➡️" → "SSC CGL Result 2025"
     */
    public static function cleanTitle(string $title): string
    {
        // Remove leading emoji, symbols, punctuation and whitespace
        $cleaned = preg_replace(
            '/^[\s\p{So}\p{Sm}\p{Po}\p{Pd}\p{Ps}\p{Pe}\p{Pi}\p{Pf}\x{2000}-\x{206F}\x{2600}-\x{27BF}\x{1F000}-\x{1FFFF}\x{FE00}-\x{FEFF}]+/u',
            '',
            $title
        );
        // Also strip trailing arrows / symbols like ➡️ 👇
        $cleaned = preg_replace(
            '/[\s\p{So}\p{Sm}\x{2190}-\x{21FF}\x{2600}-\x{27BF}\x{1F000}-\x{1FFFF}]+$/u',
            '',
            $cleaned
        );
        return trim($cleaned) ?: $title; // fallback to original if empty
    }

    /**
     * Generate attention-grabbing badge array for a post — like sarkariresult.com
     * Returns array of ['text'=>'...', 'emoji'=>'...', 'style'=>'...']
     */
    public static function getAttentionBadges(Post $post): array
    {
        $badges = [];
        $now = Carbon::now();

        // 1. TODAY deadline — highest urgency
        if ($post->last_date) {
            $daysLeft = $now->startOfDay()->diffInDays($post->last_date->startOfDay(), false);
            if ($daysLeft === 0) {
                $badges[] = ['text' => 'Last Date Today', 'emoji' => '🔥🔥', 'style' => 'bg:#fee2e2;color:#b91c1c;border:1px solid #fca5a5;'];
            } elseif ($daysLeft > 0 && $daysLeft <= 3) {
                $badges[] = ['text' => "Last {$daysLeft} Days", 'emoji' => '🔥', 'style' => 'bg:#fff7ed;color:#c2410c;border:1px solid #fdba74;'];
            }
        }

        // 2. Date Extended
        if ($post->is_date_extended) {
            $badges[] = ['text' => 'Date Extended', 'emoji' => '🔥', 'style' => 'bg:#fff1f2;color:#be123c;border:1px solid #fecdd3;'];
        }

        // 3. Result Out (result type with final_result link or tags)
        if ($post->type === 'result') {
            if ($post->final_result || ($post->tags && in_array('final_result', $post->tags))) {
                $badges[] = ['text' => 'Result Out', 'emoji' => '🎉', 'style' => 'bg:#fef9c3;color:#854d0e;border:1px solid #fde047;'];
            } else {
                $badges[] = ['text' => 'Result', 'emoji' => '🏆', 'style' => 'bg:#fff7ed;color:#c2410c;border:1px solid #fdba74;'];
            }
        }

        // 4. New post (within 3 days)
        if ($post->created_at && $post->created_at->diffInDays($now) <= 3) {
            $badges[] = ['text' => 'New', 'emoji' => '✅', 'style' => 'bg:#dcfce7;color:#15803d;border:1px solid #86efac;'];
        }

        // 5. New Update (updated recently but not brand new)
        if ($post->updated_at && $post->updated_at->diffInDays($now) <= 2
            && $post->created_at && $post->created_at->diffInDays($now) > 3) {
            $badges[] = ['text' => 'New Update', 'emoji' => '✅', 'style' => 'bg:#e0f2fe;color:#0369a1;border:1px solid #bae6fd;'];
        }

        // 6. Upcoming
        if ($post->is_upcoming) {
            $badges[] = ['text' => 'Upcoming', 'emoji' => '⏳', 'style' => 'bg:#fff7ed;color:#c2410c;border:1px solid #fed7aa;'];
        }

        // 7. Admit Card Available
        if ($post->type === 'admit_card') {
            $badges[] = ['text' => 'Admit Card', 'emoji' => '🎟️', 'style' => 'bg:#faf5ff;color:#7e22ce;border:1px solid #e9d5ff;'];
        }

        // 8. Answer Key Available
        if ($post->type === 'answer_key') {
            $badges[] = ['text' => 'Answer Key', 'emoji' => '🔑', 'style' => 'bg:#fefce8;color:#854d0e;border:1px solid #fde68a;'];
        }

        return $badges;
    }
}
