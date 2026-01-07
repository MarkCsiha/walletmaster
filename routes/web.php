<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WMController;

Route::view('/', 'welcome');

Route::get("/registration", [UserController::class, "Registration"]);
Route::post("/registration", [UserController::class, "RegistrationBtn"]);

Route::get("/login", [UserController::class, "Login"]);
Route::post("/login", [UserController::class, "LoginBtn"]);

Route::get("/account", [UserController::class, "Account"]);

Route::get("/logout", [UserController::class, "Logout"]);

Route::get("/main", [WMController::class, "Main"]);

Route::get("/account", [UserController::class, "Save"]);
Route::post("/account", [UserController::class, "SaveBtn"]);
