<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FelhasznaloiVelemenyek;
use Illuminate\Support\Facades\Auth;
use App\Mail\ReviewMail;
use Illuminate\Support\Facades\Mail;

class ReviewController extends Controller
{
    public function ShowReview()
    {
        if (Auth::check()) {
            return view("/review");
        } else {
            return redirect("/login");
        }
    }

    public function ReviewBtn(Request $req)
    {
        $req->validate([
            "typeSelect"            => "required|in:otlet,hiba,tanacs,fejlesztes,egyeb",
            "reviewText"            => "required|min:10"
        ], [
            "typeSelect.required"   => "Válasszon típust!",
            "typeSelect.in"         => "Csak a megadott mezők egyike lehet!",
            "reviewText.required"   => "Adja meg a leírást!",
            "reviewText.min"        => "Minimum 10 karakter írása szükséges!"
        ]);

        $mailText = $req->reviewText;
        $mailReviewType = $req->typeSelect;

        $data = new FelhasznaloiVelemenyek;
        $data->user_id = Auth::id();
        $data->szoveg = $req->reviewText;
        $data->tipus = $req->typeSelect;
        $data->created_at = now();

        $data->save();
        Mail::to("sigmawallet01@gmail.com")->send(new ReviewMail($mailText, $mailReviewType));

        return redirect("main")->with(["success" => "Sikeresen beküldte véleményét, nagyon köszönjük!"]);
    }
}
