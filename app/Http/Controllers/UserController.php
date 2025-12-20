<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function Regisztracio(Request $req){
        $req->validate([
            'nev'                   => 'required|max:30',
            'email'                 => 'required|email|unique:user,email',
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
            'nev.max'               => 'Maximum 30 karakter lehet!',
            '*.email'               => 'Érvényes e-mail címet adj meg!',
            'email.unique'          => 'Ezzel az e-mail címmel már regisztráltak!',
            '*.confirmed'           => 'A két jelszó nem egyezik meg!',
            'password.min'          => 'A jelszónak legalább 8 karakternek kell lenni!',
            'password.letters'      => 'A jelszónak kell betűt tartalmaznia',
            'password.numbers'      => 'A jelszónak legalább egy számot kell tartalmaznia!',
            'password.mixed'        => 'A jelszónak kis- és nagybetűt is kell tartalmaznia!',
            'password.symbols'      => 'A jelszónak legalább egy speciális karakter kell tartalmaznia!',
            'password.uncompromised'=> 'Ez a jelszó már szerepelt adatvédelmi incidensben, ezért nem biztonságos!'    
        ]);

        $data           = new User;
        $data->nev      = $req->nev;
        $data->email    = $req->email;
        $data->password = $req->password;
                        //  Hash::make($req->password);
        $data->Save();
        return redirect('/')->with([
            'siker' => 'Sikeresen regisztráltál a '.$req->nev.' névvel'
        ]);
    }
}
