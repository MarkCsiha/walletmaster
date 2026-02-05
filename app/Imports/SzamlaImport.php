<?php

namespace App\Imports;

use App\Models\szamla;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SzamlaImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    
    public function model(array $row)
    {
        $datum = Carbon::createFromFormat('Y. m. d', trim($row['datum']))->format('Y-m-d');
        return new szamla([
            'user_id'       => Auth::id(),
            'osszeg'        => $row['osszeg'],
            'honnan'        => $row['honnan'] ?? null,
            'leiras'        => $row['leiras'] ?? null,
            'fix'           => $row["fix"],
            'kategoria_nev' => $row['kategoria_nev'] ?? null,
            'datum'         => $datum,
        ]);
    }
}
