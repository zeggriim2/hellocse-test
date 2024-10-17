<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\Administrateur;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_register_an_admin()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('administrateurs', ['email' => 'admin@example.com']);
    }

    /** @test */
    public function it_can_login_an_admin()
    {
        $admin = Administrateur::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'admin@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200);
        $this->assertArrayHasKey('token', $response->json());
    }
}
