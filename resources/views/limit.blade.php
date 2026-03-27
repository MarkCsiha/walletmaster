@extends('layout')

@push('limit-css')
    <link rel="stylesheet" href="{{ asset('css/limit.css') }}">
@endpush

@section('content')
    <header class="py-5">
        <h1 class="display-5 fw-bold">Számla adataim</h1>
        {{-- Ide kiírni a havi limit kimutatást a képek mintájára--}}
        <p></p>
    </header>

    <section class="pt-4">
        <div class="container px-lg-5">
            <div class="row gx-lg-5">
                <div class="card">
                    <div class="card-body">
                        <h2 class="fs-4 fw-bold">Havi költséglimit megadása</h2>
                        <p>A havi költségkeret minden hónap végén automatikusan megújul.</p>
                        <p>Ha a rögzített kiadások összege meghaladja a beállított havi limitet, a rendszer továbbra is
                            lehetővé teszi új tételek hozzáadását, azonban a rendelkezésre álló keret negatív egyenleget
                            mutathat.</p>
                        <p>A funkció célja, hogy a felhasználó pontos képet kapjon havi pénzügyi teljesítéséről, és időben
                            észlelhesse a tervezett keret túllépését.</p>
                        <label for="paylimit">Új limit megadása:</label>
                        <input type="number" class="rounded-pill" id="paylimit" name="paylimit"> Ft
                        <br>
                        <button class="btn btn-success mt-3" type="submit">Mentés</button>
                    </div>
                </div>
            </div>
            <div class="row gx-lg-5 mt-5 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h2 class="fs-4 fw-bold">Mentett fix kiadásai</h2>
                        <p>Az alábbi listában a rögzített rendszeres kiadások és bevételek láthatók.</p>
                        <p>Ezek az összegek a megadott időpontban válnak ismét esedékessé.</p>
                        <p>Kérjük, hogy az adott napon lépjen be a rendszerbe a tételek rögzítéséhez. Amennyiben ez nem
                            történik meg, az adott kiadás vagy bevétel nem kerül mentésre.</p>

                        <h3>Kiadások:</h3>
                        <div class="table-responsive">
                            <table class="table table bordered">
                                <tr>
                                    <th>Összeg</th>
                                    <th>Létrehozva</th>
                                    <th>Következő fizetés</th>
                                    <th></th>
                                    <th></th>
                                </tr>

                                {{-- Havi mentés egyszerűsíteni
                                     Összekötni a szamlaval és plusz adatokat a továbbiaknál kiírni--}}
                                @foreach ($pays as $p)
                                    <tr>
                                        <td>
                                            <span class="minus">- {{ $p->osszeg }} Ft</span>
                                        </td>
                                        <td>{{ date_format(date_create($p->letrehozas), 'Y. m. d') }}</td>
                                        <td>{{ date_format(date_create($p->fizetve), 'Y. m. d') }}</td>
                                        <td class="text-center"> <a href="/limitmore/{{ $p->szamla_id }}"> <i
                                                    class="bi bi-pencil-fill text-warning"></i> </a>
                                        </td>

                                    </tr>
                                @endforeach
                            </table>
                        </div>

                        <h3>Bevételek:</h3>
                        <div class="table-responsive">
                            <table class="table table bordered">
                                <tr>
                                    <th>Összeg</th>
                                    <th>Létrehozva</th>
                                    <th>Következő fizetés</th>
                                    <th></th>
                                    <th></th>
                                </tr>

                                @foreach ($incomes as $i)
                                    <tr>
                                        <td>
                                            <span class="plus">+ {{ $i->osszeg }} Ft</span>
                                        </td>
                                        <td>{{ date_format(date_create($i->letrehozas), 'Y. m. d') }}</td>
                                        <td>{{ date_format(date_create($i->fizetve), 'Y. m. d') }}</td>
                                        {{-- <td class="text-center"> <a href="/mainmod/{{ $i->szamla_id }}"> <i
                                                    class="bi bi-pencil-fill text-warning"></i> </a>
                                        </td>
                                        <td class="text-center"> <a href="/mainexit/{{ $i->szamla_id }}"> <i
                                                    class="bi bi-trash-fill text-danger"></i> </a>
                                        </td> --}}
                                    </tr>
                                @endforeach
                            </table>
                        </div>


                    </div>
                </div>
            </div>

        </div>
        </div>
    </section>
@endsection
