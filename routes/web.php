<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WMController;

Route::view('/', 'welcome');

Route::get("/regisztracio", [UserController::class, "Regisztracio"]);
Route::post("/regisztracio", [UserController::class, "RegisztracioBtn"]);

Route::get("/belepes", [UserController::class, "Belepes"]);
Route::post("/belepes", [UserController::class, "BelepesBtn"]);

Route::get("/fiokom", [UserController::class, "Fiokom"]);

Route::get("/kijelentkezes", [UserController::class, "Kijelentkezes"]);

Route::get("/main", [WMController::class, "Main"])->name('naptar');

Route::get('/mainmod/{szamla_id}', [WMController::class, 'MainMod']);
Route::post('/mainmod/{szamla_id}', [WMController::class, 'MainModBtn']);
Route::get('/mainexit/{szamla_id}', [WMController::class, 'MainDelete']);

Route::get("/goals", [WMController::class, "Goals"]);
Route::post("/goals", [WMController::class, "GoalsBtn"]);

Route::get('/goalsmod/{cel_id}', [WMController::class, 'GoalsMod']);
Route::post('/goalsmod/{cel_id}', [WMController::class, 'GoalsModBtn']);
Route::get('/goalsexit/{cel_id}', [WMController::class, 'GoalsDelete']);

Route::get("/add", [WMController::class, "Add"]);
Route::post("/add", [WMController::class, "AddBtn"]);

