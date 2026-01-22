<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

//15 percenként törli a password_reset_token felesleges adatait
Schedule::command('auth:clear-resets')->everyFifteenMinutes();


