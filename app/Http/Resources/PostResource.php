<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'type' => $this->type,
            'short_description' => $this->short_description,
            'content' => $this->content,
            'organization' => $this->organization,
            'total_posts' => $this->total_posts,
            'last_date' => $this->last_date?->format('Y-m-d'),
            'notification_date' => $this->notification_date?->format('Y-m-d'),
            'important_links' => $this->important_links,
            'tags' => $this->tags,
            'education' => $this->education,
            'is_featured' => $this->is_featured,
            'is_published' => $this->is_published,
            'view_count' => $this->view_count,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'meta_keywords' => $this->meta_keywords,
            'category' => $this->whenLoaded('category', function () {
                return [
                    'id' => $this->category->id,
                    'name' => $this->category->name,
                    'slug' => $this->category->slug,
                ];
            }),
            'state' => $this->whenLoaded('state', function () {
                return $this->state ? [
                    'id' => $this->state->id,
                    'name' => $this->state->name,
                    'slug' => $this->state->slug,
                ] : null;
            }),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
