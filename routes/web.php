<?php

use App\Http\Controllers\DebtController;
use App\Http\Controllers\ResetPasswordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WMController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\SSEController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Laravel\Socialite\Socialite;


Route::view('/', 'welcome');

Route::get("/registration", [UserController::class, "Registration"]);
Route::post("/registration", [UserController::class, "RegistrationBtn"]);

Route::get("/login", [UserController::class, "Login"])->name('login');
Route::post("/login", [UserController::class, "LoginBtn"]);

//ha nem megy az email módosítás akkor rakd vissza a middleware auth verifiedot!
Route::get("/account", [UserController::class, "Account"])->middleware(["auth", "verified"]);

Route::get("/logout", [UserController::class, "Logout"]);

// Route::get("/main", [WMController::class, "Charts"]);
// Route::post('/main', [WMController::class, "SpendingChart"]);
Route::post('/main', [WMController::class, "Main"])->middleware(["auth", "verified"]);
Route::get('/main', [WMController::class, 'Main'])->middleware(["auth", "verified"]);
Route::post('/main', [WMController::class, 'Main'])->middleware(["auth", "verified"])->name('main.charts'); //name('naptar');
Route::get("/main", [WMController::class, "Main"])->middleware(["auth", "verified"])->name('naptar');

Route::get('/mainmod/{szamla_id}', [WMController::class, 'MainMod']);
Route::post('/mainmod/{szamla_id}', [WMController::class, 'MainModBtn']);
Route::get('/mainexit/{szamla_id}', [WMController::class, 'MainDelete']);

//Route::get("/account", [UserController::class, "Save"])->middleware(["auth", "verified"]);
Route::post("/account", [UserController::class, "SaveBtn"]);

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
Route::post('/reset-password', [ResetPasswordController::class, "PasswordReset"])->middleware('guest')->name('password.update');

Route::get('/debt', [DebtController::class, 'DebtShow'])->name('debt.show')->middleware(["auth", "verified"]);
Route::post('/debt', [DebtController::class, 'DebtAdd'])->middleware(["auth", "verified"]);


Route::get("/main", [WMController::class, "Main"])->name('naptar');
Route::get("/goals", [WMController::class, "Goals"]);
Route::post("/goals", [WMController::class, "GoalsBtn"]);

Route::get('/goalsmod/{cel_id}', [WMController::class, 'GoalsMod']);
Route::post('/goalsmod/{cel_id}', [WMController::class, 'GoalsModBtn']);
Route::get('/goalsexit/{cel_id}', [WMController::class, 'GoalsDelete']);

Route::get("/add", [WMController::class, "Add"]);
Route::post("/add", [WMController::class, "AddBtn"]);

//Tartozások email kiküldése
Route::get('/debts/{id}/decision', [DebtController::class, 'ShowDebtDetails'])->name('debts.decision');

//tartozás elfogadása
Route::post("/debts/{id}/accept", [DebtController::class, "AcceptDebt"])->name('debts.accept');

//tartozás visszautasítása
Route::post("/debts/{id}/reject", [DebtController::class, "RejectDebt"])->name("debts.reject");

//rendezve gomb a tartozásoknál
Route::post("/debt/{id}/done", [DebtController::class, "DebtDone"])->name("debts.done");

//exportálás
Route::get('/export', [WMController::class, "ExportExcel"])->name("export.download-excel");

Route::post("/import", [WMController::class, "ImportExcel"])->name("import");

Route::get('auth/google', [GoogleController::class, "RedirectGoogle"])->name('redirect.google');

Route::get('auth/google/callback', [GoogleController::class, "GoogleCallback"])->name('callback.google');

Route::delete('/user/{id}', [UserController::class, 'AccountDelete'])
    ->name('user.destroy')
    ->middleware(['auth']);
