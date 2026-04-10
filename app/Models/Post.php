<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title', 'slug', 'type', 'category_id', 'state_id', 'organization',
        'short_description', 'content', 'total_posts',
        'last_date', 'notification_date', 'important_links',
        'meta_title', 'meta_description', 'meta_keywords',
        'is_featured', 'is_published', 'view_count', 'admin_id'
    ];

    protected $casts = [
        'important_links' => 'array',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
        'last_date' => 'datetime',
        'notification_date' => 'datetime'
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    /**
     * The "booted" method of the model.
     * Automatically sanitize content on saving.
     */
    protected static function booted()
    {
        static::saving(function ($post) {
            if ($post->isDirty('content')) {
                $post->content = static::sanitizeContent($post->content);
            }
        });
    }

    /**
     * Sanitize content by removing embedded CSS/Style blocks.
     */
    public static function sanitizeContent($content)
    {
        if (empty($content)) return $content;

        // 1. Remove entire <style>...</style> blocks (including those matching our known patterns)
        $content = preg_replace('/<style\b[^>]*>(.*?)<\/style>/is', '', $content);

        // 2. Remove any text starting with .puc-result or .puc-blog that looks like leaked CSS
        // This handles cases where raw CSS is pasted without <style> tags
        $leakedPatterns = [
            '/\.puc-result\s*{[^}]*}/is',
            '/\.puc-blog\s*{[^}]*}/is',
            '/\.stream-icon\s*{[^}]*}/is',
            '/\.puc-result\s+\.stream-name\s*{[^}]*}/is',
            '/\.banner\s*{[^}]*}/is',
            '/\*\s*{\s*box-sizing\s*:\s*border-box[^}]*}/is'
        ];

        foreach ($leakedPatterns as $pattern) {
            $content = preg_replace($pattern, '', $content);
        }

        // 3. Remove leading junk: if the content contains a known container start, 
        // remove everything before it.
        $validStarts = ['<div class="puc-result">', '<div class="puc-blog">', '<div class="hero">'];
        foreach ($validStarts as $start) {
            $pos = strpos($content, $start);
            if ($pos !== false && $pos > 0) {
                // Peek at what we are removing - if it looks like CSS rules, remove it
                $leading = substr($content, 0, $pos);
                if (str_contains($leading, '{') && str_contains($leading, ':')) {
                    $content = substr($content, $pos);
                }
            }
        }

        // 4. Remove stray </style> tags if they were left over
        $content = str_replace('</style>', '', $content);

        return trim($content);
    }

    // Query Scopes
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeRecent($query, $days = 3)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeByState($query, $stateId)
    {
        return $query->where('state_id', $stateId);
    }

    // Accessors
    public function isNew()
    {
        return $this->created_at->diffInDays(now()) <= 3;
    }

    public function getMetaTitleAttribute($value)
    {
        return $value ?: $this->title;
    }

    public function getMetaDescriptionAttribute($value)
    {
        return $value ?: substr(strip_tags($this->short_description), 0, 160);
    }
}
