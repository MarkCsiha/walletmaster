<?php

namespace App\Http\Controllers;

use App\Exports\SpendingExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\szamla;
use App\Models\kategoriak;
use App\Models\koltseglimit;
use App\Models\celok;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\fix;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SzamlaImport;
use RealRashid\SweetAlert\Facades\Alert;

class WMController extends Controller
{
    //https://www.youtube.com/watch?v=2Zy7gHWl5-Y&t=180s
    public function Main(Request $req)
    {
        $user = Auth::id();

        $havi = szamla::select('szamla.user_id', 'szamla.szamla_id', 'szamla.osszeg', 'szamla.honnan', 'szamla.leiras', 'szamla.datum', 'szamla.fix', 'szamla.tipus', 'szamla.kategoria_nev')
            ->join('fix', 'szamla.szamla_id', '=', 'fix.szamla_id')
            ->where("fix.tipus", "havi")
            ->whereRaw('DATE_ADD(fix.fizetve, INTERVAL 1 MONTH) = CURDATE()')
            ->first();
        $feleves = szamla::select('szamla.user_id', 'szamla.osszeg', 'szamla.honnan', 'szamla.leiras', 'szamla.datum', 'szamla.fix', 'szamla.tipus', 'szamla.kategoria_nev')
            ->join('fix', 'szamla.szamla_id', '=', 'fix.szamla_id')
            ->where("fix.tipus", "feleves")
            ->whereRaw('DATE_ADD(fix.fizetve, INTERVAL 6 MONTH) = CURDATE()')
            ->first();
        $eves = szamla::select('szamla.user_id', 'szamla.osszeg', 'szamla.honnan', 'szamla.leiras', 'szamla.datum', 'szamla.fix', 'szamla.tipus', 'szamla.kategoria_nev')
            ->join('fix', 'szamla.szamla_id', '=', 'fix.szamla_id')
            ->where("fix.tipus", "eves")
            ->whereRaw('DATE_ADD(fix.fizetve, INTERVAL 1 YEAR) = CURDATE()')
            ->first();

        if ($havi != null) {
            $data = new szamla;
            $data->user_id      = Auth::user()->id;
            $data->osszeg       = $havi->osszeg;
            $data->honnan       = $havi->honnan;
            $data->leiras       = $havi->leiras;
            $data->datum        = now()->format('Y-m-d');;
            $data->fix          = $havi->fix;
            $data->tipus        = $havi->tipus;
            $data->kategoria_nev = $havi->kategoria_nev;
            $data->Save();

            $kfix = fix::where('szamla_id', $havi->szamla_id)->first();
            if($kfix){
                $kfix->fizetve = now()->format('Y-m-d');
                $kfix->Save();
            }
        }
        if ($feleves != null) {
            $data = new szamla;
            $data->user_id      = Auth::user()->id;
            $data->osszeg       = $havi->osszeg;
            $data->honnan       = $havi->honnan;
            $data->leiras       = $havi->leiras;
            $data->datum        = now()->format('Y-m-d');
            $data->fix          = $havi->fix;
            $data->tipus        = $havi->tipus;
            $data->kategoria_nev = $havi->kategoria_nev;
            $data->Save();

            $kfix = fix::where('szamla_id', $havi->szamla_id)->first();
            if ($kfix) {
                $kfix->fizetve = now()->format('Y-m-d');
                $kfix->Save();
            }
        }
        if ($eves != null) {
            $data = new szamla;
            $data->user_id      = Auth::user()->id;
            $data->osszeg       = $havi->osszeg;
            $data->honnan       = $havi->honnan;
            $data->leiras       = $havi->leiras;
            $data->datum        = now()->format('Y-m-d');;
            $data->fix          = $havi->fix;
            $data->tipus        = $havi->tipus;
            $data->kategoria_nev = $havi->kategoria_nev;
            $data->Save();

            $kfix = fix::where('szamla_id', $havi->szamla_id)->first();
            if ($kfix) {
                $kfix->fizetve = now()->format('Y-m-d');
                $kfix->Save();
            }
        }

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

        $dailySums = szamla::where('user_id', $user)
            ->whereBetween('datum', [
                $monthStart->toDateString(),
                $monthEnd->toDateString()
            ])
            ->selectRaw("
                                DATE(datum) as nap,
                                SUM(CASE WHEN tipus = 0 THEN osszeg ELSE 0 END) as spent,
                                SUM(CASE WHEN tipus = 1 THEN osszeg ELSE 0 END) as gain
                            ")
            ->groupBy('nap')
            ->get()
            ->keyBy('nap');

        //chart
        $userSpending = szamla::where("user_id", Auth::id())
            ->when($req->from, function ($query) use ($req) {
                return $query->whereDate('datum', '>=', $req->from);
            })
            ->when($req->to, function ($query) use ($req) {
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

        if ($req->input('chartDataType') == 'categoryChart') {
            $userSpending = szamla::where("user_id", Auth::id())
                                    ->when($req->from, function ($query) use ($req) {
                                        return $query->whereDate('datum', '>=', $req->from);
                                    })
                                    ->when($req->to, function ($query) use ($req) {
                                        return $query->whereDate('datum', '<=', $req->to);
                                    })
                                    ->selectRaw("kategoria_nev as category_name, SUM(osszeg) as total")
                                    ->where("tipus", 0)
                                    ->groupBy('category_name')
                                    ->orderBy('total')
                                    ->pluck('total', 'category_name');
        }
        //ha a felhasználó havi költségbontást kér
        if ($req->input('chartDataType') == 'monthlyChart') {
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
                ->where("tipus", 0)
                ->groupBy(['month_number', 'month_name'])
                ->orderBy('month_number')
                ->pluck('monthly_total', 'month_name');
        }

        $spent = null;
        $income = null;
        if ($req->input('chartDataType') == 'spentIncomeChart') {
            $spent = szamla::selectRaw("SUM(osszeg) as osszeg, tipus, MONTH(datum) as month_number, CASE MONTH(datum)
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
                            ->where("tipus", 0)
                            ->whereYear('datum', $year)
                            ->groupBy(['tipus', 'month_name', 'month_number'])
                            ->orderBy('month_number')
                            ->pluck('osszeg', 'month_name');
            $income = szamla::selectRaw("SUM(osszeg) as osszeg, tipus, MONTH(datum) as month_number, CASE MONTH(datum)
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
                            ->where("tipus", 1)
                            ->whereYear('datum', $year)
                            ->groupBy(['tipus', 'month_name', 'month_number'])
                            ->orderBy('month_number')
                            ->pluck('osszeg', 'month_name');
        }

        //kiválasztja az éveket az adatbázisból
        $years = szamla::where('user_id', Auth::id())
            ->selectRaw('YEAR(datum) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');
        $budgetComparison = null;
        $userExpenses = null;

        if ($req->input('chartDataType') == "budgetComparisonChart") {
            $budgetComparison = szamla::selectRaw("ROUND(AVG(osszeg)) as average, kategoria_nev as category_name")
                                        ->when($req->from, fn($q) => $q->whereDate('datum', '>=', $req->from))
                                        ->when($req->to, fn($q) => $q->whereDate('datum', '<=', $req->to))
                                        ->where("tipus", 0)
                                        ->where("user_id", "!=", Auth::id())
                                        ->groupBy("kategoria_nev")
                                        ->orderBy('kategoria_nev')
                                        ->pluck("average", "category_name");
            $userExpenses = szamla::selectRaw('kategoria_nev as category_name, ROUND(AVG(osszeg)) as average')
                                        ->where("user_id", Auth::id())
                                        ->where('tipus', 0)
                                        ->when($req->from, fn($q) => $q->whereDate('datum', '>=', $req->from))
                                        ->when($req->to, fn($q) => $q->whereDate('datum', '<=', $req->to))
                                        ->groupBy('kategoria_nev')
                                        ->orderBy('kategoria_nev')
                                        ->pluck('average', 'category_name');
        }
        $categories = szamla::where("user_id", Auth::id())
            ->selectRaw("kategoria_nev as category_name");

        $budgetGoal = null;
        //https://laracasts.com/discuss/channels/laravel/getting-the-first-and-last-date-of-the-current-month-and-past-2-months

        $currentBudget = koltseglimit::where('user_id', Auth::id())
                                    ->first();

        if ($req->filled('budgetLimit')) {
            if ($currentBudget) {
                $currentBudget->osszeg = $req->budgetLimit;
                $currentBudget->save();

            }

            else {
                $budgetGoal = new koltseglimit();
                $budgetGoal->user_id = Auth::id();
                $budgetGoal->osszeg = $req->budgetLimit;
                $budgetGoal->save();
            }


        }

        $category = request('category');
        if ($category == null) {
            $result = szamla::where("user_id", $user)
                ->whereYear('datum', $monthStart->year)
                ->whereMonth('datum', $monthStart->month)
                ->whereDay('datum', '>=', (int) request('from', 1))
                ->whereDay('datum', '<=', (int) request('to', 31))
                ->orderBy("datum", "desc")
                ->paginate(10);
        } else {
            $result = szamla::where("user_id", $user)
                ->whereYear('datum', $monthStart->year)
                ->whereMonth('datum', $monthStart->month)
                ->whereDay('datum', '>=', (int) request('from', 1))
                ->whereDay('datum', '<=', (int) request('to', 31))
                ->where('kategoria_nev', $category)
                ->orderBy("datum", "desc")
                ->paginate(10);
        }
        $result = szamla::where("user_id", $user)
            ->where("aktiv", 1)
            ->whereYear('datum', $monthStart->year)
            ->whereMonth('datum', $monthStart->month)
            ->orderBy("datum", "desc")
            ->paginate(10);

        if (Auth::check()) {
            return view('main', [
                'userSpending'      => $userSpending,
                'labels'            => $userSpending->keys(),
                'data'              => $userSpending->values(),
                'categories'        => $categories,
                'monthly'           => $monthly,
                'years'             => $years,
                'year'              => $year,
                'spent'             => $spent,
                'income'            => $income,
                "result"            => $result,
                "monthStart"        => $monthStart,
                "days"              => $days,
                "prevYm"            => $prevYm,
                "nextYm"            => $nextYm,
                "budgetComparison"  => $budgetComparison,
                "userExpenses"      => $userExpenses,
                // 'compLabels'        => $budgetComparison->keys(),
                // "compData"          => $budgetComparison->values(),
                "dailySums"         => $dailySums,
                "budgetGoal"        => $budgetGoal
            ]);
        } else {
            return redirect("/login");
        }
    }
    public function MainMod($szamla_id)
    {
        return view("mainmod", [
            "result" => szamla::find($szamla_id)
        ]);
    }

    public function MainModBtn(Request $req)
    {
        $req->validate([
            "osszeg"        =>  "required|numeric",
            "honnan"        =>  "required",
            "leiras"        =>  "max:200",
            "datum"         =>  "required|date|date_format:Y-m-d|before_or_equal:today",
            "fix"           =>  "required",
            "tipus"         =>  "required",
        ], [
            "*.required"            =>  "Töltse ki a mezőt!",
            "honnan.max"            =>  "Maximum 255 karakter adhat meg!",
            "osszeg.numeric"        =>  "Az összeget számmal adja meg!",
            "datum.date"            =>  "Létező dátumot adjon meg!",
            "datum.date_format"     =>  "A dátum helyes formátuma éééé-hh-nn!",
            "datum.before_or_equal" =>  "Ne adjon meg jövőbeli dátumot!"
        ]);
        $data = szamla::find($req->szamla_id);
        $data->osszeg =  $req->osszeg;
        $data->honnan = $req->honnan;
        $data->leiras = $req->leiras;
        $data->datum = $req->datum;
        $data->fix = $req->fix;

        if ($req->fix != "nem") {
            $kfix = fix::where("szamla_id", $data->szamla_id)->first();

            if ($kfix) {
                $kfix->tipus = $req->fix;
                $kfix->osszeg = $req->osszeg;
                $kfix->Save();
            } else {
                $kfix = new fix;
                $kfix->szamla_id = $data->szamla_id;
                $kfix->tipus = $req->fix;
                $kfix->osszeg = $req->osszeg;
                $kfix->letrehozas = $req->datum;
                $kfix->fizetve = $req->datum;
                $kfix->Save();
            }
        }
        #1 = bevétel
        #0 = kiadás
        if ($req->tipus == "bevetel") {
            $data->tipus = 1;
        } else {
            $data->tipus = 0;
        }
        $data->kategoria_nev = $req->kategoria;

        $data->Save();

        if (Auth::check()) {
            return redirect("/main")->with(["success" => "Sikeres módosítás!"]);
        } else {
            return redirect("/login");
        }
    }

    public function MainDelete($szamla_id)
    {
        $data = szamla::where("szamla_id", $szamla_id)->first();

        $data->aktiv = 0;
        $data->Save();

        if (Auth::check()) {
            return redirect("/main")->with(["success" => "Sikeresen törölte a költséget!"]);
        } else {
            return redirect("/login");
        }
    }

    public function Add()
    {
        if (Auth::check()) {
            return view("add", []);
        } else {
            return redirect("/login");
        }
    }

    public function AddBtn(Request $req)
    {
        $req->validate([
            "osszeg"        =>  "required|numeric",
            "honnan"        =>  "required|max:50",
            "leiras"        =>  "max:200",
            "datum"         =>  "required|date|date_format:Y-m-d|before_or_equal:today",
            "fix"           =>  "required",
            "tipus"         =>  "required|not_in:0",
        ], [
            "*.required"            =>  "Kötelező mező!",
            "honnan.max"            =>  "Maximum 255 karaktert adhat meg!",
            "osszeg.numeric"        =>  "Az összeget számmal adja meg!",
            "datum.date"            =>  "Létező dátumot adjon meg!",
            "datum.date_format"     =>  "A dátum helyes formátuma éééé-hh-nn!",
            "datum.before_or_equal" =>  "Ne adjon meg jövőbeli dátumot!"
        ]);

        $data = new szamla;
        $data->user_id  = Auth::user()->id;
        $data->osszeg   = $req->osszeg;
        $data->honnan   = $req->honnan;
        $data->leiras   = $req->leiras;
        $data->datum    = $req->datum;
        $data->fix      = $req->fix;
        #1 = bevétel
        #0 = kiadás
        if ($req->tipus == "bevetel") {
            $data->tipus = 1;
        } else {
            $data->tipus = 0;
        }

        $data->Save();

        $fix_pay = new fix;
        if($req->fix == "eves" || $req->fix == "feleves" || $req->fix == "havi"){
            $fix_pay->user_id = Auth::user()->id;
            $fix_pay->szamla_id = $data->szamla_id;
            $fix_pay->tipus = $data->fix;
            $fix_pay->osszeg = $data->osszeg;
            $fix_pay->letrehozas = now()->format('Y-m-d');
            $fix_pay->fizetve = now()->format('Y-m-d');
            $fix_pay->Save();
        }

        $first_day_of_the_current_month = Carbon::today()->startOfMonth()->toDateString();
        $last_day_of_the_current_month  = Carbon::today()->endOfMonth()->toDateString();

        $sumSpending = szamla::where("user_id", Auth::id())
                            ->where("tipus", 0)
                            ->whereBetween('datum', [$first_day_of_the_current_month, $last_day_of_the_current_month])
                            ->sum("osszeg");
        $limitSelect = koltseglimit::where("user_id", Auth::id())
                                    ->value("osszeg");
        $limitSelect = (int) ($limitSelect ?? 0);
        $limitMessage = null;
        $comparison = $sumSpending - $limitSelect;

        if ($limitSelect == 0) {
            $limitMessage = "Nincs megadva költség limit.";
        } elseif ($comparison > 0) {
            $limitMessage = "Túllépte az e havi megadott költség limitet ".$comparison." Ft-tal!";
        } else {
            $limitMessage = "Még ".abs($comparison)." Ft-tal a megadott e havi limit alatt van.";
        }
        return redirect('/main')->with(["success"  => "Sikeres mentés! ".$limitMessage.""]);
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

         if(Auth::check()){
            return view('naptar', compact('monthStart', 'days', 'prevYm', 'nextYm'));
        }
        else{
            return redirect("login");
        }

    }

    public function Charts(Request $req)
    {

    }

    public function SpendingChart()
    {

    }

    public function ExportExcel()
    {
        //https://brainlet.medium.com/format-dates-with-carbon-in-laravel-583656a77940
        return Excel::download(new SpendingExport(), "koltsegvetesi_adat_".Carbon::today()->toDateString().".xlsx", null, [
            "include_charts" => true,
        ]);
    }

    public function ImportExcel(Request $req)
    {
        $req->validate([
            "file"      => "required|file"
        ], [
            "file.required" => "Töltse fel a fájlt!",
            "file.file"     => "Fájlt adjon meg!"
        ]);
        Excel::import(new SzamlaImport(), $req->file('file'));

        if(Auth::check()){
            return redirect('/add')->with(["success" => "Sikeres fájlfeltöltés!"]);
        }
        else{
            return redirect("login");
        }

    }
    public function Goals()
    {
        $user = Auth::id();
        $result = celok::where("user_id", $user)->orderBy("statusz")->get();
        if(Auth::check()){
            return view("goals", [
                "result" => $result,
            ]);
        }
        else{
            return redirect("login");
        }
    }

    public function GoalsBtn(Request $req)
    {
        $req->validate([
            "nev"               =>  "required|unique:celok,cel_nev|max:150",
            "cel_osszeg"        =>  "required",
            "osszeg"            =>  "required",
            "hatarido"          =>  "required|date|date_format:Y-m-d",
        ], [
            "*.required"                =>  "Kötelező mező!",
            "nev.unique"                =>  "Már létezik ".$req->nev." nevű célja!",
            "hatarido.date"             =>  "Valós dátumot adjon meg!",
            "hatarido.date_format"      =>  "A dátum helyes formátuma éééé-hh-nn!",
        ]);

        $data = new celok;
        $data->user_id = Auth::user()->id;
        $data->cel_nev = $req->nev;
        $data->cel_osszeg = $req->cel_osszeg;
        $data->budzse = $req->osszeg;
        $data->hatarido = $req->hatarido;
        $data->letrehozas_datum = now()->format('Y-m-d');
        $data->modositas_datum = now()->format('Y-m-d');

        $data->Save();

        if(Auth::check()){
            return redirect("/goals")->with(["success" => "Sikeres célhozzáadás!"]);
        }
        else{
            return redirect("login");
        }
    }

    public function GoalsMod($cel_id)
    {
        $result = celok::find($cel_id);
        if(Auth::check()){
            return view("goalsmod", [
                "result" => $result
            ]);
        }
        else{
            return redirect("login");
        }
    }

    public function GoalsModBtn(Request $req)
    {
        $req->validate([
            "nev"               =>  "required|max:150",
            "cel_osszeg"        =>  "required",
            "osszeg"            =>  "required",
            "hatarido"          =>  "required|date|date_format:Y-m-d",
            "statusz"           =>  "required|in:aktív,teljesítve,törölve"
        ], [
            "*.required"                =>  "Kérem töltse ki a mezőt!",
            "nev.unique"                =>  "Már létezik ".$req->nev." nevű célja!",
            "hatarido.date"             =>  "Valós dátumot adjon meg!",
            "hatarido.date_format"      =>  "A dátum helyes formátuma éééé-hh-nn!",
            "statusz.in"                =>  "A cél státusza 'aktív', 'teljesítve', vagy 'törölve' lehet!"
        ]);

        $data = celok::find($req->cel_id);
        $data->user_id = Auth::user()->id;
        $data->cel_nev = $req->nev;
        $data->cel_osszeg = $req->cel_osszeg;
        $data->budzse = $req->osszeg;
        $data->hatarido = $req->hatarido;
        $data->modositas_datum = now()->format('Y-m-d');
        $data->statusz = $req->statusz;
        $data->Save();
        if(Auth::check()){
            return redirect("/goals")->with(["success" => "Sikeres célmódosítás!"]);
        }
        else{
            return redirect("login");
        }

    }

    public function GoalsDelete($cel_id){
        if(Auth::check()){
            $data = celok::find($cel_id);
            $data->Delete();
            return redirect("/goals")->with(["success" => "Sikeresen törölte a célt."]);
        }
        else{
            return redirect("login");
        }
    }


    public function MyData(){
        $user = Auth::id();
        $first_day_of_the_current_month = Carbon::now()->startOfMonth()->toDateString();
        $last_day_of_the_current_month = Carbon::now()->endOfMonth()->toDateString();

        if (Auth::check()) {
            return view("limit", [
                "result" => koltseglimit::where("user_id", $user)
                                        ->first(),
                "pays" => fix::join("szamla", "szamla.szamla_id", "=", "fix.szamla_id")
                                ->where("fix.user_id", $user)
                                ->where("szamla.tipus", 0)
                                ->where("fix.aktiv", 1)
                                ->get(),
                "incomes" => fix::join("szamla", "szamla.szamla_id", "=", "fix.szamla_id")
                                ->where("fix.user_id", $user)
                                ->where("szamla.tipus", 1)
                                ->where("fix.aktiv", 1)
                                ->get(),
                "has_limit" => koltseglimit::where("user_id", $user)->first(),
                "sum_prices" => koltseglimit::join("users", "koltseg_limit.user_id", "users.id")
                                        ->join("szamla", "szamla.user_id", "users.id")
                                        ->whereDate("szamla.datum", ">=", $first_day_of_the_current_month)
                                        ->whereDate("szamla.datum", "<=", $last_day_of_the_current_month)
                                        ->where("szamla.user_id", $user)
                                        ->where("szamla.tipus", 0)
                                        ->where("szamla.aktiv", 1)
                                        ->sum("szamla.osszeg"),


            //https://laracasts.com/discuss/channels/laravel/getting-the-first-and-last-date-of-the-current-month-and-past-2-months
            ]);
        }
        else {
            return redirect("login");
        }
    }

    public function MyDataSet(Request $req){
        $req->validate([
            "paylimit" => "required|numeric",
        ], [
            "*.required" => "Töltse ki a mezőt!",
            "paylimit.numeric" => "Számot adjon meg!",
        ]);
        $data = new koltseglimit();
        $data->user_id = Auth::user()->id;
        $data->osszeg = $req->paylimit;
        $data->Save();

        if (Auth::check()) {
            return redirect("limit");
        }
        else {
            return redirect("login");
        }
    }

    public function LimitExit($szamla_id)
    {
        $fix = fix::where('szamla_id', $szamla_id)
                    ->where('user_id', Auth::id())
                    ->first();

        $fix->aktiv = 0;
        $fix->Save();

        return redirect('/limit')->with('success', 'A fix tétel törölve lett. Már nem fog frissülni a feltüntetett dátumokkor');
    }
}
