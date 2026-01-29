<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\szamla;
use App\Models\celok;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class WMController extends Controller
{
    public function Main(Request $request){
        $asd = Auth::id();

        #a te meglévő listád (marad)
        $result = szamla::where("user_id", $asd)->orderBy("datum", "desc")->paginate(10);

        #NAPTÁR: hónap kiválasztás query param alapján
        $ym = $request->query('ym', now()->format('Y-m'));

        $monthStart = Carbon::createFromFormat('Y-m', $ym)->startOfMonth();
        $monthEnd   = $monthStart->copy()->endOfMonth();

        #Naptár rács: hétfővel induljon, vasárnappal zárjon
        $gridStart = $monthStart->copy()->startOfWeek(Carbon::MONDAY);
        $gridEnd   = $monthEnd->copy()->endOfWeek(Carbon::SUNDAY);

        $days = [];
        for ($d = $gridStart->copy(); $d->lte($gridEnd); $d->addDay()) {
            $days[] = $d->copy();
        }

        $prevYm = $monthStart->copy()->subMonth()->format('Y-m');
        $nextYm = $monthStart->copy()->addMonth()->format('Y-m');

        return view("main", [
            "result"     => $result,
            "monthStart" => $monthStart,
            "days"       => $days,
            "prevYm"     => $prevYm,
            "nextYm"     => $nextYm,
        ]);
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
        $data->kategoria = $req->kategoria;

        $data->Save();

        return redirect("/main");
    }

    public function Index(Request $req)
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
        $data = szamla::find($req->id);
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
        $data->kategoria = $req->kategoria;

        $data->Save();

        return redirect("/main");
    }

    public function MainAlert($szamla_id){
        return view('mainalert', [
            "result" => szamla::find($szamla_id)
        ]);
    }

    public function MainDelete($szamla_id){
        $data = szamla::find($szamla_id);
        $data->Delete();
        return redirect("/main");
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

