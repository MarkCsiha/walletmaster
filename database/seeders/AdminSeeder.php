<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

//https://laravel.com/docs/12.x/seeding
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            "vez_nev" => "Admin",
            "ker_nev" => "Mark",
            "email" => "walletmasteradmin1@gmail.com",
            "telszam" => "06701659687",
            "password" => Hash::make("AdminUser123!"),
            "remember_token" => null,
            "regisztralt" => now(),
            "felhasznalonev" => "AdminMark",
            "email_verified_at" => now(),
            "admin" => "1"
        ]);
    }
}
