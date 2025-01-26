<?php
// filepath: tests/Unit/ClientLoginTest.php
namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;

class ClientLoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function client_can_login_with_correct_credentials()
    {
        $client = Client::factory()->create([
            'email' => 'client@example.com',
            'password' => bcrypt('password'),
        ]);

        $credentials = ['email' => 'client@example.com', 'password' => 'password'];
        $this->assertTrue(Auth::guard('client')->attempt($credentials));
    }

    /** @test */
    public function client_cannot_login_with_incorrect_credentials()
    {
        $client = Client::factory()->create([
            'email' => 'client@example.com',
            'password' => bcrypt('password'),
        ]);

        $credentials = ['email' => 'client@example.com', 'password' => 'wrongpassword'];
        $this->assertFalse(Auth::guard('client')->attempt($credentials));
    }
}