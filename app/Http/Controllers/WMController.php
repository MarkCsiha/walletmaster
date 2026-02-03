<?php

namespace App\Http\Controllers;

use App\Exports\SpendingExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\szamla;
use App\Models\kategoriak;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;



class WMController extends Controller
{
    //https://www.youtube.com/watch?v=2Zy7gHWl5-Y&t=180s
     public function Main(Request $req){
        $user = Auth::id();

        // --- a te meglévő listád (marad) ---
        $result = szamla::where("user_id", $user)
            ->orderBy("datum", "desc")
            ->paginate(10);

        // --- NAPTÁR: hónap kiválasztás query param alapján ---
        $ym = $req->query('ym', now()->format('Y-m')); // pl. 2026-01

        $monthStart = Carbon::createFromFormat('Y-m', $ym)->startOfMonth();
        $monthEnd   = $monthStart->copy()->endOfMonth();

        // Naptár rács: hétfővel induljon, vasárnappal zárjon
        $gridStart = $monthStart->copy()->startOfWeek(Carbon::MONDAY);
        $gridEnd   = $monthEnd->copy()->endOfWeek(Carbon::SUNDAY);

        $days = [];
        for ($d = $gridStart->copy(); $d->lte($gridEnd); $d->addDay()) {
            $days[] = $d->copy();
        }

        $prevYm = $monthStart->copy()->subMonth()->format('Y-m');
        $nextYm = $monthStart->copy()->addMonth()->format('Y-m');
        $monthly = null;

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
        $year = (int) $req->input('year', now()->year);

        if ($req->input('chartDataType') === 'categoryChart') {
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
        }
        //ha a felhasználó havi költségbontást kér
        if ($req->input('chartDataType') === 'monthlyChart') {
            //CASE: azért kell, hogy az oszlopok címei 1, 2, stb. helyett a hónapok nevei legyenek pl. Január
            $monthly = szamla::selectRaw("MONTH(datum) as month_number,CASE MONTH(datum)
                                            WHEN 1 THEN 'Január'
                                            WHEN 2 THEN 'Február'
                                            WHEN 3 THEN 'Március'
                                            WHEN 4 THEN 'Április'
                                            WHEN 5 THEN 'Május'
                                            WHEN 6 THEN 'Június'
                                            WHEN 7 THEN 'Július'
                                            WHEN 8 THEN 'Augusztus'
                                            WHEN 9 THEN 'Szeptember'
                                            WHEN 10 THEN 'Október'
                                            WHEN 11 THEN 'November'
                                            WHEN 12 THEN 'December'
                                            END as month_name,
                                            SUM(osszeg) as monthly_total")
                                ->where('user_id', Auth::id())
                                ->whereYear('datum', $year)
                                ->groupBy(['month_number', 'month_name'])
                                ->orderBy('month_number')
                                ->pluck('monthly_total', 'month_name');
        }

        $spentIncome = null;

        if ($req->input('chartDataType') === 'spentIncomeChart') {
            $spentIncome = szamla::selectRaw("SUM(osszeg) as osszeg, MONTH(datum) as month_number, CASE MONTH(datum)
                                                WHEN 1 THEN 'Január'
                                                WHEN 2 THEN 'Február'
                                                WHEN 3 THEN 'Március'
                                                WHEN 4 THEN 'Április'
                                                WHEN 5 THEN 'Május'
                                                WHEN 6 THEN 'Június'
                                                WHEN 7 THEN 'Július'
                                                WHEN 8 THEN 'Augusztus'
                                                WHEN 9 THEN 'Szeptember'
                                                WHEN 10 THEN 'Október'
                                                WHEN 11 THEN 'November'
                                                WHEN 12 THEN 'December'
                                                END as month_name,
                                                SUM(osszeg) as monthly_total")
                                    ->where('user_id', Auth::id())
                                    ->whereYear('datum', $year)
                                    ->groupBy(['osszeg', 'month_name', 'month_number'])
                                    ->orderBy('month_number')
                                    ->pluck('osszeg', 'month_name');
        }

        //kiválasztja az éveket az adatbázisból
        $years = szamla::where('user_id', Auth::id())
                            ->selectRaw('YEAR(datum) as year')
                            ->distinct()
                            ->orderBy('year', 'desc')
                            ->pluck('year');
        //Csak akkor láthatja a felhasználó, ha be van jelentkezve, ha nem, akkor a bejelentkezés oldalra irányít automatikusan
        $categories = szamla::where("user_id", Auth::id())
                                ->selectRaw("kategoria_nev as category_name");

        if (Auth::check()) {
            return view('main', [
                //a pluck-ból megkapja a kulcsot és értéket
                'userSpending'      => $userSpending,
                'labels'            => $userSpending->keys(),
                'data'              => $userSpending->values(),
                'categories'        => $categories,
                //a pluck-ból megkapja a kulcsot és az értéket
                //'monthlyLabel'      => $monthly->keys(),
                //'monthlyData'       => $monthly->values(),
                'monthly'           => $monthly,
                'years'             => $years,
                'year'              => $year,
                'spentIncome'       => $spentIncome,
                "result"            => $result,
                "monthStart"        => $monthStart,
                "days"              => $days,
                "prevYm"            => $prevYm,
                "nextYm"            => $nextYm,
            ]);
        }
        else {
            return redirect("login");
        }
    }

    // public function Main(){
    //     $asd = Auth::id();
    //     return view("main", [
    //         "result" => szamla::where("user_id", $asd)->orderBy("datum", "desc")->paginate(10)


    //     ]);
    // }

    public function Add(){
        return view("add", [
        ]);
    }

    public function AddBtn(Request $req){
        $rules = [
            'Élelmiszer' => ['aldi', 'lidl', 'tesco', 'spar', 'cba', 'auchan', 'penny', 'interspar'],
            'Közlekedés' => ['shell', 'omv', 'mol', 'bkk', 'orlen', 'máv', 'uber', 'parkolás'],
            'Előfizetés' => ['netflix', 'spotify', 'youtube', 'disney+', 'hbo', 'google one', 'icloud'],
            'Számla' => ['vodafone', 'yettel', 'telekom', 'digi', 'eon', 'mvm', 'elmű', 'internet', 'tv']
        ];
        $req->validate([
            "osszeg"        =>  "required|numeric",
            "honnan"        =>  "required",
            "leiras"        =>  "max:200",
            "datum"         =>  "required|date|date_format:Y-m-d|before_or_equal:today",
            "fix"           =>  "required",
            "tipus"         =>  "required|not_in:0",
        ], [
            "*.required"            =>  "Töltse ki a mezőt!",
            "honnan.max"            =>  "Maximum 255 karakter adhat meg!",
            "osszeg.numeric"        =>  "Az összeget számmal adja meg!",
            "datum.date"            =>  "Létező dátumot adjon meg!",
            "datum.date_format"     =>  "A dátum helyes formátuma éééé-hh-nn",
            "datum.before_or_equal" =>  "Ne adjon meg jövőbeli dátumot!"
        ]);
        $desc = mb_strtolower
        ($req->leiras ?? '') . ' ' . ($req->leiras ?? '');

        //kategória ajánlás
        $suggested = null;
        foreach ($rules as $category => $keywords) {
            foreach($keywords as $kw) {
                if (str_contains($desc, $kw)) {
                    $suggested = $category;
                    break 2;
                }
            }
        }

        $data = new szamla;
        $data->user_id  = Auth::user()->id;
        $data->osszeg   =  $req->osszeg;
        $data->honnan   = $req->honnan;
        $data->leiras   = $req->leiras;
        $data->datum    = $req->datum;
        $data->fix      = $req->fix;
        #1 = bevétel
        #0 = kiadás
        if($req->tipus == "bevetel"){
            $data->tipus = 1;
        }
        else{
            $data->tipus = 0;
        }
        $data->kategoria_nev = $suggested ?? $req->kategoria;

        $data->Save();

        return redirect('/main')->with(["success"  => "Sikeres mentés!"]);
    }
    public function Index(Request $request)
    {
        $ym = $request->query('ym', now()->format('Y-m'));

        $monthStart = Carbon::createFromFormat('Y-m', $ym)->startOfMonth();
        $monthEnd = $monthStart->copy()->endOfMonth();

        $gridStart = $monthStart->copy()->startOfWeek(Carbon::MONDAY);
        $gridEnd   = $monthEnd->copy()->endOfWeek(Carbon::SUNDAY);

        $days = [];
        for ($d = $gridStart->copy(); $d->lte($gridEnd); $d->addDay()) {
            $days[] = $d->copy();
        }

        $prevYm = $monthStart->copy()->subMonth()->format('Y-m');
        $nextYm = $monthStart->copy()->addMonth()->format('Y-m');

        return view('naptar', compact('monthStart', 'days', 'prevYm', 'nextYm'));

    }

    public function Charts(Request $req) {
           //https://www.youtube.com/watch?v=2Zy7gHWl5-Y&t=180s
            // $userSpending = szamla::where("user_id", Auth::id())
            //                         ->when($req->from, function($query) use ($req) {
            //                             return $query->whereDate('datum', '>=', $req->from);
            //                         })
            //                         ->when($req->to, function($query) use ($req) {
            //                             return $query->whereDate('datum', '<=', $req->to);
            //                         })
            //                         ->selectRaw("kategoria_nev as category_name, SUM(osszeg) as total")
            //                                 //biztosan a felhasználó adatait adja meg
            //                                 ->where("tipus", 0)
            //                                 ->groupBy('category_name')
            //                                 ->orderBy('total')
            //                                 //megkapja a pluck az értéket és kulcsot, érték első, kulcs második
            //                                 ->pluck('total', 'category_name');

            // //Csak akkor láthatja a felhasználó, ha be van jelentkezve, ha nem, akkor a bejelentkezés oldalra irányít automatikusan
            // $categories = szamla::where("user_id", Auth::id())
            //                     ->selectRaw("kategoria_nev as category_name");
            // if (Auth::check()) {
            //     return view('main', [
            //     //a pluck-ból megkapja a kulcsot és értéket
            //     'userSpending' => $userSpending,
            //     'labels'    => $userSpending->keys(),
            //     'data'      => $userSpending->values(),
            //     ]);
            // }
            // else {
            //     return redirect("login");
            // }
    }

    public function SpendingChart() {
        // $spent = szamla::where('user_id', Auth::id())
        //                 ->where('tipus', 0)
        //                 ->sum("osszeg");
        // $income = szamla::where('user_id', Auth::id())
        //                 ->where('tipus', 1)
        //                 ->sum("osszeg");
        // $labels = ["Kiadás", "Bevétel"];
        // $data = [$spent, $income];

        //     //Csak akkor láthatja a felhasználó, ha be van jelentkezve, ha nem, akkor a bejelentkezés oldalra irányít automatikusan
        //     if (Auth::check()) {
        //         return view('main', [
        //         //a pluck-ból megkapja a kulcsot és értéket
        //         'labels'    => $labels,
        //         'data'      => $data,
        //         ]);
        //     }
        //     else {
        //         return redirect("login");
        //     }
    }

    public function ExportExcel() {
        //https://brainlet.medium.com/format-dates-with-carbon-in-laravel-583656a77940
        return Excel::download(new SpendingExport(), "koltsegvetesi_adat_".Carbon::today()->toDateString().".xlsx");
    }
}
