<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    //https://www.youtube.com/watch?v=rsxKmrtlPtc&t=665s
    //https://laravel.com/docs/12.x/socialite
    public function RedirectGoogle(Request $req) {
        return Socialite::driver('google')->redirect();

    }

    public function GoogleCallback(Request $req) {
        $user = Socialite::driver('google')->user();

        $findUser = User::where('email', $user->getEmail())
                        ->first();

        if ($findUser) {
            if (empty($findUser->google_id)) {
                $findUser->google_id = $user->getId();
                $findUser->save();
            }
            Auth::login($findUser);
            return redirect('main')->with(["success" => "Sikeres bejelentkezés!"]);
        }
        else {
            $data = new User;
            $data->vez_nev = null;
            $data->ker_nev = null;
            $data->email = $user->getEmail();
            $data->felhasznalonev = null;
            $data->telszam = null;
            $data->password = bcrypt(Str::random(32));
            $data->email_verified_at = now();
            $data->save();

            Auth::login($data);
            return redirect('account')->with(["success" => "Sikeres bejelentkezés, kérjük adja meg a hiányzó adatait a folytatáshoz!"]);
        }
    }
}
