<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\szamla;
use App\Models\celok;
use App\Models\fix;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class WMController extends Controller
{
    //https://www.youtube.com/watch?v=2Zy7gHWl5-Y&t=180s
     public function Main(Request $req){
        $user = Auth::id();

        // --- a te meglévő listád (marad) ---
        $result = szamla::where("user_id", $user)
            ->whereMonth('datum', now()->month)
            ->whereYear('datum', now()->year)
            ->orderBy("datum", "desc")
            ->paginate(10);
            //now()->format('m')

        //Ha nem szerepel még az előfizetés a hónapban akkor hozzáadja
        //Először meg kell nézni, hogy benne van e a táblázatban
        //Ha nincs és a dátum megegyezik a fizetve +1hónap/+6hónap/+1év felvesszük

        //Ötlet:
        //sql lekérdezés ha a month(fix.fizetve) + 1  == dateTime.now() then mentes a listába
        //és frissítjük a fix.fizetbe oszlopot, hogy a következő hónapban menjen

        #fix.szamla_id = szamla.szamla_id

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

        //dd($havi);
        #Fix mentést még módosítani kell
        if($havi != null)
        {
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
                $kfix->fizetve = now()->format('Y-m-d'); //De lehetne a mostani dátum is
                $kfix->Save();
            }


        }
        if($feleves != null)
        {
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
                $kfix->fizetve = now()->format('Y-m-d'); //De lehetne a mostani dátum is
                $kfix->Save();
            }

        }
        if($eves != null)
        {
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
                $kfix->fizetve = now()->format('Y-m-d'); //De lehetne a mostani dátum is
                $kfix->Save();
            }

        }

        //SELECT szamla.user_id, szamla.osszeg, szamla.honnan, szamla.leiras, szamla.datum, szamla.fix, szamla.tipus, szamla.kategoria_nev FROM `fix` JOIN szamla on szamla.szamla_id = fix.szamla_id where date_add(fix.fizetve, interval + 1 month) = CURDATE();

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


        //chart
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

    public function MainMod($szamla_id){
        return view("mainmod", [
            "result" => szamla::find($szamla_id)
        ]);
    }

    public function MainModBtn(Request $req){
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
            "datum.date_format"     =>  "A dátum helyes formátuma éééé-hh-nn",
            "datum.before_or_equal" =>  "Nem adjon meg jövőbeli dátumot!"
        ]);
        $data = szamla::find($req->szamla_id);
        $data->osszeg =  $req->osszeg;
        $data->honnan = $req->honnan;
        $data->leiras = $req->leiras;
        $data->datum = $req->datum;
        $data->fix = $req->fix;

        if($req->fix != "nem")
        {
            $kfix = fix::where("szamla_id", $data->szamla_id)->first();
            //A first() azért kell hogy a a where-ből megkapott lekérdezés értékét megkapjam
            //Ha van olyan visszakapom a sort tehát an érték
            //Ha nincs olyan null-t kapok és az else ág fut le
            if($kfix){
                $kfix->tipus = $req->fix;
                $kfix->osszeg = $req->osszeg;
                $kfix->Save();
            }

            else{
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
        if($req->tipus == "bevetel"){
            $data->tipus = 1;
        }
        else{
            $data->tipus = 0;
        }
        $data->kategoria_nev = $req->kategoria;

        $data->Save();

        return redirect("/main");
    }

    public function MainDelete($szamla_id){
        $data = szamla::find($szamla_id);
        $data->Delete();
        return redirect("/main");
    }

    public function Add(){
        return view("add", [
        ]);
    }

    public function AddBtn(Request $req){
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
            "datum.before_or_equal" =>  "Nem adjon meg jövőbeli dátumot!"
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
        if($req->tipus == "bevetel"){
            $data->tipus = 1;
        }
        else{
            $data->tipus = 0;
        }
        $data->kategoria_nev = $req->kategoria;

        $data->Save();

        if($req->fix != "nem")
        {
            $kfix = new fix;
            $kfix->szamla_id = $data->szamla_id;
            $kfix->tipus = $req->fix;
            $kfix->osszeg = $req->osszeg;
            $kfix->letrehozas = $req->datum;
            $kfix->fizetve = $req->datum;
            $kfix->Save();
        }

        return redirect('/main')->with('success','Sikeres mentés!');
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

    public function Goals(){
        $asd = Auth::id();
        return view("goals", [
            "result" => celok::where("user_id", $asd)->orderBy("statusz")->get()
        ]);
    }

    public function GoalsBtn(Request $req){
        $req->validate([
            "nev"               =>  "required|unique:celok,cel_nev|max:150",
            "cel_osszeg"        =>  "required",
            "osszeg"            =>  "required",
            "hatarido"          =>  "required|date|date_format:Y-m-d",
        ], [
            "*.required"                =>  "Kérem töltse ki a mezőt!",
            // "*.min"                     =>  "A minimum megadható összeg: 5000!",
            "nev.unique"                =>  "Már létezik ilyen nevű célja!", //"Már létezik ". nev ." nevű célja!",
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

        return redirect("/goals");
    }

    public function GoalsMod($cel_id){
        return view("goalsmod", [
            "result" => celok::find($cel_id)
        ]);
    }

    public function GoalsModBtn(Request $req){
        $req->validate([
            "nev"               =>  "required|max:150",
            "cel_osszeg"        =>  "required",
            "osszeg"            =>  "required",
            "hatarido"          =>  "required|date|date_format:Y-m-d",
            "statusz"           =>  "required|in:aktív,teljesítve,törölve"
        ], [
            "*.required"                =>  "Kérem töltse ki a mezőt!",
            // "*.min"                     =>  "A minimum megadható összeg: 5000!",
            "nev.unique"                =>  "Már létezik ilyen nevű célja!", //"Már létezik ". nev ." nevű célja!",
            "hatarido.date"             =>  "Valós dátumot adjon meg!",
            "hatarido.date_format"      =>  "A dátum helyes formátuma éééé-hh-nn!",
            "statusz.in"                =>  "A cél státusza aktív, teljesítve, vagx törölve lehet!"
        ]);

        $data = celok::find($req->cel_id);
        $data->user_id = Auth::user()->id;
        $data->cel_nev = $req->nev;
        $data->cel_osszeg = $req->cel_osszeg;
        $data->budzse = $req->osszeg;
        $data->hatarido = $req->hatarido;
        $data->modositas_datum = now()->format('Y-m-d');
        if($req->cel_osszeg <= $req->budzse){
            $data->statusz = "kész";
        }
        else{
            $data->statusz = $req->statusz;
        }


        $data->Save();

        return redirect("/goals");
    }

    public function GoalsDelete($cel_id){
        $data = celok::find($cel_id);
        $data->Delete();
        return redirect("/goals");
    }
}
