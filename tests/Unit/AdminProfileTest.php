<?php
// filepath: tests/Unit/AdminProfileTest.php
namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminProfileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_view_their_profile()
    {
        $admin = Admin::factory()->create();

        $response = $this->actingAs($admin, 'admin')->get('/admin/profile');
        $response->assertStatus(200);
        $response->assertViewIs('admin.profile');
    }

    /** @test */
    public function admin_can_update_their_profile()
    {
        $admin = Admin::factory()->create();

        $response = $this->actingAs($admin, 'admin')->post('/admin/profile/store', [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ]);

        $response->assertRedirect('/admin/profile');
        $this->assertDatabaseHas('admins', [
            'id' => $admin->id,
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ]);
    }
}