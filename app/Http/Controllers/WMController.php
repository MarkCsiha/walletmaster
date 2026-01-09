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
                                            ->groupBy('category_name')
                                            ->orderBy('total')
                                            //megkapja a pluck az értéket és kulcsot, érték első, kulcs második
                                            ->pluck('total', 'category_name');

            return view('main', [
                //a pluck-ból megkapja a kulcsot és értéket
                'labels'    => $userSpending->keys(),
                'data'      => $userSpending->values(),
        ]);
    }
    
}
