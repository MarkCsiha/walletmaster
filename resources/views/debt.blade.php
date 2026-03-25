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
                    <table class="table table bordered">
                        <tr>
                            <th>Összeg: </th>
                            <th>Személy: </th>
                            <th>Felhasználónév: </th>
                            <th>Leírás: </th>
                            <th>Típus: </th>
                            <th>Dátum: </th>
                            <th>Státusz: </th>
                            <th>Teljesítve? </th>
                        </tr>

                        @foreach ($allDebt as $debt)
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
                                <form action="/debts/{{ $debt->tartozasok_id }}/done" method="POST"
                                    id="debtDone">
                                    @csrf
                                    <td>
                                        @if ($debt->statusz != 'rendezve')
                                            <button type="submit" class="btn shadow-none"><i
                                                    class="bi bi-check-circle text-success"></i></button>
                                        @endif
                                    </td>
                                </form>
                            </tr>
                        @endforeach
                    </table>
                {{-- <div class="d-flex justify-content-center">
                        {{$result->links('pagination::bootstrap-4')}}
                    </div> --}}

            </div>
        </div>
        <a href="/debt/pending">Más felhasználóktól kapott tartozási kérelmek</a>
        <form id="debtForm" method="POST" action="/debt">
            @csrf
            <label class="form-label mt-3" for="debtToFrom">Ki tartozik:</label>
            <select name="debtToFrom" id="debtToFrom">
                <option value="debtTo">Én</option>
                <option value="debtFrom">A másik fél</option>
            </select>
            <label for="name" class="form-label mt-3">Mi a neve?</label>
            <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name">

            <label for="username" class="form-label mt-3">Mi a felhasználóneve? (Ha nem WalletMaster felhasználó, kérjük
                hagyja üresen)</label>
            <input type="text" class="form-control @error('username') is-invalid @enderror" type="text"
                name="username" id="username">

            <label for="debtAmount" class="form-label mt-3">Összeg: </label>
            <input type="number" class="form-control @error('amount') is-invalid @enderror" name="debtAmount"
                id="debtAmount">

            <label for="description" class="form-label mt-3">Leírás, ha szükséges: </label>
            <input type="textbox" class="form-control @error('description') is-invalid @enderror" type="text"
                name="description" id="description">

            <label for="debtDate" class="form-label mt-3">Dátum: </label>
            <input type="date" class="form-control @error('date') is-invalid @enderror" name="debtDate" id="debtDate">

            <button type="submit" id="animationBtn">Tartozás felvitele</button>
        </form>
    </main>
@endsection
