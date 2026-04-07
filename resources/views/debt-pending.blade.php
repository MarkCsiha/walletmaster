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
        <div class="card">
            <div class="col-md-9">

            <div class="card-body">
                @if (count($userDebt) == 0)
                    <h2 class="text-center" id="pending-cim">Még nincsenek függőben lévő tartozási kérelmei!</h2>
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
                                <td>
                                    <form class="card-body"
                                        action="/debts/{{ $debt->tartozasok_id }}/accept"
                                        method="post">
                                        @csrf
                                        <input type="hidden" name="action" value="elfogadva">

                                        <button class="btn btn-success animationBtn rounded-pill" type="submit" name="accept">Elfogadom</button>
                                    </form>
                                </td>
                                <td>
                                    <form class="card-body"
                                        action="/debts/{{ $debt->tartozasok_id }}/reject"
                                        method="post">
                                        @csrf
                                        <input type="hidden" name="action" value="elutasítva">

                                        <button class="btn btn-danger animationBtn rounded-pill" type="submit" name="reject">Visszautasítom</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                @endif
            </div>
        </div>
    </main>
@endsection
