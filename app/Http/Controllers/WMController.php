<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\szamla;
use App\Models\kategoriak;
use Illuminate\Support\Facades\Auth;


class WMController extends Controller
{
    public function Main(){
        // return view("main", [
        //     "result" => szamla::all()
        // ]);
    }

    public function Charts() {
           //https://www.youtube.com/watch?v=2Zy7gHWl5-Y&t=180s
            $userSpending = szamla::selectRaw("kategoria_nev as category_name, SUM(osszeg) as total")
                                            //biztosan a felhasználó adatait adja meg
                                            ->where("user_id", Auth::id())
                                            ->groupBy('category_name')
                                            ->orderBy('total')
                                            //megkapja a pluck az értéket és kulcsot, érték első, kulcs második
                                            ->pluck('total', 'category_name');

            //Csak akkor láthatja a felhasználó, ha be van jelentkezve, ha nem, akkor a bejelentkezés oldalra irányít automatikusan
            if (Auth::check()) {
                return view('main', [
                //a pluck-ból megkapja a kulcsot és értéket
                'labels'    => $userSpending->keys(),
                'data'      => $userSpending->values(),
                ]);
            }
            else {
                return redirect("login");
            }
    }

    public function SpendingChart() {
        //amit akarok: kiveszem a költés és bevétel adatokat a
        $spent = szamla::selectRaw("SUM(osszeg) as spent")
                                ->where("tipus", '0');
        $income = szamla::selectRaw("SUM(osszeg) as income")
                                ->where("tipus", "1");
        $spendingIncome = szamla::where("user_id", Auth::id())

                                            //biztosan a felhasználó adatait adja meg
                                            ->groupBy('tipus')
                                            ->orderBy('total')
                                            //megkapja a pluck az értéket és kulcsot, érték első, kulcs második
                                            ->pluck('total', 'category_name');

            //Csak akkor láthatja a felhasználó, ha be van jelentkezve, ha nem, akkor a bejelentkezés oldalra irányít automatikusan
            if (Auth::check()) {
                return view('main', [
                //a pluck-ból megkapja a kulcsot és értéket
                'labels'    => $spendingIncome->keys(),
                'data'      => $spendingIncome->values(),
                ]);
            }
            else {
                return redirect("login");
            }
    }
}
