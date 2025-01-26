<?php
// filepath: tests/Unit/ClientPasswordResetTest.php
namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Password;

class ClientPasswordResetTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function client_can_request_password_reset_link()
    {
        $client = Client::factory()->create(['email' => 'client@example.com']);

        $response = $this->post('/client/password_submit', ['email' => 'client@example.com']);
        $response->assertStatus(302);
        $response->assertSessionHas('success');
    }

    /** @test */
    public function client_can_reset_password_with_valid_token()
    {
        $client = Client::factory()->create(['email' => 'client@example.com']);
        $token = Password::broker('clients')->createToken($client);

        $response = $this->post('/client/reset_password_submit', [
            'email' => 'client@example.com',
            'token' => $token,
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword',
        ]);

        $response->assertRedirect('/client/login');
        $response->assertSessionHas('success');
    }
}