<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tartozasok;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DebtController extends Controller
{
    public function DebtShow() {
        $allDebt = tartozasok::query()
                                ->where('tartozasok.user_id', Auth::id())
                                ->leftJoin('users', 'users.id', '=', 'tartozasok.partner_user_id')
                                ->select('tartozasok.*', 'users.felhasznalonev as partner_username')
                                ->get();

        $kinek = User::select('users.felhasznalonev as partner_username')
                        ->join('tartozasok', 'users.id', '=', 'tartozasok.partner_user_id')
                        ->where("users.id", "partner_user_id")
                        ->get();
        return view("debt", [
            "allDebt"   => $allDebt,
            "kinek"     => $kinek
            ]);
    }

    public function DebtAdd(Request $req) {
        $req->validate([
            "debtDate" => "date_format:Y-m-d|before:today"
        ],
        [
            'debtDate.before' => "Nem adhat meg jövőbeli dátumot!"
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
        $myView = new tartozasok;
        $myView->user_id = Auth::id();
        $myView->partner_nev = $req->name;
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
        $myView->datum = $req->debtDate;

        $myView->save();

        if ($partnerId) {
            $mirror = new tartozasok;
            $mirror->user_id = $partnerId;
            $mirror->partner_nev = trim(($myView->vez_nev) . ' ' . ($myView->ker_nev));
            $mirror->partner_user_id = Auth::id();
            $mirror->osszeg = $req->debtAmount;
            $mirror->leiras = $req->description;
            $mirror->datum = $req->debtDate;
            if ($myView->tipus == 1) {
                $mirror->tipus = 0;
            }
            else {
                $mirror->tipus = 1;
            }
            $mirror->save();

        }
return redirect()->route('debt.show')->with('success', 'Sikeres mentés!');

    }
}
