@extends("layout")
@section("content")
<main class="container pb-2">
    <div class="card">
        <div class="card-body">
            <p>

            </p>
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
                            @if($userDebt->tipus == 0)
                                <span class="text-danger">- {{$userDebt->osszeg}} Ft</span>
                            @else
                                <span class="text-success">+ {{$userDebt->osszeg}} Ft</span>
                            @endif
                        </td>
                        <td>{{ $userDebt->partner_nev }}</td>
                        <td>{{ $userDebt->partner_username }}</td>
                        <td>{{ $userDebt->leiras }}</td>
                    <td>
                        @if($userDebt->tipus == 0)
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
<form class="card-body" action="{{ route('debts.accept', ['id' => $userDebt->tartozasok_id]) }}" method="post">
        @csrf
        <input type="hidden" name="action" value="elfogadva">

        <button class="btn btn-success" type="submit" name="accept" id="accept">Elfogadom</button>
    </form>
<form class="card-body" action="{{ route('debts.reject', ['id' => $userDebt->tartozasok_id]) }}" method="post">
        @csrf
        <input type="hidden" name="action" value="elutasítva">

        <button class="btn btn-danger" type="submit" name="reject" id="reject">Visszautasítom</button>
    </form>
</main>

@endsection
