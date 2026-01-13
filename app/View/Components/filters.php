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
        $data = szamla::orderBy("osszeg")
        ->where('user_id', Auth::id())
        ->get();
    // ha csak kiadás kell, pl. 0 = kiadás:
    // ->where('tipus', 0)
        return view('components.filters', compact(var_name: 'data'));
    }
}
