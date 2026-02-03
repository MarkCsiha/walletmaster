<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use App\Models\szamla;
use Illuminate\Support\Facades\Auth;

//https://www.youtube.com/watch?v=ZwA7MeuQRik
//https://docs.laravel-excel.com/3.1/getting-started/installation.html
class SpendingExport implements FromView, ShouldAutoSize
{
    use Exportable;

    private $spending;
    public function __construct() {
        $this->spending = szamla::select('*')
                                ->where("user_id", Auth::id())
                                ->orderBy("datum", "DESC")
                                ->get();
    }

    public function view(): View {
        return view("spending", [
            "spending"  => $this->spending
        ]);
    }
}
