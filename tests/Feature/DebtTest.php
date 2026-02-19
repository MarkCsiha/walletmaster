<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\tartozasok;
use App\Models\User;

class DebtTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_debt_page(): void
    {
        $user = User::find(28);
        $response = $this->actingAs($user)->get('/debt');

        $response->assertStatus(200);
    }

    public function test_debt_add(): void {
        $this->withoutMiddleware();
        $user = User::find(28);

        $response = $this->actingAs($user)->post("/debt", [
            "user_id" => 28,
            "partner_user_id" => null,
            "name" => "Kovács János",
            "debtAmount" => 1000,
            "debtToFrom" => "debtTo",
            "description" => "Teszt tranzakció",
            "debtDate" => "2026-02-19",
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas("tartozasok", [
            "user_id" => 28,
            "partner_user_id" => null,
            "partner_nev" => "Kovács János",
            "osszeg" => 1000,
            "tipus" => 1,
            "leiras" => "Teszt tranzakció",
            "datum" => "2026-02-19",
        ]);
    }
}
