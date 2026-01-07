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

Route::get("/main", [WMController::class, "Main"]);

Route::get("/fiokom", [UserController::class, "Mentes"]);
Route::post("/fiokom", [UserController::class, "MentesBtn"]);
