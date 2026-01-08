<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use App\Models\kategoriak;
use App\Models\szamla;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class filters extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $datas = szamla::orderBy("osszeg")->get()
        ->where('user_id', Auth::id())
    // ha csak kiadás kell, pl. 0 = kiadás:
    // ->where('tipus', 0)
        ->join('kategoriak', 'szamla.kategoriak_id', '=', 'kategoriak.id')
        ->groupBy('kategoriak.id', 'kategoriak.kategoria_nev')
        ->select('kategoriak.kategoria_nev', DB::raw('SUM(szamla.osszeg) as total'))
        ->orderByDesc('total')
        ->get();;
        return view('components.filters', compact(var_name: 'kategoria_nev'));
    }
}
