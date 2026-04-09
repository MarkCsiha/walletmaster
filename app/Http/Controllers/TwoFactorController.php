<?php

namespace App\Http\Controllers;

use App\Mail\SendCodeMail;
use Illuminate\Http\Request;
use App\Models\FelhasznaloiKodok;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class TwoFactorController extends Controller
{
    public function TwoFactorShow() {
     


        return view("/twofactor");
    }
}
