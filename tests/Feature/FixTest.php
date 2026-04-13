<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\szamla;

class FixTest extends TestCase
{
    public function test_fix_page(): void
    {
        $user = User::find(28);

        $response = $this->actingAs($user)->get('/fix');

        $response->assertStatus(200);
    }

    public function test_fix_add(): void
    {
        $this->withoutMiddleware();
        $user = User::find(28);

        $response = $this->actingAs($user)->post('/fix', [
            'osszeg' => 5990,
            'tipus' => 'havi',
            'letrehozas' => "2026-03-27",
            'fizetve' => '2026-03-27',
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('szamla', [
            'user_id' => 31,
            'szamla_id' => 139,
            'osszeg' => 5990,
            'tipus' => 'havi',
            'letrehozas' => "2026-03-27",
            'fizetve' => '2026-03-27',
        ]);

        $szamla = szamla::where('user_id', 28)
            ->where('osszeg', 5990)
            ->first();

        $this->assertNotNull($szamla);

        $this->assertDatabaseHas('fix', [
            'szamla_id' => $szamla->szamla_id,
            'tipus' => 'havi',
            'osszeg' => 5990,
            'fizetve' => '2026-04-01',
        ]);
    }

    public function test_fix_add_incorrect_amount(): void
    {
        $this->withoutMiddleware();
        $user = User::find(28);

        $response = $this->actingAs($user)->post('/fix', [
            'user_id' => 31,
            'szamla_id' => 139,
            'osszeg' => 'asd',
            'tipus' => 'havi',
            'letrehozas' => "2026-03-27",
            'fizetve' => '2026-03-27',
        ]);

        $response->assertSessionHasErrors('amount');
    }

    public function test_fix_add_without_type(): void
    {
        $this->withoutMiddleware();
        $user = User::find(28);

        $response = $this->actingAs($user)->post('/fix', [
            'user_id' => 31,
            'szamla_id' => 139,
            'osszeg' => 5990,
            'tipus' => '',
            'letrehozas' => "2026-03-27",
            'fizetve' => '2026-03-27',
        ]);

        $response->assertSessionHasErrors('fixType');
    }

    public function test_fix_add_without_date(): void
    {
        $this->withoutMiddleware();
        $user = User::find(28);

        $response = $this->actingAs($user)->post('/fix', [
            'user_id' => 31,
            'szamla_id' => 139,
            'osszeg' => 5990,
            'tipus' => 'havi',
            'letrehozas' => '',
            'fizetve' => '',
        ]);

        $response->assertSessionHasErrors('date');
    }
}
