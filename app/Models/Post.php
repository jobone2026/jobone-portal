<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title', 'slug', 'type', 'category_id', 'state_id', 'organization',
        'short_description', 'content', 'total_posts',
        'last_date', 'notification_date', 'important_links', 'tags', 'education',
        'meta_title', 'meta_description', 'meta_keywords',
        'is_featured', 'is_published', 'view_count', 'admin_id'
    ];

    protected $casts = [
        'important_links' => 'array',
        'tags' => 'array',
        'education' => 'array',
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
