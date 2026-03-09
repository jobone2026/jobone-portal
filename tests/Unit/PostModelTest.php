<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Post;
use App\Models\State;
use Tests\TestCase;

class PostModelTest extends TestCase
{
    public function test_post_has_correct_fillable_properties()
    {
        $post = new Post();
        $expected = [
            'title', 'slug', 'type', 'category_id', 'state_id',
            'short_description', 'content', 'total_posts',
            'last_date', 'notification_date', 'important_links',
            'meta_title', 'meta_description', 'meta_keywords',
            'is_featured', 'is_published', 'view_count', 'admin_id'
        ];
        
        foreach ($expected as $field) {
            $this->assertContains($field, $post->getFillable());
        }
    }

    public function test_post_belongs_to_category()
    {
        $post = Post::factory()->create();
        $this->assertNotNull($post->category);
        $this->assertInstanceOf(Category::class, $post->category);
    }

    public function test_post_belongs_to_state()
    {
        $post = Post::factory()->create();
        $this->assertNull($post->state) or $this->assertInstanceOf(State::class, $post->state);
    }

    public function test_published_scope_filters_correctly()
    {
        Post::factory()->create(['is_published' => true]);
        Post::factory()->create(['is_published' => false]);
        
        $published = Post::published()->get();
        $this->assertEquals(1, $published->count());
        $this->assertTrue($published->first()->is_published);
    }

    public function test_of_type_scope_filters_correctly()
    {
        Post::factory()->create(['type' => 'job']);
        Post::factory()->create(['type' => 'blog']);
        
        $jobs = Post::ofType('job')->get();
        $this->assertEquals(1, $jobs->count());
        $this->assertEquals('job', $jobs->first()->type);
    }

    public function test_featured_scope_filters_correctly()
    {
        Post::factory()->create(['is_featured' => true]);
        Post::factory()->create(['is_featured' => false]);
        
        $featured = Post::featured()->get();
        $this->assertEquals(1, $featured->count());
        $this->assertTrue($featured->first()->is_featured);
    }

    public function test_recent_scope_filters_correctly()
    {
        Post::factory()->create(['created_at' => now()->subDays(2)]);
        Post::factory()->create(['created_at' => now()->subDays(5)]);
        
        $recent = Post::recent(3)->get();
        $this->assertEquals(1, $recent->count());
    }

    public function test_is_new_returns_true_for_recent_posts()
    {
        $post = Post::factory()->create(['created_at' => now()->subDays(2)]);
        $this->assertTrue($post->isNew());
    }

    public function test_is_new_returns_false_for_old_posts()
    {
        $post = Post::factory()->create(['created_at' => now()->subDays(5)]);
        $this->assertFalse($post->isNew());
    }

    public function test_meta_title_defaults_to_title()
    {
        $post = Post::factory()->create(['title' => 'Test Post', 'meta_title' => null]);
        $this->assertEquals('Test Post', $post->meta_title);
    }

    public function test_meta_description_defaults_to_short_description()
    {
        $description = 'This is a test short description for the post';
        $post = Post::factory()->create(['short_description' => $description, 'meta_description' => null]);
        $this->assertStringContainsString('This is a test', $post->meta_description);
    }

    public function test_view_count_increments()
    {
        $post = Post::factory()->create(['view_count' => 5]);
        $post->increment('view_count');
        $this->assertEquals(6, $post->fresh()->view_count);
    }

    public function test_important_links_cast_to_array()
    {
        $links = [
            ['label' => 'Official', 'url' => 'https://example.com'],
            ['label' => 'Apply', 'url' => 'https://apply.example.com']
        ];
        
        $post = Post::factory()->create(['important_links' => $links]);
        $this->assertIsArray($post->important_links);
        $this->assertEquals(2, count($post->important_links));
    }
}
