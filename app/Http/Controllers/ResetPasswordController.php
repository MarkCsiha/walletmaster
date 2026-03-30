<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use App\Models\User;
//alias kellett neki mert összezavarodott a Facades Password-el
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\Support\Facades\Auth;


class ResetPasswordController extends Controller
{
    public function SendLink(Request $req) {
      $req->validate([
        'email' => 'required|email'
        ], [
        "required" => "Adja meg az email címet!",
        "email" => "Az email címnek meg kell felelnie a megfelelő formátumnak, pl.: walletmaster00@gmail.com!"
      ]);

        //jelszó visszaállítás linket küld a felhasználó email címére
        //auth.php-ból tudja a Laravel alapból, hogy kinek kell küldeni linket
        $status = Password::sendResetLink(
            $req->only('email')
        );

            if ($status == Password::ResetLinkSent) {
                return back()->with(["success" => "Sikeres új jelszó igénylés!"]);
            } else {
                return back()->with([
                    "unsuccessful" => "Sikertelen jelszóigénylés, kérjük próbálja újra."
                ]);
            }
    }
    public function PasswordReset(Request $req) {
    $req->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => ['required','confirmed', PasswordRule::min(8)
                                                            ->letters()
                                                            ->numbers()
                                                            ->mixedCase()
                                                            ->symbols()
                                                            ->uncompromised()],
    ], [
        'password.min'          => 'A jelszónak legalább 8 karakternek kell lennie!',
        'password.letters'      => 'A jelszónak betűt kell tartalmaznia!',
        'password.numbers'      => 'A jelszónak legalább egy számot kell tartalmaznia!',
        'password.mixed'        => 'A jelszónak kis- és nagybetűt is kell tartalmaznia!',
        'password.symbols'      => 'A jelszónak legalább egy speciális karaktert kell tartalmaznia!',
        'password.uncompromised'=> 'Ez a jelszó már szerepelt adatvédelmi incidensben, ezért nem biztonságos!'
    ]);

    $status = Password::reset(
        $req->only('email', 'password', 'password_confirmation', 'token'),
        function (User $user, string $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));

            $user->save();

            event(new PasswordReset($user));
        }
    );

        if($status == Password::PasswordReset) {
            return redirect('login')->with(['success' => "Sikeresen megváltoztatta jelszavát!"]);
        }
        else {
            return redirect('forgot-password')->with(['unsuccessful' => "Sikertelen jelszómódosítás."]);
        }
    }
}
