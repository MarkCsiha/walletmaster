<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WMController extends Controller
{
    public function Main(){
        return view("main");
    }
}
