@extends('layout')

@push('mainstyle-css')
    <link rel="stylesheet" href="{{asset('css/main.css')}}">
@endpush

@section('content')
    <main class="container pb-2">
        <div class="row mt-3">
            <div class="col r-3" id="outerpanel">

                <div class="card" id="kartya">
                    <div class="card-body">
                        {{-- ÉV + HÓNAP --}}
                        <div class="text-center mb-2">
                            <h2 class="m-0">{{ $monthStart->year }}</h2>
                            <h4>{{ $monthStart->translatedFormat('F') }}</h4>
                        </div>

                        {{-- HÓNAP VÁLTÁS --}}
                        <div class="d-flex justify-content-between mb-2">
                            <a class="btn btn-outline-secondary btn-sm text-white" href="{{ route('naptar', ['ym' => $prevYm]) }}">
                                Előző
                            </a>

                            <a class="btn btn-outline-secondary btn-sm  text-white" href="{{ route('naptar', ['ym' => $nextYm]) }}">
                                Következő
                            </a>
                        </div>

                        {{-- NAPTÁR --}}
                        <table class="border border-striped" id="calendar">
                            <tr id="calendar_th">
                                <th>Hétfő</th>
                                <th>Kedd</th>
                                <th>Szerda</th>
                                <th>Csütörtök</th>
                                <th>Péntek</th>
                                <th>Szombat</th>
                                <th>Vasárnap</th>
                            </tr>

                            @foreach(array_chunk($days, 7) as $week)
                                <tr>
                                    @foreach($week as $day)
                                        @php
                                            $inMonth = $day->month === $monthStart->month;
                                        @endphp

                                        <td style="height: 60px; vertical-align: top;" class="{{ $inMonth ? '' : 'text-danger' }}">{{-- napok style legyen tomato --}}
                                            <div style="font-weight: 700;">
                                                {{ $day->day }}
                                            </div>
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>

            <div class="col">
                <p>Diagrammok</p>
            </div>
        </div>

        {{-- Ide jönnek a szűrések... --}}

        <div class="mt-3">

            <div class="card">
                <div class="card-body">

                    <table class="table table bordered">
                        <tr>
                            <th>Összeg</th>
                            <th>Honnan</th>
                            <th>Leíras</th>
                            <th>Kategoria</th>
                            <th>Rendszeres</th>
                            <th>Dátum</th>
                            <th>Módosítás</th>
                            <th>Törlés</th>
                        </tr>

                        @foreach ($result as $szamlak)
                            <tr>
                                <td>
                                    @if($szamlak->tipus == 0)
                                        <span id="minus">- {{$szamlak->osszeg}} Ft</span>
                                    @else
                                        <span id="plus">+ {{$szamlak->osszeg}} Ft</span>
                                    @endif
                                </td>
                                <td>{{$szamlak->honnan}}</td>
                                <td>{{$szamlak->leiras}}</td>
                                <td>{{$szamlak->kategoria}}</td>
                                <td>{{$szamlak->fix}}</td>
                                <td>{{ date_format(date_create($szamlak->datum), "Y. m. d")}}</td>
                                <td class="text-center"> <a href="/mainmod/{{$szamlak->szamla_id}}"> <i class="bi bi-pencil-fill text-warning"></i> </a> </td>
                                <td class="text-center"> <a href="/mainexit/{{$szamlak->szamla_id}}"> <i class="bi bi-trash-fill text-danger"></i> </a> </td>
                            </tr>
                        @endforeach
                    </table>

                    <div class="d-flex justify-content-center">
                        {{$result->links('pagination::bootstrap-4')}}
                    </div>
                    <div id="addbtn"><a href="/add" class="btn btn-dark">Hozzáadás</a></div>
                </div>
            </div>

        </div>
    </main>
@endsection


{{-- Fix hozzáadásnál hozzáadjuk a hónapot, ha a hónap % 12 > 0-nál akkor a maradékot veszi és a lista[maradek+1] hónaphoz lesz beállítva majd és hoozáadva, nem előre hanem ha a datetime.Now() eléri azt az értéket --}}
