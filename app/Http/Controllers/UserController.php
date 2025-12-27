<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function Regisztracio(){
        if(Auth::check()){
            return redirect("/main");
        }
        else{
            return view("regisztracio");
        }
    }

    public function RegisztracioBtn(Request $req){
        $req->validate([
            'vez_nev'               => 'required|max:30',
            'ker_nev'               => 'required|max:30',
            'felhasznalonev'        => 'required|min:3|max:30|unique:users,felhasznalonev|regex:/^[a-zA-Z0-9._]+$/',
            'email'                 => 'required|email|unique:users,email|email:rfc,dns',
            'telszam'               => 'required|min:11|max:13|unique:users,telszam',
            'password'              => ['required','confirmed', Password::min(8)
                                        ->letters()
                                        ->numbers()
                                        ->mixedCase()
                                        ->symbols()
                                        ->uncompromised()],
                                        // Tesztjelszó: #Palmafa123
            'password_confirmation' => 'required'
        ],[
            '*.required'            => 'Kötelező kitölteni!',
            'vez_nev.max'           => 'Maximum 30 karakter lehet!',
            'ker_nev.max'           => 'Maximum 30 karakter lehet!',
            'felhasznalonev.max'    => "Maximum 30 karakter lehet!",
            'felhasznalonev.unique' => "Ez a felhasználónév már létezik az adatbázisban.",
            "email.unique"          => "Ez az email cím már szerepel az adatbázisban.",
            'email.regex'           => "Az email címnek tartalmaznia kell",
            'email.email'           => "Érvényes email címet adjon meg, mely megfelel az email cím formátumnak, például: kissbela@walletmaster.hu.",
            '*.email'               => 'Érvényes e-mail címet adj meg!',
            // 'telszam.regex'         => 'A telefonszámnak meg kell felelnie a telefonszám formátumnak, például: +36701234567.',
            'telszam.min'           => "A telefonszámnak legalább 11 karakter hosszúnak kell lennie!",
            'telszam.max'           => "A telefonszám maximum 13 karakter hosszú lehet!",
            'telszam.unique'        => "Ez a telefonszám foglalt.",
            '*.confirmed'           => 'A két jelszó nem egyezik meg!',
            'password.min'          => 'A jelszónak legalább 8 karakternek kell lenni!',
            'password.letters'      => 'A jelszónak kell betűt tartalmaznia',
            'password.numbers'      => 'A jelszónak legalább egy számot kell tartalmaznia!',
            'password.mixed'        => 'A jelszónak kis- és nagybetűt is kell tartalmaznia!',
            'password.symbols'      => 'A jelszónak legalább egy speciális karakter kell tartalmaznia!',
            'password.uncompromised'=> 'Ez a jelszó már szerepelt adatvédelmi incidensben, ezért nem biztonságos!'
        ]);

        $data                   = new User;
        $data->vez_nev          = $req->vez_nev;
        $data->ker_nev          = $req->ker_nev;
        $data->felhasznalonev   = $req->felhasznalonev;
        $data->email            = $req->email;
        $data->telszam          = $req->telszam;
        $data->password    = $req->password;

        $data->Save();
        return redirect('/main')->with([
            'siker' => 'Sikeresen regisztráltál, üdvözlünk a WalletMaster oldalán '.$req->ker_nev.' '.$req->vez_nev.'!'
        ]);
    }

    public function Belepes(){
        if(Auth::check()){
            return redirect("/main");
        }
        else{
            return view("belepes");
        }
    }

    public function BelepesBtn(Request $req)
    {
        $req->validate([
            "email"     => "required",
            "password"  => "required"
        ]);

        if(Auth::attempt(['email' => $req->email, 'password' => $req->password])){
            return redirect("/main")->with([
                "siker" => "Sikeresen belépett!"
            ]);
        }
        else{
            return redirect("/belepes")->with([
                "kudarc"    => "Az email cím, jelszó páros nem egyezik, kérjük próbálja meg újra!"
            ]);
        }
    }

     public function Fiokom() {
        if (Auth::check()) {
            return view('fiokom');
        }
        else {
            return redirect("/belepes");
        }
    }

    public function Kijelentkezes() {
        Auth::logout();
        return redirect('/')->with([
            "siker"     => "Sikeres kijelentkezés!"
        ]);
    }
}



#walletmaster@gmail.com
#Palmafa123
