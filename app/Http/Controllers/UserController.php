<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;



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
            //tömbben kell, különben összezavarodik néha a controller, összeolvad a regexszel minden
            'telszam'               => ['required', 'unique:users,telszam', 'regex:/^(?:\+36|06)(20|30|50|70)\d{3}\d{4}$/'],
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
            'felhasznalonev.unique' => "Ez a felhasználónév foglalt.",
            "email.unique"          => "Ez az email cím foglalt.",
            'email.regex'           => "Az email címnek tartalmaznia kell",
            'email.email'           => "Érvényes email címet adjon meg, mely megfelel az email cím formátumnak, például: kissbela@walletmaster.hu.",
            '*.email'               => 'Érvényes e-mail címet adjon meg!',
            'telszam.regex'         => 'A telefonszámnak meg kell felelnie a telefonszám formátumnak, például: +36701234567.',
            // 'telszam.min'           => "A telefonszámnak legalább 11 karakter hosszúnak kell lennie!",
            // 'telszam.max'           => "A telefonszám maximum 13 karakter hosszú lehet!",
            'telszam.unique'        => "Ez a telefonszám foglalt.",
            '*.confirmed'           => 'A két jelszó nem egyezik meg!',
            'password.min'          => 'A jelszónak legalább 8 karakternek kell lennie!',
            'password.letters'      => 'A jelszónak betűt kell tartalmaznia!',
            'password.numbers'      => 'A jelszónak legalább egy számot kell tartalmaznia!',
            'password.mixed'        => 'A jelszónak kis- és nagybetűt is kell tartalmaznia!',
            'password.symbols'      => 'A jelszónak legalább egy speciális karaktert kell tartalmaznia!',
            'password.uncompromised'=> 'Ez a jelszó már szerepelt adatvédelmi incidensben, ezért nem biztonságos!'
        ]);

        $data                   = new User;
        $data->vez_nev          = $req->vez_nev;
        $data->ker_nev          = $req->ker_nev;
        $data->felhasznalonev   = $req->felhasznalonev;
        $data->email            = $req->email;
        $data->telszam          = $req->telszam;
        $data->password         = $req->password;

        $data->Save();
        return redirect('/main')->with([
            'siker' => 'Sikeresen regisztráltál, üdvözlünk a WalletMaster oldalán '.$req->vez_nev.' '.$req->ker_nev.'!'
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

    public function Mentes() {
        if (Auth::check()) {
            return view("fiokom");
        }
        else {
            return redirect("/belepes");
        }
    }

    public function MentesBtn(Request $req) {
        //dd($req->all());

        //Validáció nem teljesen jó
        //function név átírása
        $req->validate([
            'firstName' => "max:30",
            'lastName'  => "max:30",
            //https://regex101.com/library/SxCdMO?orderBy=RELEVANCE&search=email+&filterFlavors=pcre2
            //regex alkalmazását követően összeomlik a rendszer, nem frissül semmi!
        'email'      => [   "email",
                            // "email:rfc,dns",
                            //Rule::unique('users', 'email')->ignore(Auth::id())/*,"email:rfc,dns"],*/
                            "unique:users,email,".Auth::user()->id
                        ],
            //tömbben kell, különben összezavarodik néha a controller, összeolvad a regexszel minden
            'phone'               => [Rule::unique('users','telszam')->ignore(Auth::id())],
            'currentpassword',
            "newpassword"                   => ["confirmed", Password::min(8)
                                               ->letters()
                                              ->numbers()
                                             ->mixedCase()
                                            ->symbols()
                                            ->uncompromised()],
                                    //Tesztjelszó: #Palmafa123
             "newpassword_confirmation"
        ], [
            'firstName.max'             => 'Maximum 30 karakter lehet!',
            'lastName.max'              => 'Maximum 30 karakter lehet!',
            'username.max'              => "Maximum 30 karakter lehet!",
            'username.unique'           => "Ez a felhasználónév foglalt.",
            "email.unique"              => "Ez az email cím foglalt.",
            'email.regex'               => "Az email címnek tartalmaznia kell",
            'phone.regex'               => 'A telefonszámnak meg kell felelnie a telefonszám formátumnak, például: +36701234567.',
            'phone.unique'              => "Ez a telefonszám foglalt.",
            '*.required'                    => "Kötelező kitölteni!",
            //https://laravel.com/docs/12.x/validation -> sometimes
            "*.confirmed"                   => "Nem egyezik a jelszó!",
            "newpassword.min"               => "A jelszónak legalább 8 karakter hosszúnak kell lennie!",
            "newpassword.letters"           => "A jelszónak kell betűt tartalmaznia!",
            "newpassword.numbers"           => "A jelszónak legalább 1 számot kell tartalmaznia!",
            "newpassword.mixed"             => "A jelszónak kis és nagy betűt is kell tartalmaznia!",
            "newpassword.symbols"           => "A jelszónak legalább egy speciális karaktert kell tartalmaznia!",
            "newpassword.uncompromised"     => "Ez a jelszó már szerepelt korábbi adatvédelmi incidensekben, ezért nem biztonságos."
        ]);

        $data = User::find(Auth::user()->id);
        if ($req->has('firstName') && $req->firstName != $data->vez_nev) {
            $data->vez_nev = $req->firstName;
        }

        if ($req->has('lastName') && $req->lastName != $data->ker_nev) {
            $data->ker_nev = $req->lastName;
        }
        if ($req->has('username') && $req->username != $data->felhasznalonev) {
            $data->felhasznalonev = $req->username;
        }
        if ($req->has('email') && $req->email != $data->email) {
            $data->email = $req->email;
        }
        if ($req->has('phone') && $req->phone != $data->telszam) {
            $data->telszam = $req->phone;
        }

        //https://laravel.com/docs/12.x/eloquent#examining-attribute-changes
        if (!$data->isDirty()) {
        return redirect('/fiokom')->with('sikertelen', 'Nem történt változás.');
}

        $data->save();
        return redirect('/fiokom')->with('siker', 'Sikeres adatmódosítás!');

        //jelszó megegyezés nem megy, javítani kell, pipa
        if(Hash::check($req->currentpassword, Auth::user()->password)){
            if($req->currentpassword == $req->newpassword){
                return redirect('/fiokom')->with(['sikertelen' => "Nem adhatja meg újra a korábbi jelszavát"]);
            }
        
            else if($req->newpassword != $req->newpassword_confirmation) {
                return redirect('/fiokom')->with(['sikertelen' => "A két jelszó nem egyezik!"]);
            }
            else{
                $data = User::find(Auth::user()->id);
                $data->password = $req->newpassword;
                $data->Save();
                return redirect('/fiokom')->with(['siker' => "Sikeresen megváltoztatta a jelszavát"]);
            }
        }
        else{
            return redirect('/fiokom')->with(['kudarc' => "Nem sikerült a jelszómódosítás"]);
        }
    }
    }  
    

#walletmaster@gmail.com
#Palmafa123
