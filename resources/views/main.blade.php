@extends('layout')
@section('content')
    <main class="container pb-2">
        <div class="row mt-3">
            <div class="col r-3">
                <table class="border border-striped" style="border-collapse: collapse; text-align: center; width: 100%;">
                    <tr>
                        <th>Hétfő</th>
                        <th>Kedd</th>
                        <th>Szerda</th>
                        <th>Csütörtök</th>
                        <th>Péntek</th>
                        <th>Szombat</th>
                        <th>Vasárnap</th>
                    </tr>

                    @for ($i = 1; $i <= 5; $i++)
                        <tr>
                            @for ($j = 1; $j <= 7; $j++)
                                <td style="height: 60px;">
                                    <p>{{$j}}</p>
                                </td>
                            @endfor
                        </tr>
                    @endfor
                </table>
            </div>
            <div class="col">
                <p>Diagrammok</p>
            </div>
        </div>
        {{-- Ide jönnek a szűrések, pl: összeg, kiadás/bevétel kategoriák(bár arra lehet felesleges a digrammok miatt), helyek, esetleg a leírás szövegére like-al--}}
        <div class="mt-3">
            <table class="table table-bordered">
                <tr>
                    <th>Összeg</th>
                    <th>Honnan</th>
                    <th>Leíras</th>
                    <th>Dátum</th>
                    <th>Típus</th>
                    <th>Rendszeres</th>
                    <th>Kategoria</th>
                </tr>
                @foreach ($result as $szamlak)
                    <tr>
                        {{-- <td>{{$szamlak->szamla_id}}</td> --}}
                        <td>
                            @if($szamlak->tipus == 0)
                                - {{$szamlak->osszeg}}
                            @else
                                + {{$szamlak->osszeg}}
                            @endif
                        </td>
                        <td>{{$szamlak->honnan}}</td>
                        <td>{{$szamlak->leiras}}</td>
                        <td>{{ date_format(date_create($szamlak->datum), "Y. m. d")}}</td>
                        <td>
                            @if($szamlak->tipus == 0)
                                Kiadás
                            @else
                                Bevétel
                            @endif
                        </td>
                        <td>{{$szamlak->fix}}</td>
                        <td>{{$szamlak->kategoria}}</td>
                        {{-- egyhe zöld háttér ha bevétel, egyhe piros háttér ha kiadás --}}
                    </tr>
                @endforeach
            </table>
        </div>
    </main>
@endsection
