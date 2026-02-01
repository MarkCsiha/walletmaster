<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tartozasok;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Mail\DebtMail;
use Illuminate\Queue\RedisQueue;
use Illuminate\Support\Facades\Mail;

class DebtController extends Controller
{
    public function DebtShow() {
        $allDebt = tartozasok::query()
                                ->where('tartozasok.user_id', Auth::id())
                                ->leftJoin('users', 'users.id', '=', 'tartozasok.partner_user_id')
                                ->select('tartozasok.*', 'users.felhasznalonev as partner_username')
                                ->get();

        return view("debt", [
            "allDebt"   => $allDebt,
            ]);
    }

    public function DebtAdd(Request $req) {
        $req->validate([
            "debtDate"          => "date_format:Y-m-d|before_or_equal:today"
        ],
        [
            'debtDate.before'   => "Nem adhat meg jövőbeli dátumot!"
        ]);

        $partnerId = null;
        //ellenőrizzük, hogy létezik-e a user akinek felhasználónevet adunk, ha igen, akkor a partnerId-t egyenlővé tesszük vele
        if ($req->filled('username')) {
            $partner = User::where('felhasznalonev', $req->input('username'))->first();

            if (!$partner) {
                return view("debt")->with(["unsuccessful" => "Nincs ilyen nevű felhasználó!"]);
            }

            $partnerId = $partner->id;
        }
        //"én nézetem": az a user, aki felvitte a tartozást az adabázisba, annak így fog megjelenni
        $myView                  = new tartozasok;
        $myView->user_id         = Auth::id();
        $myView->partner_nev     = $req->name;
        $myView->partner_user_id = $partnerId;
        //0 ha nekünk, 1 ha mi neki
        if ($req->debtToFrom == "debtTo") {
            $myView->tipus = 1;
        }
        else {
            $myView->tipus = 0;
        }
        $myView->osszeg = $req->debtAmount;
        $myView->leiras = $req->description;
        $myView->datum  = $req->debtDate;

        $myView->save();

        //ha van partner, azaz felhasználónév, akkor el kell menteni a másik félnek is az adatokat. Ez a tükrözött nézet, neki fordítva lesz elmentve
        if ($partnerId) {
            $mirror                  = new tartozasok;
            $mirror->user_id         = $partnerId;
            //trimmeljük, hogy a Laravel elfogadja partner névként a User tábla két külön elemét
            $mirror->partner_nev     = trim((Auth::User()->vez_nev ?? '') . ' ' . (Auth::User()->ker_nev ?? ''));
            $mirror->partner_user_id = Auth::id();
            $mirror->osszeg          = $req->debtAmount;
            $mirror->leiras          = $req->description;
            $mirror->datum           = $req->debtDate;
            if ($myView->tipus == 1) {
                $mirror->tipus = 0;
            }
            else {
                $mirror->tipus = 1;
            }
            $mirror->save();
            //email-t küld a usernek, aki felé a tartozási kérelem ment
            Mail::to($partner->email)->send(new DebtMail($mirror));


        }
        return redirect()->route('debt.show')->with('success', 'Sikeres mentés!');

    }

    public function ShowDebtDetails($id) {
        $debt = tartozasok::find($id);
        $userDebt = tartozasok::query()
                                ->where('tartozasok.tartozasok_id', '=', $id)
                                ->leftJoin('users', 'users.id', '=', 'tartozasok.partner_user_id')
                                ->select('tartozasok.*', 'users.felhasznalonev as partner_username')
                                ->first();

        return view('debt-accept', [
            "id"        => $id,
            "debt"  => $debt,
            "userDebt"  => $userDebt
        ]);
    }

    public function AcceptDebt(Request $req, $id) {
        $debt = tartozasok::findOrFail($id);
        $debt->statusz = "elfogadva";
        $debt->save();

        if ($debt->partner_user_id) {
            $originalDebt = tartozasok::where([
                'user_id'         => $debt->partner_user_id,
                'partner_user_id' => $debt->user_id,
                'datum'           => $debt->datum,
                'osszeg'          => $debt->osszeg,
                'leiras'          => $debt->leiras
        ])->first();

        if ($originalDebt) {
            $originalDebt->statusz = "elfogadva";
            $originalDebt->save();
        }
    }


        return redirect()->route('debt.show')->with('success', 'Elfogadva!');
    }

    public function RejectDebt($id) {
        $debt = tartozasok::findOrFail($id);
        $debt->statusz = "elutasítva";
        $debt->save();

        if ($debt->partner_user_id) {
            $originalDebt = tartozasok::where([
                'user_id'         => $debt->partner_user_id,
                'partner_user_id' => $debt->user_id,
                'datum'           => $debt->datum,
                'osszeg'          => $debt->osszeg,
                'leiras'          => $debt->leiras
        ])->first();

        if ($originalDebt) {
            $originalDebt->statusz = "elutasítva";
            $originalDebt->save();
            }
        }

        return redirect()->route('debt.show')->with('success', 'Visszautasítva!');    }
}
