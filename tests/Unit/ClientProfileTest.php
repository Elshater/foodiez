<?php
// filepath: tests/Unit/ClientProfileTest.php
namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClientProfileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function client_can_view_their_profile()
    {
        $client = Client::factory()->create();

        $response = $this->actingAs($client, 'client')->get('/client/profile');
        $response->assertStatus(200);
        $response->assertViewIs('client.profile');
    }

    /** @test */
    public function client_can_update_their_profile()
    {
        $client = Client::factory()->create();

        $response = $this->actingAs($client, 'client')->post('/client/profile/store', [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ]);

        $response->assertRedirect('/client/profile');
        $this->assertDatabaseHas('clients', [
            'id' => $client->id,
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ]);
    }
}