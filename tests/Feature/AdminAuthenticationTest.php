<?php

namespace Tests\Feature;

use App\Models\Admin;
use Tests\TestCase;

class AdminAuthenticationTest extends TestCase
{
    public function test_admin_login_page_loads()
    {
        $response = $this->get('/admin/login');
        $response->assertStatus(200);
        $response->assertViewIs('admin.auth.login');
    }

    public function test_admin_can_login_with_valid_credentials()
    {
        $admin = Admin::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password123')
        ]);

        $response = $this->post('/admin/login', [
            'email' => 'admin@example.com',
            'password' => 'password123'
        ]);

        $response->assertRedirect('/admin/dashboard');
        $this->assertAuthenticatedAs($admin, 'admin');
    }

    public function test_admin_cannot_login_with_invalid_credentials()
    {
        Admin::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password123')
        ]);

        $response = $this->post('/admin/login', [
            'email' => 'admin@example.com',
            'password' => 'wrongpassword'
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest('admin');
    }

    public function test_admin_dashboard_requires_authentication()
    {
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect('/admin/login');
    }

    public function test_authenticated_admin_can_access_dashboard()
    {
        $admin = Admin::factory()->create();
        
        $response = $this->actingAs($admin, 'admin')->get('/admin/dashboard');
        $response->assertStatus(200);
        $response->assertViewIs('admin.dashboard');
    }

    public function test_admin_can_logout()
    {
        $admin = Admin::factory()->create();
        
        $response = $this->actingAs($admin, 'admin')->post('/admin/logout');
        $response->assertRedirect('/admin/login');
        $this->assertGuest('admin');
    }

    public function test_login_rate_limiting()
    {
        Admin::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password123')
        ]);

        for ($i = 0; $i < 6; $i++) {
            $this->post('/admin/login', [
                'email' => 'admin@example.com',
                'password' => 'wrongpassword'
            ]);
        }

        $response = $this->post('/admin/login', [
            'email' => 'admin@example.com',
            'password' => 'password123'
        ]);

        $response->assertStatus(429);
    }
}
