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

    public function test_debt_add(): void
    {
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

    public function test_debt_add_to_user(): void
    {
        $this->withoutMiddleware();
        $user = User::find(28);

        $response = $this->actingAs($user)->post("/debt", [
            "user_id" => 28,
            "username" => "WalletAdmin",
            "name" => "Admin Wallet",
            "debtAmount" => 11500,
            "debtToFrom" => "debtFrom",
            "description" => "Gyros",
            "debtDate" => "2026-04-04",
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas("tartozasok", [
            "user_id" => 28,
            "partner_user_id" => 38,
            "partner_nev" => "Admin Wallet",
            "osszeg" => 11500,
            "tipus" => "0",
            "leiras" => "Gyros",
            "datum" => "2026-04-04",
            "ki_irta" => 28
        ]);

        $this->assertDatabaseHas("tartozasok", [
            "user_id" => 38,
            "partner_user_id" => 28,
            "partner_nev" => "Csiha Márkóka",
            "osszeg" => 11500,
            "tipus" => "1",
            "leiras" => "Gyros",
            "datum" => "2026-04-04",
            "ki_irta" => 28
        ]);
    }
}
