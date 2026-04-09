<?php

use App\Http\Controllers\DebtController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\TwoFactorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WMController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::get('/registration', [UserController::class, 'Registration'])->middleware('guest');
Route::post('/registration', [UserController::class, 'RegistrationBtn']);

Route::get('/login', [UserController::class, 'Login'])->name('login')->middleware('guest');
Route::post('/login', [UserController::class, 'LoginBtn']);

Route::get('/twofactor', [TwoFactorController::class, 'TwoFactorShow']);
Route::post('/twofactor', [TwoFactorController::class, 'TwoFactorVerify']);

Route::get('/account', [UserController::class, 'Account'])->middleware(['auth', 'verified']);
Route::post('/account', [UserController::class, 'SaveBtn'])->middleware(['auth', 'verified']);

Route::get('/logout', [UserController::class, 'Logout']);

Route::get('/main', [WMController::class, 'Main'])->middleware(['auth', 'verified'])->name('naptar');
Route::post('/main', [WMController::class, 'Main'])->middleware(['auth', 'verified'])->name('main.charts');

Route::get('/mainmod/{szamla_id}', [WMController::class, 'MainMod'])->middleware(['auth', 'verified']);
Route::post('/mainmod/{szamla_id}', [WMController::class, 'MainModBtn'])->middleware(['auth', 'verified']);
Route::get('/mainexit/{szamla_id}', [WMController::class, 'MainDelete'])->middleware(['auth', 'verified']);

Route::get('/auth/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/main')->with(['success' => 'Sikeres email cím megerősítés!']);
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with(['success' => 'Megerősítő email sikeresen elküldve!']);
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::post('/auth/verify', [UserController::class, 'EmailChanged'])
    ->middleware(['auth', 'throttle:6,1']);

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');

Route::post('/forgot-password', [ResetPasswordController::class, 'SendLink'])
    ->middleware('guest')
    ->name('password.email');

Route::get('/reset-password/{token}', function (string $token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

//frissíti a jelszót
Route::post('/reset-password', [ResetPasswordController::class, "PasswordReset"])->middleware('guest');

Route::get('/debt', [DebtController::class, 'DebtShow'])->middleware(['auth', 'verified']);
Route::post('/debt', [DebtController::class, 'DebtAdd'])->middleware(['auth', 'verified']);

Route::get('/debts/{id}/decision', [DebtController::class, 'ShowDebtDetails'])
    ->name('debts.decision')
    ->middleware(['auth', 'verified', 'signed']);

Route::post('/debts/{id}/accept', [DebtController::class, 'AcceptDebt'])
    ->name('debts.accept')
    ->middleware(['auth', 'verified']);

Route::post('/debts/{id}/reject', [DebtController::class, 'RejectDebt'])
    ->name('debts.reject')
    ->middleware(['auth', 'verified']);

Route::post('/debts/{id}/done', [DebtController::class, 'DebtDone'])
    ->name('debts.done')
    ->middleware(['auth', 'verified']);

//Tartozások email kiküldése
Route::get('/debts/{id}/decision', [DebtController::class, 'ShowDebtDetails'])->name('debts.decision')->middleware(["auth", "verified", "signed"]);

//tartozás elfogadása
Route::post("/debts/{id}/accept", [DebtController::class, "AcceptDebt"])->middleware(["auth", "verified"]);

//tartozás visszautasítása
Route::post("/debts/{id}/reject", [DebtController::class, "RejectDebt"])->middleware(["auth", "verified"]);

//rendezve gomb a tartozásoknál
Route::post("/debts/{id}/done", [DebtController::class, "DebtDone"])->middleware(["auth", "verified"]);

Route::get('/debts/pending', [DebtController::class, 'ShowPendingDebts'])->middleware(['auth', 'verified']);

Route::get('/export', [WMController::class, 'ExportExcel'])->middleware(['auth', 'verified']);
Route::post('/import', [WMController::class, 'ImportExcel'])->middleware(['auth', 'verified'])->name('import');

Route::post("/import", [WMController::class, "ImportExcel"])->middleware(["auth", "verified"]);

Route::get('/auth/google', [GoogleController::class, "RedirectGoogle"]);

Route::get('/auth/google/callback', [GoogleController::class, "GoogleCallback"])->name('callback.google');

Route::delete('/user/{id}', [UserController::class, 'AccountDelete'])->name('user.destroy')->middleware(['auth', 'verified']);

Route::get('/user/{id}', [UserController::class, 'UserRemovalCancel'])
    ->name('userremoval.cancel')
    ->middleware(['auth', 'verified']);

Route::get('/review', [ReviewController::class, 'ShowReview'])->middleware(['auth', 'verified']);
Route::post('/review', [ReviewController::class, 'ReviewBtn'])->middleware(['auth', 'verified']);

Route::get('/limit', [WMController::class, 'MyData']);
Route::post('/limit', [WMController::class, 'MyDataSet']);
Route::get('/limitmore/{fix_id}', [WMController::class, 'LimitMore'])->middleware(['auth', 'verified']);
