@extends('layout')

@push('debt-css')
    <link rel="stylesheet" href="{{ asset('css/debt.css') }}">
@endpush

@section('content')
<main class="container pt-4 pb-2 debt-page">
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
            @if (count($userDebt) == 0)
                <div class="cim">
                    <h2 class="text-center text-white">Még nincsenek függőben lévő tartozási kérelmei!</h2>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table align-middle">
                        <tr>
                            <th>Összeg</th>
                            <th>Személy</th>
                            <th>Felhasználónév</th>
                            <th>Leírás</th>
                            <th>Típus</th>
                            <th>Dátum</th>
                            <th>Státusz</th>
                            <th>Elfogadás</th>
                            <th>Elutasítás</th>
                        </tr>

                        @foreach ($userDebt as $debt)
                            <tr>
                                <td>
                                    @if ($debt->tipus == 1)
                                        <span class="minus">- {{ $debt->osszeg }} Ft</span>
                                    @else
                                        <span class="plus">+ {{ $debt->osszeg }} Ft</span>
                                    @endif
                                </td>

                                <td>{{ $debt->partner_nev }}</td>
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

                                <td>
                                    <form action="/debts/{{ $debt->tartozasok_id }}/accept" method="post">
                                        @csrf
                                        <input type="hidden" name="action" value="elfogadva">
                                        <button class="btn btn-success animationBtn rounded-pill" type="submit">
                                            Elfogadom
                                        </button>
                                    </form>
                                </td>

                                <td>
                                    <form action="/debts/{{ $debt->tartozasok_id }}/reject" method="post">
                                        @csrf
                                        <input type="hidden" name="action" value="elutasítva">
                                        <button class="btn btn-danger animationBtnDel rounded-pill" type="submit">
                                            Visszautasítom
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            @endif
        </div>
    </div>
</main>
@endsection
