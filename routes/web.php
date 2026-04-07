<?php

use App\Http\Controllers\DebtController;
use App\Http\Controllers\ResetPasswordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WMController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\SSEController;
use App\Http\Controllers\TwoFactorController;
use App\Http\Controllers\ReviewController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Laravel\Socialite\Socialite;


Route::view('/', 'welcome');

Route::get("/registration", [UserController::class, "Registration"])->middleware("guest");
Route::post("/registration", [UserController::class, "RegistrationBtn"]);

Route::get("/login", [UserController::class, "Login"])->name("login")->middleware("guest");
Route::post("/login", [UserController::class, "LoginBtn"]);
Route::get("/twofactor", [TwoFactorController::class, "TwoFactorShow"]);
Route::post("/twofactor", [TwoFactorController::class, "TwoFactorVerify"]);

//ha nem megy az email módosítás akkor rakd vissza a middleware auth verifiedot!
Route::get("/account", [UserController::class, "Account"])->middleware(["auth", "verified"]);

Route::get("/logout", [UserController::class, "Logout"]);

// Route::get("/main", [WMController::class, "Charts"]);
// Route::post('/main', [WMController::class, "SpendingChart"]);
// Route::post('/main', [WMController::class, "Main"])->middleware(["auth", "verified"]);
// Route::get('/main', [WMController::class, 'Main'])->middleware(["auth", "verified"]);
Route::post('/main', [WMController::class, 'Main'])->middleware(["auth", "verified"])->name('main.charts'); //name('naptar');
Route::get("/main", [WMController::class, "Main"])->middleware(["auth", "verified"])->name('naptar');

Route::get('/mainmod/{szamla_id}', [WMController::class, 'MainMod'])->middleware(["auth", "verified"]);
Route::post('/mainmod/{szamla_id}', [WMController::class, 'MainModBtn'])->middleware(["auth", "verified"]);
Route::get('/mainexit/{szamla_id}', [WMController::class, 'MainDelete'])->middleware(["auth", "verified"]);

//Route::get("/account", [UserController::class, "Save"])->middleware(["auth", "verified"]);
Route::post("/account", [UserController::class, "SaveBtn"])->middleware(["auth", "verified"]);

//https://laravel.com/docs/12.x/verification
//átirányít a hitelesítés oldalra regisztráció után
Route::get('/auth/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/main')->with(['success' => "Sikeres email cím megerősítés!"]);
})->middleware(['auth', 'signed'])->name('verification.verify');


Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Hitelesítő kód elküldve!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
//Új email cím bekérése esetén automatikusan küld egy új megerősítő emailt. Ez akkor jó, ha a felhasználó rosszul írta be az email címét.
Route::post('/auth/verify', [UserController::class, 'EmailChanged'])->middleware(['auth', 'throttle:6,1'])->name('verification.send');

//jelszó kérés form
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');

//kezeli az új jelszó kérés form adatait -> ehhez kell a ../../Facade/Password
Route::post('/forgot-password', [ResetPasswordController::class, "SendLink"])->middleware('guest')->name('password.email');

//ez a Route az a link, amit akkor kap a Laravel miután a felhasználó rákattintott az emailben kapott reset linkre
Route::get('/reset-password/{token}', function (string $token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

//frissíti a jelszót
Route::post('/reset-password', [ResetPasswordController::class, "PasswordReset"])->middleware('guest');

Route::get('/debt', [DebtController::class, 'DebtShow'])->middleware(["auth", "verified"]);
Route::post('/debt', [DebtController::class, 'DebtAdd'])->middleware(["auth", "verified"]);


Route::get("/main", [WMController::class, "Main"])->name('naptar')->middleware(["auth", "verified"]);
Route::get("/goals", [WMController::class, "Goals"])->middleware(["auth", "verified"]);
Route::post("/goals", [WMController::class, "GoalsBtn"])->middleware(["auth", "verified"]);

Route::get('/goalsmod/{cel_id}', [WMController::class, 'GoalsMod'])->middleware(["auth", "verified"]);
Route::post('/goalsmod/{cel_id}', [WMController::class, 'GoalsModBtn'])->middleware(["auth", "verified"]);
Route::get('/goalsexit/{cel_id}', [WMController::class, 'GoalsDelete'])->middleware(["auth", "verified"]);

Route::get("/add", [WMController::class, "Add"])->middleware(["auth", "verified"]);
Route::post("/add", [WMController::class, "AddBtn"])->middleware(["auth", "verified"]);

//Tartozások email kiküldése
Route::get('/debts/{id}/decision', [DebtController::class, 'ShowDebtDetails'])->name('debts.decision')->middleware(["auth", "verified", "signed"]);

//tartozás elfogadása
Route::post("/debts/{id}/accept", [DebtController::class, "AcceptDebt"])->middleware(["auth", "verified"]);

//tartozás visszautasítása
Route::post("/debts/{id}/reject", [DebtController::class, "RejectDebt"])->middleware(["auth", "verified"]);

//rendezve gomb a tartozásoknál
Route::post("/debts/{id}/done", [DebtController::class, "DebtDone"])->middleware(["auth", "verified"]);

Route::get('/debts/pending', [DebtController::class, 'ShowPendingDebts'])->middleware(['auth', 'verified']);

//exportálás
Route::get('/export', [WMController::class, "ExportExcel"])->middleware(["auth", "verified"]);

Route::post("/import", [WMController::class, "ImportExcel"])->middleware(["auth", "verified"]);

Route::get('/auth/google', [GoogleController::class, "RedirectGoogle"]);

Route::get('/auth/google/callback', [GoogleController::class, "GoogleCallback"])->name('callback.google');

Route::delete('/user/{id}', [UserController::class, 'AccountDelete'])->name('user.destroy')->middleware(['auth', 'verified']);

Route::get('/user/{id}', [UserController::class, "UserRemovalCancel"])->name("userremoval.cancel")->middleware(["auth", "verified"]);
// Route::get('/user/{id}', [UserController::class, "UserRemovalCancel"]);

Route::get("/review", [ReviewController::class, "ShowReview"])->middleware(["auth", "verified"]);
Route::post("/review", [ReviewController::class, "ReviewBtn"])->middleware(["auth", "verified"]);
