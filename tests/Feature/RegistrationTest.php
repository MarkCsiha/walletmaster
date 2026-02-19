<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\User;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as MiddlewareVerifyCsrfToken;

class RegistrationTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use DatabaseTransactions;
    public function test_registration_page(): void
    {
        $response = $this->get('/registration');

        $response->assertStatus(200);
    }

    public function test_user_registration_datavalid(): void {
        $this->withoutMiddleware();
        $response = $this->post('/registration', [
            "vez_nev" => "Teszt",
            "ker_nev" => "Elo",
            "felhasznalonev" =>"Tesztelo2026",
            "telszam" => "06703246587",
            "email" => "tesztf27@gmail.com"
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('users', [
            "vez_nev" => "Teszt",
            "ker_nev" => "Elo",
            "felhasznalonev" =>"Tesztelo2026",
            "telszam" => "06703246587",
            "email" => "tesztf27@gmail.com"
        ]);
    }

    public function test_login_page(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_user_login_datavalid(): void {
        $this->withoutMiddleware();
        $response = $this->post('/login', [
            "vez_nev" => "Teszt",
            "ker_nev" => "Elo",
            "felhasznalonev" =>"Tesztelo2026",
            "telszam" => "06703246587",
            "email" => "tesztf27@gmail.com"
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('users', [
            "vez_nev" => "Teszt",
            "ker_nev" => "Elo",
            "felhasznalonev" =>"Tesztelo2026",
            "telszam" => "06703246587",
            "email" => "tesztf27@gmail.com"
        ]);
    }


}
