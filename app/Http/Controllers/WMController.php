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

    public function Charts(Request $req) {
           //https://www.youtube.com/watch?v=2Zy7gHWl5-Y&t=180s
            $userSpending = szamla::where("user_id", Auth::id())
                                    ->when($req->from, function($query) use ($req) {
                                        return $query->whereDate('datum', '>=', $req->from);
                                    })
                                    ->when($req->to, function($query) use ($req) {
                                        return $query->whereDate('datum', '<=', $req->to);
                                    })
                                    ->selectRaw("kategoria_nev as category_name, SUM(osszeg) as total")
                                            //biztosan a felhasználó adatait adja meg
                                            ->where("tipus", 0)
                                            ->groupBy('category_name')
                                            ->orderBy('total')
                                            //megkapja a pluck az értéket és kulcsot, érték első, kulcs második
                                            ->pluck('total', 'category_name');

            //Csak akkor láthatja a felhasználó, ha be van jelentkezve, ha nem, akkor a bejelentkezés oldalra irányít automatikusan
            $categories = szamla::where("user_id", Auth::id())
                                ->selectRaw("kategoria_nev as category_name");
            if (Auth::check()) {
                return view('main', [
                //a pluck-ból megkapja a kulcsot és értéket
                'userSpending' => $userSpending,
                'labels'    => $userSpending->keys(),
                'data'      => $userSpending->values(),
                ]);
            }
            else {
                return redirect("login");
            }
    }

    public function SpendingChart() {
        $spent = szamla::where('user_id', Auth::id())
                        ->where('tipus', 0)
                        ->sum("osszeg");
        $income = szamla::where('user_id', Auth::id())
                        ->where('tipus', 1)
                        ->sum("osszeg");
        $labels = ["Kiadás", "Bevétel"];
        $data = [$spent, $income];

            //Csak akkor láthatja a felhasználó, ha be van jelentkezve, ha nem, akkor a bejelentkezés oldalra irányít automatikusan
            if (Auth::check()) {
                return view('main', [
                //a pluck-ból megkapja a kulcsot és értéket
                'labels'    => $labels,
                'data'      => $data,
                ]);
            }
            else {
                return redirect("login");
            }
    }
}
