<?php
// filepath: tests/Unit/AdminPasswordResetTest.php
namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Password;

class AdminPasswordResetTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_request_password_reset_link()
    {
        $admin = Admin::factory()->create(['email' => 'admin@example.com']);

        $response = $this->post('/admin/password_submit', ['email' => 'admin@example.com']);
        $response->assertStatus(302);
        $response->assertSessionHas('success');
    }

    /** @test */
    public function admin_can_reset_password_with_valid_token()
    {
        $admin = Admin::factory()->create(['email' => 'admin@example.com']);
        $token = Password::broker('admins')->createToken($admin);

        $response = $this->post('/admin/reset_password_submit', [
            'email' => 'admin@example.com',
            'token' => $token,
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword',
        ]);

        $response->assertRedirect('/admin/login');
        $response->assertSessionHas('success');
    }
}