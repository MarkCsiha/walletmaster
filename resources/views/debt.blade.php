@extends('layout')
@push('debt-css')
    <link rel="stylesheet" href="{{ asset('css/debt.css') }}">
@endpush
@section('content')
    <main class="container pb-2">
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
        <div class="card table-responsive">
            <div class="card-body">

                <table class="table table bordered table-hover table-responsive">
                    <tr>
                        <th>Összeg: </th>
                        <th>Személy: </th>
                        <th>Felhasználónév: </th>
                        <th>Leírás: </th>
                        <th>Típus: </th>
                        <th>Dátum: </th>
                        <th>Státusz: </th>
                        <th></th>
                    </tr>

                    @foreach ($allDebt as $debt)
                        <tr>
                            <td>
                                @if ($debt->tipus == 1)
                                    <span class="minus">- {{ $debt->osszeg }} Ft</span>
                                @else
                                    <span class="plus">+ {{ $debt->osszeg }} Ft</span>
                                @endif
                            </td>

                            <td>{{ $debt->partner_nev }}</td>
                            {{-- kiírja a felhasználónevet, de csak ha nem üres, lehet kell majd bele más td is null esetén --}}
                            <td>{{ $debt->partner_username ?? '' }}</td>

                            <td>{{ $debt->leiras }}</td>
                            <td>
                                @if ($debt->tipus == 1)
                                    <span class="minus">Tartozás</span>
                                @else
                                    <span class="plus">Másik fél</span>
                                @endif
                            </td>
                            <td>{{ $debt->datum }}</td>
                            <td>{{ $debt->statusz }}</td>
                            <form action="/debts/{{ $debt->tartozasok_id }}/done" method="POST" id="debtDone">
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
                <a href="/debts/pending" class="mx-auto debtReqA">Más felhasználóktól kapott tartozási kérelmek</a>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                <form id="debtForm" method="POST" action="/debt">
                    @csrf
                    <label class="form-label mt-3" for="debtToFrom">Ki tartozik:</label>
                    <select name="debtToFrom" id="debtToFrom" class="rounded-pill">
                        <option value="debtTo">Én</option>
                        <option value="debtFrom">A másik fél</option>
                    </select>
                    <br>
                    <label for="name" class="form-label mt-3">Mi a neve?</label>
                    <input class="form-control @error('name') is-invalid @enderror rounded-pill" type="text"
                        name="name" id="name">

                    <label for="username" class="form-label mt-3">Mi a felhasználóneve? (Ha nem WalletMaster felhasználó,
                        kérjük hagyja üresen)</label>
                    <input type="text" class="form-control @error('username') is-invalid @enderror rounded-pill"
                        type="text" name="username" id="username">

                    <label for="debtAmount" class="form-label mt-3">Összeg: </label>
                    <input type="number" class="form-control @error('amount') is-invalid @enderror rounded-pill"
                        name="debtAmount" id="debtAmount">

                    <label for="description" class="form-label mt-3">Leírás, ha szükséges: </label>
                    <input type="textbox" class="form-control @error('description') is-invalid @enderror rounded-pill"
                        type="text" name="description" id="description">

                    <label for="debtDate" class="form-label mt-3">Dátum: </label>
                    <input type="date" class="form-control @error('date') is-invalid @enderror rounded-pill"
                        name="debtDate" id="debtDate">

                    <button type="submit" class="btn btn-dark mt-3 animationBtn rounded-pill">Tartozás felvitele</button>
                </form>
            </div>
        </div>
    </main>
@endsection
