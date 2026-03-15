@extends('layout')

@push('debt-css')
    <link rel="stylesheet" href="{{ asset('css/debt.css') }}">
@endpush

@section('content')
    <main class="container pb-2">
        <div class="col-md-9">
            {{-- error --}}
        </div>
        <h1 class="p-3">Tartozások</h1>
        <div id="outerpanel">
            <div class="card table-responsive">
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

                        @foreach ($allDebt as $debt)
                            <tr>
                                <td>
                                    @if ($debt->tipus == 0)
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
                                    @if ($debt->tipus == 0)
                                        <span class="text-danger">Tartozás</span>
                                    @else
                                        <span class="text-success">Másik fél</span>
                                    @endif
                                </td>
                                <td>{{ $debt->datum }}</td>
                                <td>{{ $debt->status }}</td>
                                {{-- <td>{{$szamlak->fix}}</td>
                                <td>{{ date_format(date_create($szamlak->datum), "Y. m. d")}}</td> --}}
                            </tr>
                        @endforeach
                    </table>

                    {{-- <div class="d-flex justify-content-center">
                        {{$result->links('pagination::bootstrap-4')}}
                    </div> --}}

                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body">
                    <form id="debtForm" method="POST" action="/debt">
                        @csrf

                        <label for="deptToFrom">Ki tatozik kinek</label>
                        <select type="text" name="deptToFrom" id="deptToFrom" class="form-control rounded-pill">
                            <option value="debtTo">Én</option>
                            <option value="debtFrom">A másik fél</option>
                        </select>

                        <label class="form-label mt-3" for="name">A tartozó fél neve:</label>
                        <input type="text" class="form-control rounded-pill @error('name') is-invalid @enderror"
                            name="name" id="name">

                        <label for="username" class="form-label mt-3">Mi a felhasználóneve? (Ha nem WalletMaster
                            felhasználó, kérjük hagyja üresen)</label>
                        <input type="text" class="form-control rounded-pill  @error('username') is-invalid @enderror"
                            type="text" name="username" id="username">

                        <label for="debtAmount" class="form-label mt-3">Összeg: </label>
                        <input type="number" class="form-control rounded-pill  @error('debtAmount') is-invalid @enderror"
                            name="debtAmount" id="debtAmount">

                        <label for="description" class="form-label mt-3">Leírás, ha szükséges: </label>
                        <input type="textbox" class="form-control rounded-pill  @error('description') is-invalid @enderror"
                            type="text" name="description" id="description">

                        <label for="debtDate" class="form-label mt-3">Dátum: </label>
                        <input type="date" class="form-control rounded-pill  @error('debtDate') is-invalid @enderror"
                            name="debtDate" id="debtDate">

                        <div class="btn">
                            <button type="submit" class="btn btn-dark mt-3" id="button">Tartozás felvitele</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection
