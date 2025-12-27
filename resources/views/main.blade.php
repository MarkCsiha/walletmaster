@extends('layout')
@section('content')
    <main class="container pb-2">
        <div class="row mt-3">
            <div class="col r-3">
                {{-- @if (session('siker'))
                    <p class="text text-success text-center">{{session("siker")}}</p>
                @endif
                <h1 class="text-center py-3">Főoldal</h1> --}}

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
        <div class="mt-3">
            <table class="table table-bordered">
                <tr>
                    <th>Sorszam</th>
                    <th>Összeg</th>
                    <th>Honnan</th>
                    <th>Leíras</th>
                    <th>Dátum</th>
                </tr>
                @foreach ($result as $szamla)
                    <tr>
                        <td>{{$szamla->szamla_id}}</td>
                        <td>{{$szamla->osszeg}}</td>
                        <td>{{$szamla->honna}}</td>
                        <td>{{$szamla->leiras}}</td>
                        <td>{{$szamla->datum}}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </main>
@endsection
