<?php

namespace Tests\Feature;

use App\Enums\StatusProfil;
use App\Models\Administrateur;
use App\Models\Profil;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProfilTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('images');
    }

    /** @test */
    public function it_can_create_a_profil_when_authenticated()
    {
        // Crée un administrateur authentifié
        $admin = Administrateur::factory()->create();
        $this->actingAs($admin);

        // Crée un faux fichier image
        $fakeImage = \Illuminate\Http\UploadedFile::fake()->image('photo.jpg');

        // Simule l'appel à l'API pour créer un profil
        $response = $this->postJson('/api/profils', [
            'nom' => 'Doe',
            'prenom' => 'John',
            'image' => $fakeImage,
            'status' => 'actif',
        ]);

        // Assert que la requête est bien passée et que le profil est créé
        $response->assertStatus(201);
        $this->assertDatabaseHas('profils', [
            'nom' => 'Doe',
            'prenom' => 'John',
            'status' => 'actif',
        ]);
    }

    /** @test */
    public function it_cannot_create_a_profil_without_authentication()
    {
        $response = $this->postJson('/api/profils', [
            'nom' => 'Doe',
            'prenom' => 'John',
            'image' => UploadedFile::fake()->image('avatar.jpg'),
            'status' => StatusProfil::ATTENTE->value,
        ]);

        $response->assertStatus(401); // Unauthorized
    }

    /** @test */
    public function it_can_update_a_profil_when_authenticated()
    {
        Sanctum::actingAs(Administrateur::factory()->create());

        $profil = Profil::factory()->create([
            'nom' => 'Doe',
            'prenom' => 'John',
            'status' => StatusProfil::ATTENTE->value,
        ]);

        $response = $this->putJson("/api/profils/{$profil->id}", [
            'nom' => 'Smith',
            'status' => StatusProfil::ACTIF->value,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('profils', ['nom' => 'Smith', 'status' => StatusProfil::ACTIF->value]);
    }

    /** @test */
    public function it_can_delete_a_profil_when_authenticated()
    {
        Sanctum::actingAs(Administrateur::factory()->create());

        $profil = Profil::factory()->create();

        $response = $this->deleteJson("/api/profils/{$profil->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('profils', ['id' => $profil->id]);
    }

    /** @test */
    public function it_can_get_all_active_profils_publicly()
    {
        Profil::factory()->create([
            'nom' => 'Active',
            'status' => StatusProfil::ACTIF->value,
        ]);

        Profil::factory()->create([
            'nom' => 'Inactive',
            'status' => StatusProfil::INACTIF->value,
        ]);

        $response = $this->getJson('/api/profils');

        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data'); // Only the active profil should be returned
        $response->assertJsonMissing(['status']); // Ensure 'status' is not returned publicly
    }
}
