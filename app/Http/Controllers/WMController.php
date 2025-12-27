<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\szamla;

class WMController extends Controller
{
    public function Main(){
        return view("main", [
            "result" => szamla::all()
        ]);
    }
}
