<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\szamla;
use App\Models\kategoriak;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;



class WMController extends Controller
{
     public function Main(Request $req){
        $asd = Auth::id();

        // --- a te meglévő listád (marad) ---
        $result = szamla::where("user_id", $asd)
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
                "result"     => $result,
            "monthStart" => $monthStart,
            "days"       => $days,
            "prevYm"     => $prevYm,
            "nextYm"     => $nextYm,
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
        $data = new szamla;
        $data->user_id = Auth::user()->id;
        $data->osszeg =  $req->osszeg;
        $data->honnan = $req->honnan;
        $data->leiras = $req->leiras;
        $data->datum = $req->datum;
        $data->fix = $req->fix;
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
