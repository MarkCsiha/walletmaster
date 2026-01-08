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
           
            // return view("main", [
            //      "result" => szamla::all()
                                        
            //                 // ->join('kategoriak', 'szamla.kategoria_id', '=', 'kategoriak.id')
            //                 // ->where('szamla.user_id', Auth::id())
            //                 // ->selectRaw('kategoriak.kategoria_nev as label, SUM(szamla.osszeg) as total')
            //                 // ->groupBy('kategoriak.kategoria_nev')
            //                 // ->orderByDesc('total')
            //                 // ->get()
            // ]);
              $userSpending = szamla::selectRaw("kategoria_nev as category_name, SUM(osszeg) as total")
                                            ->groupBy('category_name')
                                            ->orderBy('total')
                                            //megkapja a pluck az értéket és kulcsot, érték első, kulcs második
                                            ->pluck('total', 'category_name');

            return view('main', [
                //a pluck-ból megkapja a kulcsot és értéket
                'labels' => $userSpending->keys(),
                'data' => $userSpending->values(),
        ]);
    }
}
