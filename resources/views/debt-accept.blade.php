@extends('layout')
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
                    </tr>

                    <tr>
                        <td>
                            @if ($userDebt->tipus == 0)
                                <span class="text-danger">- {{ $userDebt->osszeg }} Ft</span>
                            @else
                                <span class="text-success">+ {{ $userDebt->osszeg }} Ft</span>
                            @endif
                        </td>
                        <td>{{ $userDebt->partner_nev }}</td>
                        <td>{{ $userDebt->partner_username }}</td>
                        <td>{{ $userDebt->leiras }}</td>
                        <td>
                            @if ($userDebt->tipus == 0)
                                <span class="text-danger">Tartozás</span>
                            @else
                                <span class="text-success">Másik fél</span>
                            @endif
                        </td>
                        <td>{{ $userDebt->datum }}</td>
                        <td>{{ $userDebt->statusz }}</td>
                    </tr>

                </table>
            </div>
        </div>
        <form class="card-body" action="/debts/{{ $userDebt->tartozasok_id }}/accept" method="post">
            @csrf
            <input type="hidden" name="action" value="elfogadva">

            <button class="btn btn-success animationBtn" type="submit" name="accept">Elfogadom</button>
        </form>
        <form class="card-body" action="/debts/{{ $userDebt->tartozasok_id }}/reject" method="post">
            @csrf
            <input type="hidden" name="action" value="elutasítva">

            <button class="btn btn-danger animationBtn" type="submit" name="reject">Visszautasítom</button>
        </form>
    </main>
@endsection
