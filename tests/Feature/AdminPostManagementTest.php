<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class AdminPostManagementTest extends TestCase
{
    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = Admin::factory()->create();
    }

    public function test_admin_can_view_posts_list()
    {
        $response = $this->actingAs($this->admin, 'admin')->get('/admin/posts');
        $response->assertStatus(200);
        $response->assertViewIs('admin.posts.index');
    }

    public function test_admin_can_create_post()
    {
        $category = Category::factory()->create();
        
        $response = $this->actingAs($this->admin, 'admin')->post('/admin/posts', [
            'title' => 'Test Job',
            'slug' => 'test-job',
            'type' => 'job',
            'category_id' => $category->id,
            'short_description' => 'Test description',
            'content' => 'Test content',
            'is_published' => true,
            'is_featured' => false
        ]);

        $response->assertRedirect('/admin/posts');
        $this->assertDatabaseHas('posts', ['title' => 'Test Job']);
    }

    public function test_admin_can_update_post()
    {
        $post = Post::factory()->create();
        
        $response = $this->actingAs($this->admin, 'admin')->put("/admin/posts/{$post->id}", [
            'title' => 'Updated Title',
            'slug' => $post->slug,
            'type' => $post->type,
            'category_id' => $post->category_id,
            'short_description' => 'Updated description',
            'content' => 'Updated content',
            'is_published' => true,
            'is_featured' => false
        ]);

        $response->assertRedirect('/admin/posts');
        $this->assertDatabaseHas('posts', ['title' => 'Updated Title']);
    }

    public function test_admin_can_delete_post()
    {
        $post = Post::factory()->create();
        
        $response = $this->actingAs($this->admin, 'admin')->delete("/admin/posts/{$post->id}");
        $response->assertRedirect('/admin/posts');
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }

    public function test_admin_can_toggle_published_status()
    {
        $post = Post::factory()->create(['is_published' => false]);
        
        $response = $this->actingAs($this->admin, 'admin')->post("/admin/posts/{$post->id}/toggle-published");
        $response->assertJson(['success' => true]);
        $this->assertTrue($post->fresh()->is_published);
    }

    public function test_admin_can_toggle_featured_status()
    {
        $post = Post::factory()->create(['is_featured' => false]);
        
        $response = $this->actingAs($this->admin, 'admin')->post("/admin/posts/{$post->id}/toggle-featured");
        $response->assertJson(['success' => true]);
        $this->assertTrue($post->fresh()->is_featured);
    }

    public function test_cache_invalidated_on_post_create()
    {
        Cache::put('home_sections', ['test' => 'data'], 600);
        
        $category = Category::factory()->create();
        $this->actingAs($this->admin, 'admin')->post('/admin/posts', [
            'title' => 'Test Job',
            'slug' => 'test-job',
            'type' => 'job',
            'category_id' => $category->id,
            'short_description' => 'Test description',
            'content' => 'Test content',
            'is_published' => true,
            'is_featured' => false
        ]);

        $this->assertFalse(Cache::has('home_sections'));
    }

    public function test_cache_invalidated_on_post_update()
    {
        Cache::put('home_sections', ['test' => 'data'], 600);
        $post = Post::factory()->create();
        
        $this->actingAs($this->admin, 'admin')->put("/admin/posts/{$post->id}", [
            'title' => 'Updated Title',
            'slug' => $post->slug,
            'type' => $post->type,
            'category_id' => $post->category_id,
            'short_description' => 'Updated description',
            'content' => 'Updated content',
            'is_published' => true,
            'is_featured' => false
        ]);

        $this->assertFalse(Cache::has('home_sections'));
    }

    public function test_post_validation_requires_title()
    {
        $category = Category::factory()->create();
        
        $response = $this->actingAs($this->admin, 'admin')->post('/admin/posts', [
            'title' => '',
            'slug' => 'test-job',
            'type' => 'job',
            'category_id' => $category->id,
            'short_description' => 'Test description',
            'content' => 'Test content'
        ]);

        $response->assertSessionHasErrors('title');
    }

    public function test_post_validation_requires_valid_type()
    {
        $category = Category::factory()->create();
        
        $response = $this->actingAs($this->admin, 'admin')->post('/admin/posts', [
            'title' => 'Test',
            'slug' => 'test',
            'type' => 'invalid_type',
            'category_id' => $category->id,
            'short_description' => 'Test description',
            'content' => 'Test content'
        ]);

        $response->assertSessionHasErrors('type');
    }

    public function test_post_validation_requires_existing_category()
    {
        $response = $this->actingAs($this->admin, 'admin')->post('/admin/posts', [
            'title' => 'Test',
            'slug' => 'test',
            'type' => 'job',
            'category_id' => 9999,
            'short_description' => 'Test description',
            'content' => 'Test content'
        ]);

        $response->assertSessionHasErrors('category_id');
    }
}
