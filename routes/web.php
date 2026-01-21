<?php

use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WMController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

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
Route::post('/main', [WMController::class, "Charts"]);
Route::get('/main', [WMController::class, 'Charts'])->middleware(["auth", "verified"]);
Route::post('/main', [WMController::class, 'Charts'])->name('main.charts');


//Route::get("/account", [UserController::class, "Save"])->middleware(["auth", "verified"]);
Route::post("/account", [UserController::class, "SaveBtn"]);

//https://laravel.com/docs/12.x/verification
//átirányít a hitelesítés oldalra regisztráció után
Route::get('/auth/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');

//nem megy, Ati papa segít majd
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
Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);

    //jelszó visszaállítás linket küld a felhasználó email címére
    //auth.php-ból tudja a Laravel alapból, hogy kinek kell küldeni linket
    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status === Password::ResetLinkSent
        ? back()->with(['status' => __($status)])
        : back()->withErrors(['email' => __($status)]);
})->middleware('guest')->name('password.email');

//ez a Route az a link, amit akkor kap a Laravel miután a felhasználó rákattintott az emailben kapott reset linkre
Route::get('/reset-password/{token}', function (string $token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function (User $user, string $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));

            $user->save();

            event(new PasswordReset($user));
        }
    );

    return $status === Password::PasswordReset
        ? redirect()->route('login')->with('status', __($status))
        : back()->withErrors(['email' => [__($status)]]);
})->middleware('guest')->name('password.update');
