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
        $allDebt = tartozasok::where('user_id', Auth::id())
                            ->get();
        $username = User::join('tartozasok', 'tartozasok.partner_user_id', '=', 'users.id')
                            ->where('tartozasok.user_id', Auth::id())
                            ->value('users.felhasznalonev');
        return view("debt", [
            "allDebt"   => $allDebt,
            "username"  => $username
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
        $data = new tartozasok;
        $data->user_id = Auth::id();
        $data->partner_nev = $req->name;
        $data->partner_user_id = $partnerId;
        //0 ha nekünk, 1 ha mi neki
        if ($req->debtToFrom == "debtTo") {
            $data->tipus = 1;
        }
        else {
            $data->tipus = 0;
        }
        $data->osszeg = $req->debtAmount;
        $data->leiras = $req->description;
        $data->datum = $req->debtDate;

        $data->Save();
        return view("debt")->with(["success" => "Sikeresm mentés!"]);
    }
}
