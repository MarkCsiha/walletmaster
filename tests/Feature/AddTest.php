<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddTest extends TestCase
{
    public function test_add_page(): void
    {
        $user = User::find(28);

        $response = $this->actingAs($user)->get('/add');

        $response->assertStatus(200);
    }

    public function test_add_transaction(): void
    {
        $this->withoutMiddleware();
        $user = User::find(28);

        $response = $this->actingAs($user)->post('/add', [
            'osszeg' => 12500,
            'honnan' => 'OTP',
            'leiras' => 'Teszt kiadás',
            'datum' => '2026-04-12',
            'tipus' => '0',
            'kategoria' => 'Élelmiszer',
            'fix' => 'nem',
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('szamla', [
            'user_id' => 28,
            'osszeg' => 12500,
            'honnan' => 'OTP',
            'leiras' => 'Teszt kiadás',
            'datum' => '2026-04-12',
            'tipus' => 0,
            'kategoria_nev' => 'Élelmiszer',
            'fix' => 'nem',
            'aktiv' => 1,
        ]);
    }

    public function test_add_income_transaction(): void
    {
        $this->withoutMiddleware();
        $user = User::find(28);

        $response = $this->actingAs($user)->post('/add', [
            'osszeg' => 12500,
            'honnan' => 'OTP',
            'leiras' => 'Teszt kiadás',
            'datum' => '2026-04-12',
            'tipus' => '1',
            'kategoria' => 'Fizetés',
            'fix' => 'nem',
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('szamla', [
            'user_id' => 28,
            'osszeg' => 250000,
            'honnan' => 'Fizetés',
            'leiras' => 'Havi fizetés',
            'datum' => '2026-04-10',
            'tipus' => 1,
            'kategoria_nev' => 'Fizetés',
            'fix' => 'nem',
            'aktiv' => 1,
        ]);
    }

    public function test_add_transaction_incorrect_amount(): void
    {
        $this->withoutMiddleware();
        $user = User::find(28);

        $response = $this->actingAs($user)->post('/add', [
            'osszeg' => 'asd',
            'honnan' => 'OTP',
            'leiras' => 'Teszt kiadás',
            'datum' => '2026-04-12',
            'tipus' => '0',
            'kategoria' => 'Élelmiszer',
            'fix' => 'nem',
        ]);

        $response->assertSessionHasErrors('osszeg');
    }

    public function test_add_transaction_without_amount(): void
    {
        $this->withoutMiddleware();
        $user = User::find(28);

        $response = $this->actingAs($user)->post('/add', [
            'osszeg' => '',
            'honnan' => 'OTP',
            'leiras' => 'Teszt kiadás',
            'datum' => '2026-04-12',
            'tipus' => '0',
            'kategoria' => 'Élelmiszer',
            'fix' => 'nem',
        ]);

        $response->assertSessionHasErrors('osszeg');
    }

    public function test_add_transaction_incorrect_date(): void
    {
        $this->withoutMiddleware();
        $user = User::find(28);

        $response = $this->actingAs($user)->post('/add', [
            'osszeg' => 12500,
            'honnan' => 'OTP',
            'leiras' => 'Teszt kiadás',
            'datum' => '2030-04-12',
            'tipus' => '0',
            'kategoria' => 'Élelmiszer',
            'fix' => 'nem',
        ]);

        $response->assertSessionHasErrors('date');
    }
}
