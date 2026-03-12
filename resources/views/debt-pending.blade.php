@extends('layout')
@push('debt-css')
    <link rel="stylesheet" href="{{ asset('css/debt.css') }}">
@endpush
@section('content')

    <main class="container pb-2">
        <div class="col-md-9">
            {{-- error --}}
        </div>
        <div class="card">
            <div class="col-md-9">
                @if (session('success'))
                    <p class="text text-success text-center">{{ session('success') }}</p>
                @else
                    <p class="text text-danger text-center">{{ session('unsuccessful') }}</p>
                @endif
            </div>
            <div class="card-body">
                @if (count($userDebt) == 0)
                    <h2>Még nincsenek függőben lévő tartozási kérelmei!</h2>
                @else
                    <table class="table table bordered">
                        <tr>
                            <th>Összeg: </th>
                            <th>Személy: </th>
                            <th>Felhasználónév: </th>
                            <th>Leírás: </th>
                            <th>Típus: </th>
                            <th>Dátum: </th>
                            <th>Státusz: </th>
                            <th>Tartozási kérelem elfogadása </th>
                            <th>Tartozási kérelem elutasítása </th>
                        </tr>

                        @foreach ($userDebt as $debt)
                            <tr>
                                <td>
                                    @if ($debt->tipus == 1)
                                        <span class="text-danger">- {{ $debt->osszeg }} Ft</span>
                                    @else
                                        <span class="text-success">+ {{ $debt->osszeg }} Ft</span>
                                    @endif
                                </td>

                                <td>{{ $debt->partner_nev }}</td>
                                {{-- kiírja a felhasználónevet, de csak ha nem üres, lehet kell majd bele más td is null esetén --}}
                                <td>{{ $debt->partner_username ?? '' }}</td>

                                <td>{{ $debt->leiras }}</td>
                                <td>
                                    @if ($debt->tipus == 1)
                                        <span class="text-danger">Tartozás</span>
                                    @else
                                        <span class="text-success">Másik fél</span>
                                    @endif
                                </td>
                                <td>{{ $debt->datum }}</td>
                                <td>{{ $debt->statusz }}</td>
                                {{-- <td>{{$szamlak->fix}}</td>
                                <td>{{ date_format(date_create($szamlak->datum), "Y. m. d")}}</td> --}}
                                <td>
                                    <form class="card-body"
                                        action="{{ route('debts.accept', ['id' => $debt->tartozasok_id]) }}"
                                        method="post">
                                        @csrf
                                        <input type="hidden" name="action" value="elfogadva">

                                        <button class="btn btn-success" type="submit" name="accept"
                                            id="accept">Elfogadom</button>
                                    </form>
                                </td>
                                <td>
                                    <form class="card-body"
                                        action="{{ route('debts.reject', ['id' => $debt->tartozasok_id]) }}"
                                        method="post">
                                        @csrf
                                        <input type="hidden" name="action" value="elutasítva">

                                        <button class="btn btn-danger" type="submit" name="reject"
                                            id="reject">Visszautasítom</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </table>

                    {{-- <div class="d-flex justify-content-center">
                        {{$result->links('pagination::bootstrap-4')}}
                    </div> --}}
                @endif
            </div>
        </div>
    </main>
@endsection
