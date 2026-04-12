<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GoalsTest extends TestCase
{
    public function test_goals_page(): void
    {
        $user = User::find(28);

        $response = $this->actingAs($user)->get('/goals');

        $response->assertStatus(200);
    }

    public function test_goal_add(): void
    {
        $this->withoutMiddleware();
        $user = User::find(28);

        $response = $this->actingAs($user)->post('/goals', [
            'cel_nev' => 'Laptop',
            'cel_osszeg' => 350000,
            'budzse' => 30000,
            'datum' => '2026-08-31',
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('celok', [
            'user_id' => 28,
            'cel_nev' => 'Laptop',
            'cel_osszeg' => 350000,
            'budzse' => 30000,
            'hatarido' => '2026-08-31',
            'statusz' => 'aktív',
        ]);
    }

    public function test_goal_add_incorrect_name(): void
    {
        $this->withoutMiddleware();
        $user = User::find(28);

        $response = $this->actingAs($user)->post('/goals', [
            'cel_nev' => '',
            'cel_osszeg' => 350000,
            'budzse' => 30000,
            'datum' => '2026-08-31',
        ]);

        $response->assertSessionHasErrors('cel_nev');

        $this->assertDatabaseMissing('celok', [
            'user_id' => 28,
            'cel_osszeg' => 350000,
        ]);
    }

    public function test_goal_add_incorrect_amount(): void
    {
        $this->withoutMiddleware();
        $user = User::find(28);

        $response = $this->actingAs($user)->post('/goals', [
            'cel_nev' => 'Laptop',
            'cel_osszeg' => 'asd',
            'budzse' => 30000,
            'datum' => '2026-08-31',
        ]);

        $response->assertSessionHasErrors('cel_osszeg');
    }

    public function test_goal_status_update(): void
    {
        $this->withoutMiddleware();
        $user = User::find(28);

        $this->actingAs($user)->post('/goals', [
            'cel_nev' => 'Laptop',
            'cel_osszeg' => 350000,
            'budzse' => 30000,
            'datum' => '2026-08-31',
        ]);

        $goal = \App\Models\celok::where('user_id', 28)
            ->where('cel_nev', 'Laptop')
            ->first();

        $response = $this->actingAs($user)->post('/goals/update-status', [
            'goal_id' => $goal->cel_id,
            'status' => 'teljesítve',
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('celok', [
            'cel_id' => $goal->cel_id,
            'statusz' => 'teljesítve',
        ]);
    }

    public function test_goal_delete(): void
    {
        $this->withoutMiddleware();
        $user = User::find(28);

        $this->actingAs($user)->post('/goals', [
            'cel_nev' => 'Laptop',
            'ce_osszeg' => 350000,
            'budzse' => 30000,
            'datum' => '2026-08-31',
        ]);

        $goal = \App\Models\celok::where('user_id', 28)
            ->where('cel_nev', 'Új laptop')
            ->first();

        $response = $this->actingAs($user)->post('/goals/delete', [
            'goal_id' => $goal->cel_id,
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseMissing('celok', [
            'cel_id' => $goal->cel_id,
        ]);
    }
}
