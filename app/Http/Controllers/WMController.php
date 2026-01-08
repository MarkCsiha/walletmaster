<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\szamla;
use Illuminate\Support\Facades\Auth;

class WMController extends Controller
{
    // public function Main(){
    //     return view("main", [
    //         "result" => szamla::all()
    //     ]);
    // }

    public function Main(){
        $asd = Auth::id();
        return view("main", [
            "result" => szamla::where("user_id", $asd)->orderBy("datum", "desc")->get()
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
}
