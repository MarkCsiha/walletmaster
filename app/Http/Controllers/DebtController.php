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
    public function DebtShow()
    {
        //javítsd
        $allDebt = tartozasok::where('tartozasok.user_id', Auth::id())
            ->leftJoin('users', 'users.id', '=', 'tartozasok.partner_user_id')
            ->select('tartozasok.*', 'users.felhasznalonev as partner_username')
            ->get();

        return view("debt", [
            "allDebt"   => $allDebt,
        ]);
    }

    public function DebtAdd(Request $req)
    {
        $req->validate([
                "debtDate"              => "required|date_format:Y-m-d|before_or_equal:today",
                "debtAmount"            => "required|numeric"
            ], [
                'debtDate.before'       => "Nem adhat meg jövőbeli dátumot!",
                "*.required"            => "Kötelező mező!",
                "debtAmount.numeric"    => "Csak számot adhat meg!"
        ]);

        $partnerId = null;
        if ($req->filled('username')) {
            $partner = User::where('felhasznalonev', $req->username)->first();

            if (!$partner) {
                return redirect('debt')->with(['unsuccessful' => 'Nem találtunk ilen felhasználónévvel rendelkező felhasználót!']);
            }

            $partnerId = $partner->id;
        }
        $myView                  = new tartozasok;
        $myView->user_id         = Auth::id();
        $myView->partner_nev     = $req->name;
        $myView->partner_user_id = $partnerId;
        if ($req->debtToFrom == "debtTo") {
            $myView->tipus = 1;
        } else {
            $myView->tipus = 0;
        }
        $myView->osszeg = $req->debtAmount;
        $myView->leiras = $req->description;
        $myView->datum  = $req->debtDate;
        $myView->ki_irta = Auth::id();

        $myView->save();

        if ($partnerId) {
            $mirror                  = new tartozasok;
            $mirror->user_id         = $partnerId;
            $mirror->partner_nev     = trim(Auth::User()->vez_nev ?? '').' '.(Auth::User()->ker_nev ?? '');
            $mirror->partner_user_id = Auth::id();
            $mirror->osszeg          = $req->debtAmount;
            $mirror->leiras          = $req->description;
            $mirror->datum           = $req->debtDate;
            if ($myView->tipus == 1) {
                $mirror->tipus = 0;
            } else {
                $mirror->tipus = 1;
            }
            $mirror->ki_irta = Auth::id();
            $mirror->save();
            Mail::to($partner->email)->send(new DebtMail($mirror));
        }
        return redirect('debt')->with(['success' => 'Sikeres tartozás hozzáadás!']);
    }

    public function ShowDebtDetails($id)
    {
        $debt = tartozasok::where("tartozasok_id", $id)
            ->where("user_id", Auth::id())
            ->firstOrFail();
        $userDebt = tartozasok::where('tartozasok.tartozasok_id', '=', $id)
            ->where("user_id", Auth::id())
            ->leftJoin('users', 'users.id', '=', 'tartozasok.partner_user_id')
            ->select('tartozasok.*', 'users.felhasznalonev as partner_username')
            ->firstOrFail();

        return view('debt-accept', [
            "id"        => $id,
            "debt"      => $debt,
            "userDebt"  => $userDebt
        ]);
    }

    public function AcceptDebt($id)
    {
        $debt = tartozasok::where("tartozasok_id", $id)
                            ->where("user_id", Auth::id())
                            ->firstOrFail();
        if ($debt->ki_irta == Auth::id()) {
            return redirect('/debt')->with(['unsuccessful' => 'Saját maga által rögzített tartozást nem fogadhat el.']);
        }

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
        return redirect('/debt')->with(['success' => 'Sikeresen elfogadta a tartozást!']);
    }

    public function RejectDebt($id)
    {
        $debt = tartozasok::where("tartozasok_id", $id)
            ->where("user_id", Auth::id())
            ->firstOrFail();

        if ($debt->ki_irta == Auth::id()) {
            return redirect('/debt')->with(['unsuccessful' => 'Saját maga által rögzített tartozást nem fogadhat el.']);
        }

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

        return redirect('/debt')->with(['success' => 'Visszautasította a tartozást!']);
    }

    public function DebtDone($id)
    {
        $debt = tartozasok::where("tartozasok_id", $id)
            ->where("user_id", Auth::id())
            ->firstOrFail();

        if ($debt->ki_irta == Auth::id()) {
            return redirect('/debt')->with('unsuccessful', 'Saját maga által rögzített tartozást nem fogadhat el.');
        }
        $debt->statusz = "rendezve";
        $debt->save();

        return redirect('/debt')->with(["success"   => "Sikeres tartozásteljesítés!"]);
    }

    public function ShowPendingDebts()
    {
        $userDebt = tartozasok::where('tartozasok.user_id', Auth::id())
            ->where("tartozasok.ki_irta", "!=", Auth::id())
            ->where("statusz", "függőben")
            ->leftJoin('users', 'users.id', '=', 'tartozasok.partner_user_id')
            ->select('tartozasok.*', 'users.felhasznalonev as partner_username')
            ->get();

        return view('debt-pending', [
            "userDebt"  => $userDebt
        ]);
    }
}
