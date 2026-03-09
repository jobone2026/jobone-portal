<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use App\Models\State;
use Tests\TestCase;

class PublicRoutesTest extends TestCase
{
    public function test_home_page_loads()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertViewIs('home');
    }

    public function test_home_page_displays_sections()
    {
        Post::factory()->create(['type' => 'job', 'is_published' => true]);
        Post::factory()->create(['type' => 'blog', 'is_published' => true]);
        
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertViewHas('sections');
    }

    public function test_jobs_listing_page_loads()
    {
        Post::factory()->create(['type' => 'job', 'is_published' => true]);
        
        $response = $this->get('/jobs');
        $response->assertStatus(200);
        $response->assertViewIs('posts.index');
    }

    public function test_jobs_listing_shows_only_published_posts()
    {
        Post::factory()->create(['type' => 'job', 'is_published' => true]);
        Post::factory()->create(['type' => 'job', 'is_published' => false]);
        
        $response = $this->get('/jobs');
        $posts = $response->viewData('posts');
        
        foreach ($posts as $post) {
            $this->assertTrue($post->is_published);
        }
    }

    public function test_single_post_page_loads()
    {
        $post = Post::factory()->create(['is_published' => true]);
        
        $response = $this->get("/{$post->type}/{$post->slug}");
        $response->assertStatus(200);
        $response->assertViewIs('posts.show');
    }

    public function test_unpublished_post_returns_404()
    {
        $post = Post::factory()->create(['is_published' => false]);
        
        $response = $this->get("/{$post->type}/{$post->slug}");
        $response->assertStatus(404);
    }

    public function test_post_view_count_increments()
    {
        $post = Post::factory()->create(['is_published' => true, 'view_count' => 0]);
        
        $this->get("/{$post->type}/{$post->slug}");
        $this->assertEquals(1, $post->fresh()->view_count);
    }

    public function test_category_page_loads()
    {
        $category = Category::factory()->create();
        Post::factory()->create(['category_id' => $category->id, 'is_published' => true]);
        
        $response = $this->get("/category/{$category->slug}");
        $response->assertStatus(200);
    }

    public function test_category_page_shows_only_category_posts()
    {
        $category1 = Category::factory()->create();
        $category2 = Category::factory()->create();
        
        Post::factory()->create(['category_id' => $category1->id, 'is_published' => true]);
        Post::factory()->create(['category_id' => $category2->id, 'is_published' => true]);
        
        $response = $this->get("/category/{$category1->slug}");
        $posts = $response->viewData('posts');
        
        foreach ($posts as $post) {
            $this->assertEquals($category1->id, $post->category_id);
        }
    }

    public function test_state_page_loads()
    {
        $state = State::factory()->create();
        Post::factory()->create(['state_id' => $state->id, 'is_published' => true]);
        
        $response = $this->get("/state/{$state->slug}");
        $response->assertStatus(200);
    }

    public function test_search_returns_results()
    {
        Post::factory()->create(['title' => 'Banking Jobs', 'is_published' => true]);
        
        $response = $this->get('/search?q=Banking');
        $response->assertStatus(200);
        $response->assertViewIs('posts.search');
    }

    public function test_search_filters_by_title()
    {
        Post::factory()->create(['title' => 'Banking Jobs', 'is_published' => true]);
        Post::factory()->create(['title' => 'Railway Jobs', 'is_published' => true]);
        
        $response = $this->get('/search?q=Banking');
        $posts = $response->viewData('posts');
        
        foreach ($posts as $post) {
            $this->assertStringContainsString('Banking', $post->title);
        }
    }

    public function test_sitemap_returns_xml()
    {
        Post::factory()->create(['is_published' => true]);
        
        $response = $this->get('/sitemap.xml');
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/xml');
    }

    public function test_about_page_loads()
    {
        $response = $this->get('/about');
        $response->assertStatus(200);
        $response->assertViewIs('pages.about');
    }

    public function test_contact_page_loads()
    {
        $response = $this->get('/contact');
        $response->assertStatus(200);
        $response->assertViewIs('pages.contact');
    }

    public function test_privacy_page_loads()
    {
        $response = $this->get('/privacy-policy');
        $response->assertStatus(200);
        $response->assertViewIs('pages.privacy');
    }

    public function test_disclaimer_page_loads()
    {
        $response = $this->get('/disclaimer');
        $response->assertStatus(200);
        $response->assertViewIs('pages.disclaimer');
    }
}
