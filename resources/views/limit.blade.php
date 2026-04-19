@extends('layout')

@push('limit-css')
    <link rel="stylesheet" href="{{ asset('css/limit.css') }}">
@endpush

@section('content')
    @if (session('success'))
        <div class="alert alert-success text-success text-center w-50 py-1 mx-auto mt-3">
            <i class="bi bi-check-circle-fill">
                {{ session('success') }}
            </i>
        </div>
    @elseif (session('unsuccessful'))
        <div class="alert alert-danger text-danger text-center w-50 py-1 mx-auto mt-3">
            <i class="bi bi-exclamation-triangle-fill">
                {{ session('unsuccessful') }}
            </i>
        </div>
    @endif
    <header class="py-5">
        <div class="container px-lg-5">
            <div class="row gx-lg-5">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body p-4 p-md-5">

                            <h1 class="display-5 fw-bold mb-4">Számla adataim</h1>

                            <div class="mt-3">
                                @if ($result)
                                    <h3 class="fw-semibold mb-2">Költség limit:</h3>

                                    <p class="fs-4 fw-semibold mb-4">
                                        {{ $result->osszeg - $sum_prices }} Ft maradt a(z) {{ $result->osszeg }}-ből
                                    </p>

                                    <div class="progress my-4" role="progressbar" aria-label="Basic example"
                                        aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"
                                        style="height: 32px; background-color: #f8f9fa; border-radius: 50px;">
                                        <div class="progress-bar"
                                            style="width:{{ ($sum_prices / $result->osszeg) * 100 }}%; background: greenyellow; border-radius: 50px;">
                                        </div>
                                    </div>
                                @else
                                    <h3 class="fw-semibold mb-2">Költség limit:</h3>

                                    <p class="fs-4 fw-semibold mb-4">
                                        Még nincs megadva költséglimit.
                                    </p>
                                @endif
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
                            @if ($has_limit == null)
                                <h2 class="fs-4 fw-bold">Havi költséglimit megadása</h2>
                            @else
                                <h2 class="fs-4 fw-bold">Havi költséglimit módosítása</h2>
                            @endif

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
                                    <p style="color: #FDEBE7">{{ $message }}</p>
                                @enderror
                                <button class="btn btn-dark mt-4 animationBtn rounded-pill" type="submit">Mentés</button>
                            @else
                                <label class="form-label" for="paylimit">Limit módosítása:</label>
                                <input type="number" class="form-control rounded-pill mb-3" id="paylimit" name="paylimit">
                                @error('paylimit')
                                    <p style="color: #FDEBE7">{{ $message }}</p>
                                @enderror
                                <button class="btn btn-dark mt-4 animationBtn rounded-pill" type="submit">Mentés</button>
                            @endif
                        </form>
                        @if ($has_limit != null)
                            <form action="/limitdelete/{limit_id}" method="post">
                                @csrf
                                <button onclick="return confirm('Biztosan törli a költséglimitet?')"
                                    class="btn btn-danger mt-4 animationBtnDel rounded-pill" type="submit">Költséglimit
                                    törlése</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row gx-lg-5 mt-5 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h2 class="fs-4 fw-bold">Mentett fix bevételei és kiadásai</h2>
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
                                    <th>Kiadás törlése</th>
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

                                        <td> <button onclick="return confirm('Biztosan törli a költséglimitet?')" class="delBtn"><a href="/limitexit/{{ $p->szamla_id }}"> <i
                                                    class="bi bi-trash-fill text-danger spentTrash"></i> </a></button> </td>
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
                                    <th>Bevétel törlése</th>
                                </tr>

                                @foreach ($incomes as $i)
                                    <tr>
                                        <td>
                                            <span class="plus">+ {{ $i->osszeg }} Ft</span>
                                        </td>
                                        <td>{{ date_format(date_create($i->letrehozas), 'Y. m. d') }}</td>
                                        <td>{{ date_format(date_create($i->fizetve), 'Y. m. d') }}</td>
                                        <td>  <button onclick="return confirm('Biztosan törli a költséglimitet?')" class="delBtn"><a href="/limitexit/{{ $i->szamla_id }}"> <i
                                                    class="bi bi-trash-fill text-danger incomeTrash"></i> </a></button> </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>


                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
