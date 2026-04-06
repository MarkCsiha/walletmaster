@extends('layout')

@push('limit-css')
    <link rel="stylesheet" href="{{ asset('css/limit.css') }}">
@endpush

@section('content')
    <header class="py-5">
        <div class="container px-lg-5">
            <div class="row gx-lg-5">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body p-4 p-md-5">

                            <h1 class="display-5 fw-bold mb-4">Számla adataim</h1>

                            <div class="mt-3">
                                <h3 class="fw-semibold mb-2">Költség limit:</h3>

                                <p class="fs-4 fw-semibold mb-4">
                                    {{ $result->osszeg - $sum_prices }} Ft maradt a(z) {{ $result->osszeg }}-ből
                                </p>

                                <div class="progress my-4" role="progressbar" aria-label="Basic example" aria-valuenow="50"
                                    aria-valuemin="0" aria-valuemax="100"
                                    style="height: 32px; background-color: #f8f9fa; border-radius: 50px;">
                                    <div class="progress-bar"
                                        style="width:{{ (($result->osszeg - $sum_prices) / $result->osszeg) * 100 }}%; background: greenyellow; border-radius: 50px;">
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between mt-2">
                                    <h5 class="mb-0 fw-medium">{{ $result->start_date }}</h5>
                                    <h5 class="mb-0 fw-medium">{{ $result->finish_date }}</h5>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <section class="pt-4">
        <div class="container px-lg-5">
            <div class="row gx-lg-5">
                <div class="card">
                    <div class="card-body">
                        <form action="/limit" method="post">
                            @csrf
                            <h2 class="fs-4 fw-bold">Havi költséglimit megadása</h2>
                            <p>A havi költségkeret minden hónap végén automatikusan megújul.</p>
                            <p>Ha a rögzített kiadások összege meghaladja a beállított havi limitet, a rendszer továbbra is
                                lehetővé teszi új tételek hozzáadását, azonban a rendelkezésre álló keret negatív egyenleget
                                mutathat.</p>
                            <p>A funkció célja, hogy a felhasználó pontos képet kapjon havi pénzügyi teljesítéséről, és
                                időben
                                észlelhesse a tervezett keret túllépését.</p>

                            @if ($has_limit == null)
                                <label class="form-label" for="paylimit">Új limit megadása:</label>
                                <input type="number" class="form-control rounded-pill mb-3" id="paylimit" name="paylimit">
                                @error('paylimit')
                                    <p style="color: tomato" class="text-danger">{{ $message }}</p>
                                @enderror

                                <label class="form-label" for="start_date">Kezdő dátum:</label>
                                <input type="date" class="form-control rounded-pill mb-3" id="start_date"
                                    name="start_date">
                                @error('start_date')
                                    <p style="color: tomato" class="text-danger">{{ $message }}</p>
                                @enderror

                                <label class="form-label" for="finish_date">Végző dátum:</label>
                                <input type="date" class="form-control rounded-pill mb-3" id="finish_date"
                                    name="finish_date">
                                @error('finish_date')
                                    <p style="color: tomato" class="text-danger">{{ $message }}</p>
                                @enderror

                                <button class="btn btn-success mt-3" type="submit">Mentés</button>
                            @else
                                <label class="form-label" for="paylimit">Limit módosítása:</label>
                                <input type="number" class="form-control rounded-pill mb-3" id="paylimit" name="paylimit">
                                @error('paylimit')
                                    <p style="color: tomato" class="text-danger">{{ $message }}</p>
                                @enderror

                                <label class="form-label" for="start_date">Kezdő dátum módosítása:</label>
                                <input type="date" class="form-control rounded-pill mb-3" id="start_date"
                                    name="start_date">
                                @error('start_date')
                                    <p style="color: tomato" class="text-danger">{{ $message }}</p>
                                @enderror

                                <label class="form-label" for="finish_date">Végző dátum módosítása:</label>
                                <input type="date" class="form-control rounded-pill mb-3" id="finish_date"
                                    name="finish_date">
                                @error('finish_date')
                                    <p style="color: tomato" class="text-danger">{{ $message }}</p>
                                @enderror

                                <button class="btn btn-success mt-3" type="submit">Mentés</button>
                            @endif
                        </form>
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
                                     Összekötni a szamlaval és plusz adatokat a továbbiaknál kiírni --}}
                                @foreach ($pays as $p)
                                    <tr>
                                        <td>
                                            <span class="minus">- {{ $p->osszeg }} Ft</span>
                                        </td>
                                        <td>{{ date_format(date_create($p->letrehozas), 'Y. m. d') }}</td>
                                        <td>{{ date_format(date_create($p->fizetve), 'Y. m. d') }}</td>
                                        {{-- <td class="text-center"> <a href="/limitmore/{{ $p->szamla_id }}"> <i
                                                    class="bi bi-pencil-fill text-warning"></i> </a>
                                        </td> --}}

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
                                        {{-- <td class="text-center"> <a href="/limitmore/{{ $p->szamla_id }}"> <i
                                                    class="bi bi-pencil-fill text-warning"></i> </a>
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
