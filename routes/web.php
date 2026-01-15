<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WMController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;


Route::view('/', 'welcome');

Route::get("/registration", [UserController::class, "Registration"]);
Route::post("/registration", [UserController::class, "RegistrationBtn"]);

Route::get("/login", [UserController::class, "Login"]);
Route::post("/login", [UserController::class, "LoginBtn"]);

Route::get("/account", [UserController::class, "Account"]);

Route::get("/logout", [UserController::class, "Logout"]);

// Route::get("/main", [WMController::class, "Charts"]);
// Route::post('/main', [WMController::class, "SpendingChart"]);
Route::post('/main', [WMController::class, "Charts"]);
Route::get('/main', [WMController::class, 'Charts']);
Route::post('/main', [WMController::class, 'Charts'])->name('main.charts');


Route::get("/account", [UserController::class, "Save"]);
Route::post("/account", [UserController::class, "SaveBtn"]);

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
