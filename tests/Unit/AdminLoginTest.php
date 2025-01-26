<?php
// filepath: tests/Unit/AdminLoginTest.php
namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;

class AdminLoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_login_with_correct_credentials()
    {
        $admin = Admin::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);

        $credentials = ['email' => 'admin@example.com', 'password' => 'password'];
        $this->assertTrue(Auth::guard('admin')->attempt($credentials));
    }

    /** @test */
    public function admin_cannot_login_with_incorrect_credentials()
    {
        $admin = Admin::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);

        $credentials = ['email' => 'admin@example.com', 'password' => 'wrongpassword'];
        $this->assertFalse(Auth::guard('admin')->attempt($credentials));
    }
}